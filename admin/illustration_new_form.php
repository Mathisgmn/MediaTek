<?php

include_once "./partials/top.php";

/**
 * ******************** [1] Get books full list in order to associate the illustration to a book
 */
// FIXME: Export sensitive data elsewhere
$host = 'localhost';
$dbName = DB_CONNECT["dbName"];
$user = DB_CONNECT["user"]; // Your MySQL user username
$pass = DB_CONNECT["pass"]; // Your MySQL user password

$connection = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "SELECT COUNT(`id`) FROM `book`";

$statement = $connection->query($query);

if ($statement && $statement->fetchColumn() > 0) { // At least one book exists
    $query  = "SELECT `id`, `title` FROM `book`";

    $statement = $connection->query($query);
    $books = $statement->fetchAll(PDO::FETCH_NUM);

    $bookOptions = '';
    foreach($books as $book) {
        $bookOptions .= vsprintf('<option value="%d">%s</option>' . PHP_EOL, $book);
    }
} else {
    // TODO: Handle case (no illustration can be added as no book exists)
    header('Location: illustration_index.php');
}

$connection = null;

?>
<div class="form-container">
    <h4>Formulaire d'ajout d'une illustration</h4>
    <form action="illustration_new.php" method="post" enctype="multipart/form-data" novalidate="">
        <div class="form-block">
            <label for="book-id">Livre associé</label>
            <select id="book-id" name="book_id" required="">
                <option value="" disabled="" selected="">Veuillez choisir le livre associé</option>
                <?= $bookOptions ?>
            </select>
        </div>

        <div class="form-block">
            <label for="description">Description</label>
            <input type="text" id="description" name="description" placeholder="Description de l'illustration">
        </div>

        <div class="form-block">
            <label for="image-file">Fichier image associé (au format JPEG ou PNG)</label>
            <input type="file" id="image-file" name="image_file" placeholder="Fichier image associé" required="">
        </div>

        <div class="form-block-radio">
            <p>Cette illustration est la couverture du livre ?</p>
            <input type="radio" id="is-cover-yes" name="is_cover" value="1" required=""><label for="is-cover-yes">Oui</label>
            <input type="radio" id="is-cover-no" name="is_cover" value="0"><label for="is-cover-yes">Non</label>
        </div>

        <div class="form-block">
            <input type="submit" name="illustration_new_submit" value="Enregistrer la nouvelle illustration">
        </div>
    </form>
</div>
<?php

include_once "./partials/bottom.php";

?>