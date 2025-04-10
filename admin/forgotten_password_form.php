<?php

include_once "./partials/top_no_sidebar.php";

include_once "./partials/to_implement_dialog.php";

?>
<div class="form-container">
    <h4>Réinitialisation du mot de passe</h4>
    <form class="login-form" action="forgotten_password.php" method="post" novalidate="">
        <div class="form-block">
            <label for="username">Identifiant / Email</label>
            <input type="text" id="username" name="username" placeholder="Votre identifiant / email" required="">
        </div>

        <input type="submit" name="forgotten_password_submit" value="Réinitialiser votre mot de passe">
    </form>
</div>
<?php

include_once "./partials/bottom.php";

?>