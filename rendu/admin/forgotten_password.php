<?php

include_once "./partials/top_no_sidebar.php";

include_once "./partials/to_implement_dialog.php";

?>
<div class="form-container">
    <h4>Code secret</h4>
    <form class="login-form" action="reset_password_form.php" method="post" novalidate="">
        <div class="form-block">
            <label for="secret_code">Code secret reçu par mail</label>
            <input type="number" id="secret_code" name="secret_code" placeholder="Votre code secret à 6 chiffres" required="">
        </div>

        <p><a href="forgotten_password.php" alt="Recevoir un nouveau code secret"><i class="light-icon-refresh"></i> Recevoir un nouveau code secret ?</a></p>

        <input type="submit" name="forgotten_password_submit" value="Confirmer le code secret">
    </form>
</div>
<?php

include_once "./partials/bottom.php";

?>