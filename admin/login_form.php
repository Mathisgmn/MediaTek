<?php

include_once "./partials/top_no_sidebar.php";

?>
<div class="form-container">
    <h4>Connexion</h4>
    <form class="login-form" action="login.php" method="post" novalidate="">
        <div class="form-block">
            <label for="username">Identifiant / Email</label>
            <input type="text" id="username" name="username" placeholder="Votre identifiant / email" required="">
        </div>

        <div class="form-block">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Votre mot de passe" required="">
        </div>

        <p><a href="forgotten_password_form.php" alt="Réinitialiser votre mot de passe"><i class="light-icon-help"></i> Mot de passe oublié ?</a></p>

        <input type="submit" name="login_submit" value="Se connecter">
    </form>
</div>
<?php

include_once "./partials/bottom.php";

?>