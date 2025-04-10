<?php
include_once "../utils/function.php";
include_once "./partials/top.php";

// Initialiser la session sécurisée
startSecureSession();

$host = 'localhost';
$dbName = DB_CONNECT["dbName"];
$user = DB_CONNECT["user"]; // Your MySQL user username
$pass = DB_CONNECT["pass"]; // Your MySQL user password

$db = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "SELECT * FROM book JOIN illustration ON book.id = illustration.book_id;";

$stmt = $db->prepare($query);
$stmt->execute();
$books = $stmt->fetchAll();
?>

<div class="table-top">
    <h4>Liste des livres</h4>
    <a href="book_new_form.php" title="Ajouter un nouveau livre" role="button"><i class="light-icon-circle-plus"></i>Nouveau livre</a>
</div>
<table class="striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Titre</th>
            <th>Résumé</th>
            <th>Année de publication</th>
            <th>Couverture</th>
            <th>Emprunté le</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $book): ?>
        <tr>
            <td><?= htmlspecialchars($book['id']) ?></td>
            <td><?= htmlspecialchars($book['title']) ?></td>
            <td><?= htmlspecialchars($book['summary'] ? (strlen($book['summary']) > 100 ? substr($book['summary'], 0, 100) . '...' : $book['summary']) : '') ?></td>
            <td><?= htmlspecialchars($book['publication_year']) ?></td>
            <td>
                <?php if ($book['filename']): ?>
                    <img src="<?= htmlspecialchars('../' . $book['filename']) ?>" alt="Couverture" style="max-width: 80px; max-height: 100px;">
                <?php else: ?>
                    <span>Aucune couverture</span>
                <?php endif; ?>
            </td>
            <td>Non défini</td>
            <td>
                <a href="book_show.php?id=<?= $book['id'] ?>" title="Voir le détail de ce livre">
                    <i role="button" class="light-icon-float-left"></i>
                </a>
                <a href="book_edit_form.php?id=<?= $book['id'] ?>" title="Modifier ce livre" class="btn btn-secondary btn-sm me-1">
                    <i role="button" class="light-icon-pencil"></i>
                </a>
                <a href="book_delete_form.php?id=<?= $book['id'] ?>" title="Supprimer ce livre" class="btn btn-danger btn-sm">
                    <i role="button" class="light-icon-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
include_once "./partials/bottom.php";
?>