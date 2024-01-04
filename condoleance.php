<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>
<?php include './back-office/_treatment/_treatment-display-ad.php' ?>

<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Avis de décés et &nbsp;<span class="blue">Condoléances</span></h1>
<!-- <?php ?> -->
<!-- section condoleance -->
<section class="avis-deces">
    <div class="title-top">
        <h2 class="defunt-name white"><?= $defunt['nom_prenom_defunt'] ?></h2>
    </div>
    <div class="list-family">
        <section class="condoleance-form">

            <form action="_treatment/_treatment-condolence.php" method="post" id="condoleance-form">
                <h2>Laissez votre message</h2>

                <label for="name">Nom et Prénom:</label>
                <input class="input-width" type="text" id="name" name="name" placeholder="Votre Nom" required>

                <label for="email">E-mail :</label>
                <input class="input-width" type="email" id="email" name="email" placeholder="Votre email" required>

                <label for="message">Message :</label>
                <textarea id="message" name="message" rows="6" placeholder="Votre message" required></textarea>

                <!-- <label for="captcha">Captcha :</label> -->
                <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">

                <button type="submit">Envoyer</button>
                <input type="hidden" name="idDefunt" value="<?= $idDefunt ?>">
                <p>Vos condoléances ne seront visible que par les proches via leur espace famille.</p>
            </form>
    </div>

</section>
<!-- // ----- # FORM # ----- // -->
<?php include './_includes./_form.php' ?>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>