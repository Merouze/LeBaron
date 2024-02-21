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
            <i class="fas fa-eye" id="showIconNew"></i>
            <i class="fas fa-eye-slash" id="hideIconNew" style="display:none;"></i>
        </label>
        <label class="label" for="confirm-new-password">Confimer nouveau mot de passe :
            <input type="password" id="confirm-new-password" name="confirm-new-password" required>
            <i class="fas fa-eye" id="showIconConfirm"></i>
            <i class="fas fa-eye-slash" id="hideIconConfirm" style="display:none;"></i>
        </label>
        <button type="submit">Réinitialiser mot de passe.</button>
    </form>
</section>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>

<script src="asset/Js/eyeForgetPass.js"></script>
<script src="asset/Js/script.js"></script>
<script src="asset/Js/fonctions.js"></script>
</body>

</html>