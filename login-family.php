<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- section header title -->
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>

<?php
// Affichage des notifications
if (isset($_SESSION['notif'])) {
    $notifType = $_SESSION['notif']['type'];
    $notifMessage = $_SESSION['notif']['message'];
    
    echo "<div class='notification $notifType'>$notifMessage</div>";
    
    // Nettoyer la notification après l'affichage
    unset($_SESSION['notif']);
}
?>
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Connexion à l'espace&nbsp;<span class="blue">Famille</span></h1>
<section class="form-co">
    <form class="connexion" action="_login.php" method="post">
        <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
        <label class="label" for="email">Adresse e-mail:</label>
        <input type="email" id="email" name="email" required>
        <label class="label" for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Se connecter</button>
    </form>
</section>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>