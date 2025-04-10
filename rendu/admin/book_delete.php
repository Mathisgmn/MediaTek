<?php
include_once "../utils/function.php";
include_once "./partials/top.php";

startSecureSession();

$host = 'localhost';
$dbName = DB_CONNECT["dbName"];
$user = DB_CONNECT["user"]; // Your MySQL user username
$pass = DB_CONNECT["pass"]; // Your MySQL user password

$db = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// // Vérifier si l'utilisateur est un admin
// if (!isAdmin()) {
//     $_SESSION['error_message'] = "Accès restreint. Veuillez vous connecter avec un compte administrateur.";
//     header('Location: ../login.php');
//     exit;
// }

// Vérifier si la méthode est POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../405.php');
    exit;
}



// Vérifier l'ID du livre
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    echo "<div class='error-message'>ID de livre invalide.</div>";
    echo "<p><a href='book_index.php'>Retour à la liste des livres</a></p>";
    include_once "./partials/bottom.php";
    exit;
}

$bookId = intval($_POST['id']);

try {
    
    // Récupérer les informations du livre avant suppression pour l'image
    $stmtGet = $db->prepare("SELECT filename FROM illustration WHERE book_id = ?");
    $stmtGet->execute([$bookId]);
    $book = $stmtGet->fetch();
    
    if (!$book) {
        echo "<div class='error-message'>Livre non trouvé.</div>";
        echo "<p><a href='book_index.php'>Retour à la liste des livres</a></p>";
        include_once "./partials/bottom.php";
        exit;
    }
    
    $stmtDeleteIllustrations = $db->prepare("DELETE FROM illustration WHERE book_id = ?");
    $stmtDeleteIllustrations->execute([$bookId]);

    $stmtDeleteAuthors = $db->prepare("DELETE FROM book_author WHERE book_id = ?");
    $stmtDeleteAuthors->execute([$bookId]);

    // Supprimer le livre de la base de données
    $stmt = $db->prepare("DELETE FROM book WHERE id = ?");
    $result = $stmt->execute([$bookId]);
    
    if ($result) {
        // Supprimer l'image de couverture si elle existe
        if ($book['filename'] && file_exists('../' . $book['filename'])) {
            unlink('../' . $book['filename']);
        }
        
        echo "<div class='success-message'>Le livre a été supprimé avec succès.</div>";
    } else {
        echo "<div class='error-message'>Une erreur s'est produite lors de la suppression du livre.</div>";
    }
    
} catch (PDOException $e) {
    echo "<div class='error-message'>Erreur de base de données: " . htmlspecialchars($e->getMessage()) . "</div>";
}

echo "<p><a href='book_index.php'>Retour à la liste des livres</a></p>";
include_once "./partials/bottom.php";
?>