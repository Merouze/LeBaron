<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Connexion&nbsp;<span class="blue">Famille</span></h1>
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
<?php include '.././_includes./_footer.php' ?>