<?php

include_once "../utils/function.php";

startSecureSession();

include_once "../utils/regex.php";

include_once "./partials/top.php";

// $data = [
//     'secret'   => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
//     'response' => $_POST['g-recaptcha-response'],
// ];

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// $result = curl_exec($ch);
// print_r($result);
// curl_close($ch);

$errors = [];
$successes = [];

/**
 * ******************** [1] Check if submitted form is valid
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Is method allowed ?
    if (isset($_POST['username']) && trim($_POST['username']) !== '') { // Required field value
        // OK
        $email = trim($_POST['username']);
        if (!preg_match($validPatterns['email'], $email)) { // Format check
            // KO
            $errors[] = "Le champ 'Email' doit respecter le format d'une email (ex. : john.doe@mailbox.com).";
        }
    } else { // KO
        $errors[] = "Le champ 'Email' est obligatoire. Merci de saisir une valeur.";
    }

    if (isset($_POST['password']) && trim($_POST['password']) !== '') { // Required field value
        // OK
        $password = trim($_POST['password']);
    } else { // KO
        $errors[] = "Le champ 'Choix du mot de passe' est obligatoire. Merci de saisir une valeur.";
    }
} else { // KO
    // "405 - Method Not Allowed" error handling
    header('Location: ../405.php');
    exit;
}

/**
 * ******************** [2-A] Submitted form is valid ➔ Data sanitization and escaping
 */

if (count($errors) === 0) {
    // TODO: Escaping (addslashes()) is unecessary as we later use a prepared statement
    $email = addslashes(htmlspecialchars($email, ENT_NOQUOTES | ENT_SUBSTITUTE));

    /**
     * ******************** [3] Create the corresponding record in database
     */
    // FIXME: Export sensitive data elsewhere
    $host = 'localhost';
    $dbName = DB_CONNECT["dbName"];
    $user = DB_CONNECT["user"]; // Your MySQL user username
    $pass = DB_CONNECT["pass"]; // Your MySQL user password


    $connection = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT COUNT(*) FROM `user` WHERE `email` = :email";

    $queryParams = [
        ':email' => $email,
    ];

    $statement = $connection->prepare($query);

    if ($statement->execute($queryParams) && $statement->fetchColumn() !== 0) { // The user exists
        $query = "SELECT `last_name`, `first_name`, `password` FROM `user` WHERE `email` = :email";

        $statement = $connection->prepare($query);
        $statement->execute($queryParams);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            $firstName = $user['first_name'];
            $lastName = $user['last_name'];

            $sixDigitsCode = digitsCode();

            $_SESSION['is_logged'] = true;
            $_SESSION['mfa_validation'] = $sixDigitsCode;
            $_SESSION['user'] = ['first_name' => $firstName, 'last_name' => $lastName];

            fakeMailSend("$firstName $lastName", "MFA Validation", $sixDigitsCode);

            $successes[] = "Authentification réussie";
        } else {
            $errors[] = "Email ou mot de passe incorrect : veuillez tenter de vous connecter de nouveau.";
        }
    } else {
        $errors[] = "Aucun utilisateur correspondant n'a été trouvé : veuillez tenter de vous connecter de nouveau.";
    }

    $connection = null;
}

/**
 * ******************** [2-B] Submitted form is not valid (some errors occured)
 */

 if (count($errors) !== 0) {
    $errorMsg = "<ul>";
    foreach ($errors as $error) {
        $errorMsg .= "<li>$error</li>";
    }
    $errorMsg .= "</ul>";
    echo $errorMsg;
} else { //... or everything is OK
    $successMsg = "<ul>";
    foreach ($successes as $success) {
        $successMsg .= "<li>$success</li>";
    }
    $successMsg .= "</ul>";

    // echo '<pre>';
    // var_dump($_SESSION);
    // echo '</pre>';

?>
<?= $successMsg ?>
<div class="form-container">
    <h4>Code secret - MFA</h4>
    <form class="login-form" action="login_mfa.php" method="post" novalidate="">
        <div class="form-block">
            <label for="secret_code">Code secret reçu par mail</label>
            <input type="number" id="secret-code" name="secret_code" placeholder="Votre code secret à 6 chiffres" required="">
        </div>

        <p><a href="login_mfa.php" alt="Recevoir un nouveau code secret"><i class="light-icon-refresh"></i> Recevoir un nouveau code secret ?</a></p>

        <input type="submit" name="login_mfa_submit" value="Confirmer le code secret">
    </form>
</div>
<?php

}

include_once "./partials/bottom.php";