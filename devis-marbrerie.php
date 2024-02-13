<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Devis&nbsp;<span class="blue">Marbrerie</span></h1>
<!-- devis -->
<section class="devis">
    <div class="devis-title">
        <h2>Contactez-nous</h2>
        <p>Permanence téléphonique 7j/7 et 24h/24</p>
        <p class="phone-number">📞 02 31 26 91 75</p>
        <a href="tel:+33231269175" class="contact-btn">NOUS CONTACTER</a>
    </div>
        <form action="./back-office/_treatment/_devis-mar.php" method="post" id="devis-form">
            
            <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">

            <p><span class="grey bold">Vous souhaitez obtenir un devis ou bien des informations sur notre service de marbrerie ?</span>
                <br>
                <br>
                Remplissez notre formulaire pour une demande de devis, <span class="grey bold">gratuite</span> et sans engagement. Faites appel aux<span class="grey bold">Pompes Funèbres</span> <span class="blue bold">Le Baron</span> pour votre monument funéraire et travaux de marbrerie.
            </p>

            <p class="info-form">Les champs marqués d'un <span class="red">*</span> sont obligatoires</p>
            <!-- Votre demande -->
            <h3 class="text-align">Votre demande</h3>
            <!-- type works -->
            <label for="type-works">
                <h4>Nature des travaux <span class="red">*</span></h4>
            </label>
            <label>
                <input class="input-radio" type="radio" name="type-works" value="creation-pose" required>
                Création et pose
            </label>
            <label>
                <input class="input-radio" type="radio" name="type-works" value="restauration-modification" required> Restauration / Modification
            </label>
            <label>
                <input class="input-radio" type="radio" name="type-works" value="Autre" required>
                Autre (détails en commentaire)
            </label>
            <!-- type monument -->
            <label for="type-monument">
                <h4>Type de monument <span class="red">*</span></h4>
            </label>
            <label>
                <input class="input-radio" type="radio" name="type-monument" value="caveau" required>
                Construction d'un caveau (indiquez le nombre de places en commentaire)
            </label>
            <label>
                <input class="input-radio" type="radio" name="type-monument" value="restauration-modification" required>
                Restauration / Modification
            </label>
            <label>

                <input class="input-radio" type="radio" name="type-monument" value="gravure" required>
                Gravure (détails en commentaire)
            </label>
            <label>
                <input class="input-radio" type="radio" name="type-monument" value="Autre" required>
                Autre (détails en commentaire)
            </label>
            <!-- info entretien -->
            <label for="type-entretien">
                <h4>Demande Entretien <span class="red">*</h4></span>
            </label>
            <label>
                <input class="input-radio" type="radio" name="type-entretien" value="aucun" required>
                Aucun
            </label>
            <label>
                <input class="input-radio" type="radio" name="type-entretien" value="annuel" required>
                Annuel </label>
            <label>
                <input class="input-radio" type="radio" name="type-entretien" value="ponctuel" required>
                Ponctuel
            </label>

            <!-- Informations flowering -->
            <label for="flowering">
                <h4>Demande Fleurissement <span class="red">*</span></h4>
            </label>
            <label>
                <input class="input-radio" type="radio" name="flowering" value="no-flowering" required>
                Aucun
            </label>
            <label>
                <input class="input-radio" type="radio" name="flowering" value="annuel-flowering" required>
                Annuel
            </label>
            <label>
                <input class="input-radio" type="radio" name="flowering" value="ponctuel-flowering" required>
                Ponctuel </label>


            <label for="message-marble">
                <h4>Message <span class="red">*</span></h4>
            </label>
            <textarea name="message-marble" id="message-marble" cols="30" rows="10" required></textarea>


            <!-- Informations sur le défunt -->
            <h3 class="text-align">Localisation des travaux</h3>
            <label for="location-fall">
                <h4>Emplacement et n° de concession
                    <span class="red">*</span>
                </h4>
            </label>
            <input type="text" id="location-fall" name="location-fall" required>
            <label for="cimetary-name">
                <h4>Nom du cimetière <span class="red">*</span></h4>
            </label>
            <input type="text" id="cimetary-name" name="cimetary-name" required>

            <label for="location-cimetary">
                <h4>Ville et/ou code postal du cimetière
                    <span class="red">*</span>
                </h4>
            </label>
            <input type="text" id="location-fall" name="location-cimetary" required>

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
            <input type="time" id="hour-contact" name="hour-contact" required>

            <!-- Conditions d'utilisation -->
            <div>
                <input class="check-form" type="checkbox" id="accept-conditions" name="accept-conditions" required>
                <label for="accept-conditions"><p>En envoyant ce formulaire, j'accepte que les informations saisies soient utilisées pour être recontacté dans le cadre strict de cette demande de devis.</p>
                <p>Cette demande est gratuite et sans engagement de votre part.</p></label>
            </div>

            <button name="d-mar" type="submit">Envoyer votre demande</button>
        </form>
        <p class="info-form text-align">Vos données personnelles font l'objet d'un traitement informatique par l'éditeur du site sur le fondement de votre consentement pour répondre à vos demandes d'informations et/ou de devis. Pour en savoir plus et pour exercer vos droits, <span class="blue">consultez notre politique de données personnelles.</span></p>

</section>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>

<script src="asset/Js/script.js"></script>
<script src="asset/Js/fonctions.js"></script>
</body>
</html>