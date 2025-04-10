<?php

include_once "./partials/top.php";

$errors = [];
$successes = [];

/**
 * ******************** [1] Check if submitted form is valid
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Is method allowed ?
    if (isset($_POST['book_id']) && trim($_POST['book_id']) !== '') { // Required field value
        // OK
        $bookId = trim($_POST['book_id']);

        if (ctype_digit($bookId)) {
            $bookId = intval($bookId);

            // FIXME: Export sensitive data elsewhere
            $host = 'localhost';
            $dbName = 'mediatek';
            $user = 'mentor'; // Your MySQL user username
            $pass = 'superMentor'; // Your MySQL user password

            $connection = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query  = "SELECT COUNT(`id`) FROM `book` ";
            $query .= "WHERE id = :book_id";

            $queryParams = [
                ':book_id' => $bookId,
            ];

            $statement = $connection->prepare($query);
            $statement->execute($queryParams);

            if ($statement && $statement->fetchColumn() !== 1) {
                // KO
                $errors[] = "Le livre associé n'existe plus. Veuillez créer le livre asocié avant d'ajouter l'illustration";
            }

            $connection = null;
        } else {
            // KO - Malicious activity suspected
            // "400 - Bad Request" error handling
            header('Location: ../400.php');
            exit;
        }
    }

    if (isset($_POST['description']) && trim($_POST['description']) !== '') { // Not required field value but essential test needed
        // OK
        $description = trim($_POST['description']);
        $descriptionLen = strlen($description);
        if ($descriptionLen > 255) { // Format check
            // KO
            $errors[] = "Le champ 'Description' ne doit pas excéder 255 caractères.";
        }
    } else {
        $description = '';
    }

    if (isset($_FILES['image_file']) && $_FILES['image_file']['name'] !== '') { // Required field value
        // OK
        if ($_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            // OK
            $imgInfo = getimagesize($_FILES['image_file']['tmp_name']);
            if ($imgInfo !== FALSE) { // This is an image
                //OK
                $imageFileType = $imgInfo[2];
                if (($imageFileType === IMAGETYPE_JPEG) || ($imageFileType === IMAGETYPE_PNG)) { // Image format allowed types (JPEG or PNG)
                    // OK
                    if (strlen(pathinfo(trim($_FILES['image_file']['name']), PATHINFO_FILENAME)) <= 237) { // 255 - 13 (uniqid()) - 1 (underscore) - 1 (dot) - 3 (extension)
                        // OK
                        $imageFile = $_FILES['image_file'];
                    } else {
                        // KO
                        $errors['image_file'] = "La longueur du nom du fichier 'Fichier image associé' ne doit pas excéder 237 caractères.";
                    }
                } else {
                    $errors['image_file'] = "Le fichier 'Fichier image associé' doit être du type JPEG ou PNG.";
                }
            } else {
                // KO
                $errors['image_file'] = "Le fichier 'Fichier image associé' transmis doit être une image.";
            }
        } else {
            // KO
            // TODO: Add a more precise message and treat error precisely
            $errors['image_file'] = "Une erreur inattendue s'est produite lors de l'<i>upload</i> du fichier 'Fichier image associé : veuillez contacter l'administrateur du site.'";
        }
    } else {
        // KO
        $errors['image_file'] = "Le fichier 'Fichier image associé' est obligatoire.";
    }

    if (isset($_POST['is_cover']) && trim($_POST['is_cover']) !== '') { // Required field value
        $isCover = trim($_POST['is_cover']);
        if (!in_array($isCover, ["0", "1"], true)) { // Format check
            // KO - Malicious activity suspected
            // "400 - Bad Request" error handling
            header('Location: ../400.php');
            exit;
        }
    } else { // KO
        $errors[] = "Vous devez indiquer si cette illustration est la couverture du livre : 'Oui' ou 'Non'.";
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
    $description = addslashes(htmlspecialchars($description, ENT_NOQUOTES | ENT_SUBSTITUTE));
    $isCover = (bool) $isCover;

    /**
     * ******************** [3] Illustration image file management
     */
    $imageFileExt = ($imageFileType === IMAGETYPE_JPEG) ? 'jpg' : 'png';
    $imageFilename = pathinfo(trim($imageFile['name']), PATHINFO_FILENAME);
    $finalFilename = uniqid() . '_' . $imageFilename . '.' . $imageFileExt; // TODO: Slugify $imageFilename (see https://gist.github.com/lucasmezencio/15d23207834a3eade40c5aeec7c1fc5e)

    // FIXME: Handle potential warning (Failed to open stream: Permission denied)
    $copySucceed = copy($imageFile['tmp_name'], "../public/uploads/illustrations/" . $finalFilename);

    if ($copySucceed !== TRUE) { // File copy into 'public/uploads/illustrations/' folder failed
        // KO
        $errors['file_upload'] = "Une erreur s'est produite lors de l'<i>upload</i> du fichier 'Fichier image associé' : veuillez contacter l'administrateur du site.";
    } else {
        /**
         * ******************** [4] Create the corresponding record in database
         */
        // FIXME: Export sensitive data elsewhere
        $host = 'localhost';
        $dbName = DB_CONNECT["dbName"];
        $user = DB_CONNECT["user"]; // Your MySQL user username
        $pass = DB_CONNECT["pass"]; // Your MySQL user password

        $connection = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query  = "INSERT INTO `illustration` (`book_id`, `description`, `filename`, `is_cover`) ";
        $query .= "VALUES (:book_id, :description, :filename, :is_cover)";

        $queryParams = [
            ':book_id' => $bookId,
            ':description' => $description,
            ':filename' => $finalFilename,
            ':is_cover' => $isCover,
        ];

        $statement = $connection->prepare($query);

        if ($statement->execute($queryParams)) {
            $successes[] = 'La nouvelle illustration a bien été enregistré.';
        } else {
            $errors[] = "Une erreur s'est produite lors de l'enregistrement de l'illustration en base de données : veuillez contacter l'administrateur du site.";
        }

        $connection = null;
    }
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
