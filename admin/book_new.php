<?php

include_once "../utils/regex.php";

include_once "./partials/top.php";

$errors = [];
$successes = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $title = trim(filter_input(INPUT_GET, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    if ($title !== '') {
        $titleLen = strlen($title);
        if ($titleLen < 2 || $titleLen > 150) {
            $errors[] = "Le champ 'Titre' doit contenir entre 2 et 150 caractères.";
        }
    } else {
        $errors[] = "Le champ 'Titre' est obligatoire. Merci de saisir une valeur.";
    }

    $isbn = trim(filter_input(INPUT_GET, 'isbn', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    if ($isbn !== '') {
        if (!preg_match($validPatterns['isbn'], $isbn)) {
            $errors[] = "Le champ 'ISBN' doit contenir exactement 13 chiffres.";
        }
    } else {
        $errors[] = "Le champ 'ISBN' est obligatoire. Merci de saisir une valeur.";
    }

    $summary = trim(filter_input(INPUT_GET, 'summary', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    if ($summary !== '') {
        $summaryLen = strlen($summary);
        if ($summaryLen > 65535) {
            $errors[] = "Le champ 'Résumé' ne doit pas excéder 65535 caractères.";
        }
    } else {
        $summary = '';
    }

    $publicationYear = trim(filter_input(INPUT_GET, 'publication_year', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    if ($publicationYear !== '') {
        if (!preg_match($validPatterns['year'], $publicationYear)) {
            $errors[] = "Le champ 'Année de publication' doit être au format YYYY (ex. : 1997).";
        }
    } else {
        $errors[] = "Le champ 'Année de publication' est obligatoire. Merci de saisir une valeur.";
    }
} else {
    header('Location: ../405.php');
    exit;
}

if (count($errors) === 0) {
    $title = addslashes($title);
    $isbn = addslashes($isbn);
    $summary = addslashes($summary);
    $publicationYear = addslashes($publicationYear);

    $currentDateTime = new DateTime();
    $createdAt = $updatedAt = $currentDateTime->format('Y-m-d H:i:s');

    $host = 'localhost';
    $dbName = DB_CONNECT["dbName"];
    $user = DB_CONNECT["user"];
    $pass = DB_CONNECT["pass"];
    $connection = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query  = "INSERT INTO `book` (`isbn`, `title`, `summary`, `publication_year`, `created_at`, `updated_at`) ";
    $query .= "VALUES (:isbn, :title, :summary, :publication_year, :created_at, :updated_at)";

    $queryParams = [
        ':isbn' => $isbn,
        ':title' => $title,
        ':summary' => $summary,
        ':publication_year' => $publicationYear,
        ':created_at' => $createdAt,
        ':updated_at'=> $updatedAt,
    ];

    $statement = $connection->prepare($query);

    if ($statement->execute($queryParams)) {
        $successes[] = 'Le nouveau livre a bien été enregistré.';
    } else {
        $errors[] = "Une erreur s'est produite lors de l'enregistrement du livre en base de données : veuillez contacter l'administrateur du site.";
    }

    $connection = null;
}

if (count($errors) !== 0) {
    $errorMsg = "<ul>";
    foreach ($errors as $error) {
        $errorMsg .= "<li>$error</li>";
    }
    $errorMsg .= "</ul>";
    echo $errorMsg;
} else {
    $successMsg = "<ul>";
    foreach ($successes as $success) {
        $successMsg .= "<li>$success</li>";
    }
    $successMsg .= "</ul>";
    echo $successMsg;
}

include_once "./partials/bottom.php";
