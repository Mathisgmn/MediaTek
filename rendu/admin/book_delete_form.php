<?php
include_once "../utils/function.php";
include_once "./partials/top.php";
// include_once "../utils/auth.php";

// Initialiser la session sécurisée
startSecureSession();

$host = 'localhost';
$dbName = DB_CONNECT["dbName"];
$user = DB_CONNECT["user"]; // Your MySQL user username
$pass = DB_CONNECT["pass"]; // Your MySQL user password

$db = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérifier si un ID est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='error-message'>ID de livre invalide.</div>";
    echo "<p><a href='book_index.php'>Retour à la liste des livres</a></p>";
    include_once "./partials/bottom.php";
    exit;
}

$bookId = intval($_GET['id']);

// Récupérer les détails du livre
try {
    $stmt = $db->prepare("SELECT * FROM book JOIN illustration ON book.id = illustration.book_id WHERE book.id = ?");
    $stmt->execute([$bookId]);
    $book = $stmt->fetch();

    if (!$book) {
        echo "<div class='error-message'>Livre non trouvé.</div>";
        echo "<p><a href='book_index.php'>Retour à la liste des livres</a></p>";
        include_once "./partials/bottom.php";
        exit;
    }
    
    
} catch (PDOException $e) {
    echo "<div class='error-message'>Erreur: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<p><a href='book_index.php'>Retour à la liste des livres</a></p>";
    include_once "./partials/bottom.php";
    exit;
}

// $csrfToken = generateCsrfToken();
?>

<div class="delete-confirmation">
    <h2>Supprimer un livre</h2>
    
    
    <div class="book-info">
        <h3><?= htmlspecialchars($book['title']) ?></h3>
        <p><strong>ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?></p>
        <p><strong>Année de publication:</strong> <?= htmlspecialchars($book['publication_year']) ?></p>
        
        <?php if ($book['filename']): ?>
            <div class="book-cover">
                <img src="<?= htmlspecialchars('../' . $book['filename']) ?>" alt="Couverture" style="max-width: 150px;">
            </div>
        <?php endif; ?>
    </div>
    
    <div class="confirmation-message">
        <p>Êtes-vous sûr de vouloir supprimer définitivement ce livre?</p>
        <p class="warning">Cette action est irréversible.</p>
    </div>
    
    <form action="book_delete.php" method="POST">
        <!-- <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>"> -->
        <input type="hidden" name="id" value="<?= $bookId ?>">
        
        <div class="button-group">
            <input type="submit" name="confirm_delete" value="Oui, supprimer ce livre" class="btn-danger">
            <a href="book_show.php?id=<?= $bookId ?>" class="btn">Annuler</a>
        </div>
    </form>
</div>

<?php
include_once "./partials/bottom.php";
?>