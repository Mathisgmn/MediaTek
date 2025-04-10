<?php

include_once "./partials/top.php";

include_once "./partials/to_implement_dialog.php";

?>
<div class="form-container">
    <h4>Code secret - Se désinscrire</h4>
    <form class="login-form" action="unregister.php" method="post" novalidate="">
        <div class="form-block">
            <label for="secret_code">Code secret reçu par mail</label>
            <input type="number" id="secret_code" name="secret_code" placeholder="Votre code secret à 6 chiffres" required="">
        </div>

        <p><a href="unregister_form.php" alt="Recevoir un nouveau code secret"><i class="light-icon-refresh"></i> Recevoir un nouveau code secret ?</a></p>

        <input class="warning-action" type="submit" name="unregister_submit" value="Confirmer votre désinscription">
    </form>
</div>
<?php

include_once "./partials/bottom.php";

?>