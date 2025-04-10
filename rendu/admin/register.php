<?php

include_once "./partials/top.php";

include_once "../utils/regex.php";

include_once("../utils/global_settings.php");

$errors = [];
$successes = [];

/**
 * ******************** [1] Check if submitted form is valid
 */

 if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Is method allowed ?
    if (isset($_POST['last_name']) && trim($_POST['last_name']) !== '') { // Required field value
        // OK
        $lastName = trim($_POST['last_name']);
        if (!preg_match($validPatterns['proper_name'], $lastName)) { // Format check
            // KO
            $errors[] = "Le champ 'Votre nom' doit contenir entre 1 et 50 caractères.";
        }
    } else { // KO
        $errors[] = "Le champ 'Votre nom' est obligatoire. Merci de saisir une valeur.";
    }

    if (isset($_POST['first_name']) && trim($_POST['first_name']) !== '') { // Required field value
        // OK
        $firstName = trim($_POST['first_name']);
        if (!preg_match($validPatterns['proper_name'], $firstName)) { // Format check
            // KO
            $errors[] = "Le champ 'Votre prénom' doit contenir entre 1 et 50 caractères.";
        }
    } else { // KO
        $errors[] = "Le champ 'Votre prénom' est obligatoire. Merci de saisir une valeur.";
    }

    if (isset($_POST['birth_date']) && trim($_POST['birth_date']) !== '') { // Required field value
        // OK
        $birthDate = trim($_POST['birth_date']);
        if (!preg_match($validPatterns['date_hyphens_fr'], $birthDate)) { // Format check
            // KO
            $errors[] = "Le champ 'Votre date de naissance' doit être au format DD-MM-AAAA (ex.: 12-06-2001).";
        }
    } else { // KO
        $errors[] = "Le champ 'Votre date de naissance' est obligatoire. Merci de saisir une valeur.";
    }

    if (isset($_POST['email']) && trim($_POST['email']) !== '') { // Required field value
        // OK
        $email = trim($_POST['email']);
        if (!preg_match($validPatterns['email'], $email)) { // Format check
            // KO
            $errors[] = "Le champ 'Email' doit respecter le format d'une email (ex. : john.doe@mailbox.com).";
        } else {
            // FIXME: Check if email already exists in database
        }
    } else { // KO
        $errors[] = "Le champ 'Email' est obligatoire. Merci de saisir une valeur.";
    }

    if (isset($_POST['password']) && trim($_POST['password']) !== '') { // Required field value
        // OK
        $password = trim($_POST['password']);
        if (!preg_match($validPatterns['password_policy'], $password)) { // Format check
            // KO
            $errors[] = "Le champ 'Choix du mot de passe' doit  la politique de mot de passe.";
        } else {
            if (isset($_POST['password_confirm']) && trim($_POST['password_confirm']) !== '') { // Required field value
                // OK
                $passwordConfirm = trim($_POST['password_confirm']);
                if ($passwordConfirm !== $password) { // Confirmation password equality check
                    // KO
                    $errors[] = "Le champ 'Confirmation du mot de passe' doit correspondre au mot de passe choisi.";
                }
            } else { // KO
                $errors[] = "Le champ 'Confirmation du mot de passe' est obligatoire. Merci de saisir une valeur.";
            }
        }
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
    $firstName = addslashes(htmlspecialchars($firstName, ENT_NOQUOTES | ENT_SUBSTITUTE));
    $lastName = addslashes(htmlspecialchars($lastName, ENT_NOQUOTES | ENT_SUBSTITUTE));
    list($day, $month, $year) = explode("-", $birthDate);
    $mysqlBirthDate = "$year-$month-$day";
    // TODO: Check if a user with the same email already exists in database
    $email = addslashes(htmlspecialchars($email, ENT_NOQUOTES | ENT_SUBSTITUTE));
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $currentDateTime = new DateTime();
    $createdAt = $updatedAt = $currentDateTime->format('Y-m-d H:i:s');

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

    $query  = "INSERT INTO `user` (`last_name`, `first_name`, `birth_date`, `email`, `password`, `created_at`, `updated_at`) ";
    $query .= "VALUES (:last_name, :first_name, :birth_date, :email, :password, :created_at, :updated_at)";

    $queryParams = [
        ':last_name' => $lastName,
        ':first_name' => $firstName,
        ':birth_date' => $mysqlBirthDate,
        ':email' => $email,
        ':password' => $hashedPassword,
        ':created_at'=> $createdAt,
        ':updated_at'=> $updatedAt,
    ];

    $statement = $connection->prepare($query);

    if ($statement->execute($queryParams)) {
        $successes[] = 'Votre compte a bien été créé.';
    } else {
        $errors[] = "Une erreur s'est produite lors de la création de votre compte : veuillez contacter l'administrateur du site.";
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
    echo $successMsg;
}

include_once "./partials/bottom.php";