<?php

include_once "../utils/function.php";

startSecureSession();

include_once "../utils/regex.php";

include_once "./partials/top.php";

$errors = [];
$successes = [];

$captchaMsg = '';

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
        $query = "SELECT `id`, `last_name`, `first_name`, `password`, `locked_at` FROM `user` WHERE `email` = :email";

        $statement = $connection->prepare($query);
        $statement->execute($queryParams);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        $hashedPassword = $user['password'];
        $lockedAt = $user['locked_at'];
        $userId = $user['id'];

        if (!is_null($lockedAt)) { // Account temporary locked
            $now = time();
            $lockoutAccountDuration = $now - strtotime($lockedAt);
            $lockedAt = DateTime::createFromFormat('Y-m-d H:i:s', $lockedAt);
            $errors[] = "DEBUG: Compte suspendu depuis $lockoutAccountDuration secondes.";
            if ($lockoutAccountDuration < LOCKOUT_DURATION) {
                $lockedUntil = $lockedAt->modify('+120 minutes')->format('d/m/Y à H:i:s');
                $errors[] = "Suite à une activité suspecte, votre compte est suspendu jusqu'au $lockedUntil.";
            } else { // Unlock account
                $query = "UPDATE `user` SET `locked_at` = :locked_at WHERE `id` = :user_id";

                $queryParams = [
                    ':locked_at' => NULL,
                    ':user_id' => $userId,
                ];

                $statement = $connection->prepare($query);

                if ($statement->execute($queryParams) && $statement->rowCount() !== 0) {
                    // Account unlocked
                    // TODO: At this point, the user should be able to login
                } else {
                    $errors[] = "Une erreur s'est produite lors de la connexion : veuillez contacter l'administrateur du site.";
                }
            }
        } else { // Account not locked
            if (password_verify($password, $hashedPassword)) {
                $firstName = $user['first_name'];
                $lastName = $user['last_name'];

                $sixDigitsCode = digitsCode();

                $_SESSION['is_logged'] = true;
                $_SESSION['mfa_validation'] = $sixDigitsCode;
                $_SESSION['user'] = ['first_name' => $firstName, 'last_name' => $lastName];

                fakeMailSend("$firstName $lastName", "MFA Validation", $sixDigitsCode);

                $successes[] = "Authentification réussie";
            } else { // Authentication failure: check for an active suspicious activity (X failed attempts in less than Y seconds)
                $query = "SELECT COUNT(*) FROM `login_attempt` WHERE `user_id` = :user_id AND `is_active` = TRUE";

                $queryParams = [
                    ':user_id' => $userId,
                ];

                $statement = $connection->prepare($query);

                if ($statement->execute($queryParams) && $statement->fetchColumn() !== 0) { // At least one attempt already exists
                    $query = "SELECT `id`, `attempts_counter`, `first_attempted_at` FROM `login_attempt` WHERE `user_id` = :user_id AND `is_active` = TRUE";

                    $queryParams = [
                        ':user_id' => $userId,
                    ];

                    $statement = $connection->prepare($query);
                    $statement->execute($queryParams);

                    $loginAttempt = $statement->fetch(PDO::FETCH_ASSOC);

                    $attemptId = $loginAttempt['id'];
                    $attemptsCounter = (int)$loginAttempt['attempts_counter'];
                    $now = time();
                    $attemptDuration = $now - strtotime($loginAttempt['first_attempted_at']);
                    $errors[] = "DEBUG: Période de tentative de $attemptDuration secondes.";
                    if ($attemptDuration < LOCKOUT_ATTEMPTS_WINDOW && $attemptsCounter < LOCKOUT_ATTEMPTS_NUMBER) { // Increment attempts counter
                        $query = "UPDATE `login_attempt` SET `attempts_counter` = (`attempts_counter` + 1) WHERE `id` = :attempt_id";

                        $queryParams = [
                            ':attempt_id' => $attemptId,
                        ];

                        $statement = $connection->prepare($query);

                        if ($statement->execute($queryParams) && $statement->rowCount() !== 0) {
                            // OK
                            $errors[] = $captchaMsg = '<mark>Captcha activé</mark>';
                        } else {
                            $errors[] = "Une erreur s'est produite lors de la connexion : veuillez contacter l'administrateur du site.";
                        }
                    } else {
                        // TODO: The following two queries should be executed within a single transaction
                        $query = "UPDATE `login_attempt` SET `is_active` = FALSE WHERE `id` = :attempt_id";

                        $queryParams = [
                            ':attempt_id' => $attemptId,
                        ];

                        $statement = $connection->prepare($query);

                        if ($statement->execute($queryParams) && $statement->rowCount() !== 0) {
                            // OK
                            if ($attemptsCounter >= LOCKOUT_ATTEMPTS_NUMBER) { // Maximum attempts reached: locking account
                                $query = "UPDATE `user` SET `locked_at` = :locked_at WHERE `id` = :user_id";

                                $queryParams = [
                                    ':locked_at' => (new DateTime())->format('Y-m-d H:i:s'),
                                    ':user_id' => $userId,
                                ];

                                $statement = $connection->prepare($query);

                                if ($statement->execute($queryParams) && $statement->rowCount() !== 0) {
                                    // Locked account
                                } else {
                                    $errors[] = "Une erreur s'est produite lors de la connexion : veuillez contacter l'administrateur du site.";
                                }
                            }
                        } else {
                            $errors[] = "Une erreur s'est produite lors de la connexion : veuillez contacter l'administrateur du site.";
                        }
                    }
                } else { // First attempt
                    $query = "INSERT INTO `login_attempt` VALUES (NULL, :user_id, :server_env_info, :attempts_counter, :first_attempted_at, :is_active) ";

                    $queryParams = [
                        ':user_id' => $userId,
                        ':server_env_info' => serialize($_SERVER),
                        ':attempts_counter' => 1,
                        ':first_attempted_at' => (new DateTime())->format('Y-m-d H:i:s'),
                        ':is_active' => TRUE,
                    ];

                    $statement = $connection->prepare($query);

                    if ($statement->execute($queryParams) && $statement->rowCount() !== 0) {

                    } else {
                        $errors[] = "HERE : Une erreur s'est produite lors de la connexion : veuillez contacter l'administrateur du site.";
                    }
                }
            }
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

    ?>
    <?= $successMsg ?>
    <div class="form-container">
        <h4>Code secret - MFA</h4>
        <form class="login-form" action="login_mfa.php" method="post" novalidate="">
            <div class="form-block">
                <label for="secret_code">Code secret reçu par mail</label>
                <input type="number" id="secret-code" name="secret_code"
                       placeholder="Votre code secret à 6 chiffres"
                       required="">
            </div>

            <p><a href="login_mfa.php" alt="Recevoir un nouveau code secret"><i class="light-icon-refresh"></i>
                    Recevoir
                    un nouveau code secret ?</a></p>

            <input type="submit" name="login_mfa_submit" value="Confirmer le code secret">
        </form>
    </div>
    <?php

}

// prettyDump($_SERVER);

include_once "./partials/bottom.php";