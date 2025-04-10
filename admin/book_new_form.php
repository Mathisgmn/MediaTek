<?php

include_once "./partials/top.php";

?>
<div class="form-container">
    <h4>Formulaire de création d'un livre</h4>
    <form action="book_new.php" method="get" novalidate="">
        <div class="form-block">
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" placeholder="Titre du livre" required="">
        </div>

        <div class="form-block">
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" placeholder="ISBN du livre" required="">
        </div>

        <div class="form-block">
            <label for="summary">Résumé</label>
            <textarea id="summary" name="summary" placeholder="Résumé du livre" rows="4"></textarea>
        </div>

        <div class="form-block">
            <label for="publication-year">Année de publication</label>
            <input type="number" id="publication-year" name="publication_year" placeholder="Année de publication (ex. : 2010)" min="1900" max="2025" step="1" value="" required="">
        </div>

        <input type="submit" name="book_new_submit" value="Enregistrer le nouveau livre">
    </form>
</div>
<?php

include_once "./partials/bottom.php";

?>