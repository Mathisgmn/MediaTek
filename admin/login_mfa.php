<?php

include_once "../utils/function.php";

startSecureSession();

echo '<pre>' . var_dump($_SESSION) . '</pre>';

include_once "../utils/regex.php";

include_once "./partials/top.php";

$errors = [];
$successes = [];

/**
 * ******************** [1] Check if submitted form is valid
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Is method allowed ?
    if (isset($_POST['secret_code']) && trim($_POST['secret_code']) !== '') { // Required field value
        // OK
        $secretCode = trim($_POST['secret_code']);
        if (!preg_match($validPatterns['six_digits_code'], $secretCode)) { // Format check
            // KO
            $errors[] = "Le champ 'Code secret reçu par mail' doit être constitué de 6 chiffres (ex. : 032516).";
        } elseif ($secretCode !== $_SESSION['mfa_validation']) {
            $errors[] = "Le code secret saisi est incorrect.";
        } else {
            $successes[] = "Authentification validée.";
        }
    } else { // KO
        $errors[] = "Le champ 'Email' est obligatoire. Merci de saisir une valeur.";
    }
} else {
    $_SESSION = [];
    session_destroy();

    // "405 - Method Not Allowed" error handling
    header('Location: ../405.php');
    exit;
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