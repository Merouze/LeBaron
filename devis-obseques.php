<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Devis&nbsp;<span class="blue">Obsèques</span></h1>
<!-- devis -->
<section class="devis">
    <div class="devis-title">
        <h2>Contactez-nous</h2>
        <p>Permanence téléphonique 7j/7 et 24h/24</p>
        <p class="phone-number">📞 02 31 26 91 75</p>
        <a href="tel:+33231269175" class="contact-btn">NOUS CONTACTER</a>

    </div>

    <form action="#" method="post" id="devis-form">
        <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">

        <p><span class="grey bold">Vous devez organiser les obsèques d'un proche ou souhaitez simplement des informations ?</span>
            <br>
            <br>
            Remplissez notre formulaire pour une demande de devis, <span class="grey bold">gratuite</span> et sans engagement. <span class="grey bold">Les Pompes Funèbres</span> <span class="blue bold">Le Baron</span> organisent les obsèques selon vos souhaits et votre budget, dans le <span class="blue bold">respect</span> de vos <span class="blue bold">croyances</span> et des règles éthiques.
        </p>

        <p class="info-form">Les champs marqués d'un <span class="red">*</span> sont obligatoires</p>
        <!-- Votre demande -->
        <h3 class="text-align">Votre demande</h3>
        <label for="type-demande">
            <h4>Votre demande concerne <span class="red">*</span></h4>
        </label>
        <label>
            <input class="input-radio" type="radio" name="type-demande" value="Aucune" required>
            Un décès survenu
        </label>
        <label>
            <input class="input-radio" class="input-radio" type="radio" name="type-demande" value="En-chambre-funeraire" required>
            Un décès à venir
        </label>

        <!-- Informations sur le défunt -->
        <h3 class="text-align">Informations sur le défunt</h3>
        <label for="firstname-defunt">
            <h4>Prénom du défunt <span class="red">*</span></h4>
        </label>
        <input type="text" id="firstname-defunt" name="firstname-defunt" required>

        <label for="lastname-defunt">
            <h4>Nom du défunt <span class="red">*</span></h4>
        </label>
        <input type="text" id="lastname-defunt" name="lastname-defunt" required>

        <label for="date-born">
            <h4>Date de naissance du défunt <span class="red">*</span></h4>
        </label>
        <input type="date" id="date-born" name="date-born" required>

        <label for="location-born">
            <h4>Lieu de naissance du défunt <span class="red">*</span></h4>
        </label>
        <input type="text" id="location-born" name="location-born" required>
        
        <label for="cp-born">
            <h4>Code postale du lieu de naissance <span class="red">*</span></h4>
        </label>
        <input type="text" id="cp-born" name="cp-born" required>


        <label for="date-death">
            <h4>Date du décès <span class="red">*</span></h4>
        </label>
        <input type="date" id="date-death" name="date-death" required>

        <label for="location-born">
            <h4>Lieu <span class="red">*</span></h4>
        </label>
        
        <label>
            <input class="input-radio" type="radio" name="location-death" value="domicile" required>
            Domicile
        </label>
        <label>
            <input class="input-radio" type="radio" name="location-death" value="hopital" required>
            Hôpital
        </label>
        <label>
            <input class="input-radio" type="radio" name="location-death" value="maison-de-retraite" required>
            Maison de retraite
        </label>
        <label>
            <input class="input-radio" type="radio" name="location-death" value="institut-médico-légal" required>
            Institut médico-légal
        </label>
        <label>
            <input class="input-radio" type="radio" name="location-death" value="clinique" required>
            Clinique
        </label>

        <label for="city-death">
            <h4>Ville du décès <span class="red">*</span></h4>
        </label>
        <input type="text" id="city-death" name="city-death" required>

        <label for="city-death-cp">
            <h4>Code postal <span class="red">*</span></h4>
        </label>
        <input type="text" id="city-death-cp" name="city-death-cp" required>

        <label for="presentation-corps">
            <h4>Présentation du corps <span class="red">*</span></h4>
        </label>
        <label>
            <input class="input-radio" type="radio" name="presentation-corps" value="Aucune" required>
            Aucune
        </label>
        <label>
            <input class="input-radio" type="radio" name="presentation-corps" value="En-chambre-funeraire" required>
            En chambre funéraire
        </label>
        <label>
            <input class="input-radio" type="radio" name="presentation-corps" value="A-domicile" required>
            À domicile
        </label>

        <label for="body-care">
            <h4>Soin de conservation du corps <span class="red">*</span></h4>
        </label>
        <label>
            <input class="input-radio" type="radio" name="body-care" value="Aucune" required>
            Aucune
            <label>
                <input class="input-radio" type="radio" name="body-care" value="En-chambre-funeraire" required>
                Préparation du corps
            </label>
        </label>
        <label for="obituary">
            <h4>Parution avis de décès <span class="red">*</span></h4>
        </label>
        <label>
            <input class="input-radio" type="checkbox" name="obituary" value="obituary" required>
            Parution d'un avis de décès en ligne
        </label>

        <label>
            <input class="input-radio" type="checkbox" name="obituary" value="obituary" required>
            Parution d'un avis de décès dans la presse
        </label>

        <!-- La cérémonie -->
        <h3 class="text-align">La cérémonie</h3>
        <label for="type-funeral">
            <h4>Type d'obsèques <span class="red">*</span></h4>
        </label>
        <label>
            <input class="input-radio" type="radio" name="type-funeral" value="Inhumation" required>
            Inhumation
        </label>
        <label>
            <input class="input-radio" type="radio" name="type-funeral" value="En-chambre-funeraire" required>
            Crémation
        </label>

        <label for="city-ceremony">
            <h4>Ville et/ou code postal de la cérémonie <span class="red">*</span></h4>
        </label>
        <input type="text" id="city-ceremony" name="city-ceremony" required>

        <label for="type-ceremony">
            <h4>Type de cérémonie <span class="red">*</span></h4>
        </label>
        <label>
            <input class="input-radio" type="radio" name="type-ceremony" value="Civile" required>
            Civile
        </label>
        <label>
            <input class="input-radio" type="radio" name="type-ceremony" value="En-chambre-funeraire" required>
            Religieuse
        </label>

        <label for="type-sepulture">
            <h4>Type de sépulture - Dispersion des cendres <span class="red">*</span></h4>
        </label>
        <label>
            <input class="input-radio" type="radio" name="type-sepulture" value="aucun-emplacement" required>
            Type de sépulture - Aucun emplacement prévu
        </label>
        <label>
            <input class="input-radio" type="radio" name="type-sepulture" value="pleine-terre" required>
            Type de sépulture - Pleine terre
        </label>
        <label>
            <input class="input-radio" type="radio" name="type-sepulture" value="caveau-existant" required>
            Type de sépulture - Caveau existant
        </label>
        <label>
            <input class="input-radio" type="radio" name="type-sepulture" value="En-chambre-funeraire" required>
            Dêpot des cendres - Colombarium
        </label>
        <label>
            <input class="input-radio" type="radio" name="type-sepulture" value="En-chambre-funeraire" required>
            Dêpot des cendres - Caveau cinéraire
        </label>
        <label>
            <input class="input-radio" type="radio" name="type-sepulture" value="En-chambre-funeraire" required>
            Dêpot des cendres - Jardin du souvenir
        </label>
        
        <label for="message">
            <h4>Message <span class="red">*</span></h4>
        </label>
        <textarea name="message" id="message" cols="30" rows="10" required></textarea>

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

        <label for="link-defunt">
            <h4>Lien avec le défunt <span class="red">*</span></h4>
        </label>
        <input type="text" id="link-defunt" name="link-defunt" required>

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

        <!-- Conditions d'utilisation -->
        <div>
            <!-- <input class="input-radio" type="checkbox" id="accept-conditions" name="accept-conditions" required> -->
            <label for="accept-conditions"><input class="input-radio" type="checkbox" id="accept-conditions" name="accept-conditions" required>En envoyant ce formulaire, j'accepte que les informations saisies soient utilisées pour être recontacté dans le cadre strict de cette demande de devis. Cette demande est gratuite et sans engagement de votre part.</label>
        </div>

        <button type="submit">Envoyer votre demande</button>
    </form>
    <p class="info-form text-align">Vos données personnelles font l'objet d'un traitement informatique par l'éditeur du site sur le fondement de votre consentement pour répondre à vos demandes d'informations et/ou de devis. Pour en savoir plus et pour exercer vos droits, <span class="blue">consultez notre politique de données personnelles.</span></p>

</section>



<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>