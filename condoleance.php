<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Avis de décés et &nbsp;<span class="blue">Condoléances</span></h1>
<!-- section condoleance -->
<section class="avis-deces">
    <div class="title-top">
        <h2 class="defunt-name white">Jeannine ROMBEAUX</h2>
    </div>
    <div class="list-family">
    <section class="condoleance-form">
    
    <form action="#" method="post" id="condoleance-form">
    <h2>Laissez votre message</h2>
    <label for="firstname">Prénom :</label>
    <input class="input-width" type="text" id="firstname" name="firstname" placeholder="Votre Prénom" required>

    <label for="lastname">Nom :</label>
    <input class="input-width" type="text" id="lastname" name="lastname" placeholder="Votre Nom" required>

    <label for="email">E-mail :</label>
    <input class="input-width" type="email" id="email" name="email" placeholder="Votre email" required>

    <label for="message">Message :</label>
    <textarea id="message" name="message" rows="6" placeholder="Votre message" required></textarea>

    <!-- <label for="captcha">Captcha :</label> -->
    <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">

    <button class="g-recaptcha"
    data-sitekey="6Ld0QjIpAAAAAIw6sXmFG_6x86GTgGd6eXbx8mM1"
    data-callback='onSubmit'
    data-action='submit' type="submit">Envoyer</button>
    <p>Vos condoléances ne seront visible que par les proches via leur espace famille.</p>
</form>


    </div>
    <div class="link-bottom">
        <div class="defunt-name">
            <a href="condoléance.php">Transmettre ses condoléances</a>
        </div>
    </div>
</section>
<!-- // ----- # FORM # ----- // -->
<?php include './_includes./_form.php' ?>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>