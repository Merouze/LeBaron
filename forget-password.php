<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- section header title -->
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Récupération de l'espace&nbsp;<span class="blue">Famille</span></h1>
<section class="form-co">
        <?php

        // Affichage des notifications ou erreurs
        if (isset($_SESSION['notif'])) {
            echo '<span class="success">' . $_SESSION['notif'] . '</span>';
            unset($_SESSION['notif']);
        }
        if (isset($_SESSION['error'])) {
            echo '<span class="text-align error">' . $_SESSION['error'] . '</span>';
            unset($_SESSION['error']);
        }
        ?>
    <form class="connexion" action="_treatment/_treatment-forget-password.php" method="post">
        <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
        <label class="label" for="email">Adresse e-mail:</label>
        <input type="email" id="email" name="email" required>
        <label class="label" for="new-password">Entrer nouveau mot de passe :
            <input type="password" id="new-password" name="new-password" required>
            <span class="password-icon">
                <i data-feather="eye"></i>
                <i data-feather="eye-off"></i>
            </span>
        </label>
        <label class="label" for="confirm-new-password">Confimer nouveau mot de passe :
        <input type="password" id="confirm-new-password" name="confirm-new-password" required>
        <span class="password-icon">
                <i data-feather="eye"></i>
                <i data-feather="eye-off"></i>
            </span>
        </label>
        <button type="submit">Réinitialiser mot de passe.</button>
    </form>
</section>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>
<!-- ICON SCRIPT -->
<script src="https://unpkg.com/feather-icons"></script>
<script>
  feather.replace();
const eye = document.querySelector(".feather-eye");
const eyeoff = document.querySelector(".feather-eye-off");
const passwordField = document.querySelector("input[type=password]");
eye.addEventListener("click", () => {
  eye.style.display = "none";
  eyeoff.style.display = "flex";
  passwordField.type = "text";
});

eyeoff.addEventListener("click", () => {
  eyeoff.style.display = "none";
  eye.style.display = "flex";
  passwordField.type = "password";
});
</script>
<script src="asset/Js/script.js"></script>
<script src="asset/Js/fonctions.js"></script>
</body>

</html>