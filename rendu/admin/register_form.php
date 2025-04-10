<?php

include_once "./partials/top.php";

?>
<div class="form-container">
    <h4>Formulaire d'inscription</h4>
    <form action="register.php" method="post" novalidate="">
        <div class="form-block">
            <label for="last_name">Votre nom</label>
            <input type="text" id="last-name" name="last_name" placeholder="Nom de famille (ex. : Doe)" required="">
        </div>

        <div class="form-block">
            <label for="first_name">Votre prénom</label>
            <input type="text" id="first-name" name="first_name" placeholder="Prénom (ex. : John)" required="">
        </div>

        <div class="form-block">
            <label for="birth_date">Votre date de naissance</label>
            <input type="date" id="birth-date" name="birth_date" placeholder="Date de naissance (ex. : 12-06-2001)" value="" required="">
        </div>

        <div class="form-block">
            <label for="isbn">Email</label>
            <input type="email" id="email" name="email" placeholder="Email (ex. : john.doe@mailbox.com)" required="">
        </div>

        <div class="form-block">
            <label for="password">Choix du mot de passe</label>
            <input aria-describedby="password-rules" type="password" id="password" name="password" placeholder="Mot de passe" required="">
            <div class="tooltip-wrapper">
                <article role="tooltip" id="password-rules">
                    <header><i class="light-icon-shield-check"></i> Politique de mot de passe</header>
                    <ul>
                        <li>Doit contenir au moins 10 caractères</li>
                        <li>Doit inclure au moins une lettre majuscule</li>
                        <li>Doit inclure au moins une lettre minuscule</li>
                        <li>Doit contenir au moins un chiffre</li>
                        <li>Doit inclure au moins un caractère spécial (!, ?, @, #, $, %, ^, &, *)</li>
                        <li>Ne doit pas contenir d'espace</li>
                    </ul>
                </article>
            </div>
        </div>

        <div class="form-block">
            <label for="password_confirm">Confirmation du mot de passe</label>
            <input type="password" id="password-confirm" name="password_confirm" placeholder="Mot de passe" required="">
        </div>

        <input type="submit" name="register_submit" value="Confirmer l'inscription">
    </form>
</div>

<script type="module" defer>
    flatpickr("#birth-date", {
        "dateFormat" : "d-m-Y",
        "locale": "fr",
    });
</script>

<?php

include_once "./partials/bottom.php";

?>