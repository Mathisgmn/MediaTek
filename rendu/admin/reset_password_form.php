<?php

include_once "./partials/top_no_sidebar.php";

include_once "./partials/to_implement_dialog.php";

?>
<div class="form-container">
    <h4>Choix du mot de passe</h4>
    <form class="login-form" action="reset_password.php" method="post" novalidate="">
        <div class="form-block">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Nouveau mot de passe" required="">
        </div>

        <div class="form-block">
            <label for="password_confirm">Mot de passe</label>
            <input type="password" id="password_confirm" name="password_confirm" placeholder="Nouveau mot de passe (confirmation)" required="">
        </div>

        <input type="submit" name="reset_password_submit" value="Enregistrer le nouveau mot de passe">
    </form>
</div>
<?php

include_once "./partials/bottom.php";

?>