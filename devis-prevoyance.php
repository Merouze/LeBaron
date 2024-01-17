<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Devis&nbsp;<span class="blue">Prévoyance</span></h1>
<!-- devis -->
<section class="devis">
    <div class="devis-title">
        <h2>Contactez-nous</h2>
        <p>Permanence téléphonique 7j/7 et 24h/24</p>
        <p class="phone-number">📞 02 31 26 91 75</p>
        <a href="tel:+33231269175" class="contact-btn">NOUS CONTACTER</a>

    </div>

    <form action="./back-office/_treatment/_devis-prev.php" method="post" id="devis-form">
        <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">

        <p><span class="grey bold">Vous souhaitez souscrire un contrat prévoyance pour préserver vos proches financièrement ou bien pour organiser vos obsèques en amont ?</span>
            <br>
            <br>
            Remplissez notre formulaire pour une demande de devis, gratuite et sans engagement pour l'élaboration de votre contrat prévoyance.
        </p>

        <p class="info-form">Les champs marqués d'un <span class="red">*</span> sont obligatoires</p>
        <!-- Votre demande -->
        <h3 class="text-align">Votre demande</h3>
        <label for="type-demande">
            <h4>Votre demande concerne <span class="red">*</span></h4>
        </label>
        <label>
            <input class="input-radio" type="radio" name="type-obs" value="Organiser-Financer-Obseques" required>
            Organiser et financer ses obsèques
        </label>
        <label>
            <input class="input-radio" type="radio" name="type-obs" value="Financer-Obseques" required>
            Financer ses obsèques </label>
        <!-- Type Contrat -->
        <label for="time-finance">
            <h4>Avez-vous un souhait quant à la durée du contrat ? <span class="red">*</span></h4>
        </label>
        <label>
            <input class="input-radio" type="radio" name="time-finance" value="Comptant" required>
            Paiement en une seule fois </label>
        <label>
            <input class="input-radio" type="radio" name="time-finance" value="Un-an" required>
            1 an </label>
        <label>
            <input class="input-radio" type="radio" name="time-finance" value="Cinq-ans" required>
            5 ans </label>
        <label>
            <input class="input-radio" type="radio" name="time-finance" value="Dix-ans" required>
            10 ans </label>
        <label>
            <input class="input-radio" type="radio" name="time-finance" value="Quinze-ans" required>
            15 ans </label>
        <label>
            <input class="input-radio" type="radio" name="time-finance" value="Vingt-ans" required>
            20 ans </label>



        <!-- Vos coordonnées -->
        <h3 class="text-align">Vos coordonnées</h3>
        <label for="firstname">
            <h4>Prénom <span class="red">*</span></h4>
        </label>
        <input type="text" id="firstname" name="firstname" required>

        <label for="lastname">
            <h4>Nom <span class="red">*</span></h4>
        </label>
        <input type="text" id="lastname" name="lastname" required>
        <!-- family situation -->
        <label for="family-situation">
            <h4>Situation familiale <span class="red">*</span></h4>
        </label>
        <label>
            <input class="input-radio" type="radio" name="family-situation" value="Célibataire, séparé(e), divorcé(e), veuf ou veuve" required>
            Célibataire, séparé(e), divorcé(e), veuf ou veuve </label>
        <label>
            <input class="input-radio" type="radio" name="family-situation" value="Marié" required>
            Marié(e) </label>
        <label>
            <input class="input-radio" type="radio" name="family-situation" value="Union-libre" required>
            Union libre </label>
        <label>
            <input class="input-radio" type="radio" name="family-situation" value="Pacsé" required>
            Pacsé(e) </label>
        <label for="birthdate">
            <h4>Date de naissance <span class="red">*</span></h4>
        </label>
        <input type="date" id="birthdate" name="birthdate">

        <label for="profession">
            <h4>Profession <span class="red">*</span></h4>
        </label>
        <input type="text" id="profession" name="profession" required>

        <label for="city">
            <h4>Ville <span class="red">*</span></h4>
        </label>
        <input type="text" id="city" name="city" required>

        <label for="mail">
            <h4>E-mail <span class="red">*</span></h4>
        </label>
        <input type="email" id="mail" name="mail" required>

        <label for="confirm-mail">
            <h4>Confirmation E-mail <span class="red">*</span></h4>
        </label>
        <input type="email" id="confirm-mail" name="confirm-mail" required>

        <label for="phone">
            <h4>Tél. <span class="red">*</span></h4>
        </label>
        <input type="tel" id="phone" name="phone" required>

        <label for="hour-contact">
            <h4>Horaire préférentiel pour être contacté <span class="red">*</span></h4>
        </label>
        <input type="text" id="hour-contact" name="hour-contact" required>

        <label for="message-pre">
            <h4>Message <span class="red">*</span></h4>
        </label>
        <textarea name="message-pre" id="message-pre" cols="30" rows="10" required></textarea>

        <!-- Conditions d'utilisation -->
        <div>
            <input class="input-radio" type="checkbox" id="accept-conditions" name="accept-conditions" required>
            <label for="accept-conditions">En envoyant ce formulaire, j'accepte que les informations saisies soient utilisées pour être recontacté dans le cadre strict de cette demande de devis. Cette demande est gratuite et sans engagement de votre part.</label>
        </div>

        <button name="d-prev" type="submit">Envoyer votre demande</button>
    </form>
    <p class="info-form text-align">Vos données personnelles font l'objet d'un traitement informatique par l'éditeur du site sur le fondement de votre consentement pour répondre à vos demandes d'informations et/ou de devis. Pour en savoir plus et pour exercer vos droits, <span class="blue">consultez notre politique de données personnelles.</span></p>

</section>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>