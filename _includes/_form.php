<section class="form">
    
    <form action="#" method="post" id="contact-form">
    <h2>Contactez-nous</h2>
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

    
    <div>
        <input type="checkbox" id="rgpd" name="rgpd" required>
        <label for="rgpd">J'accepte les termes de la politique de confidentialité</label>
    </div>
<!-- 
    <button class="g-recaptcha"
    data-sitekey="6Ld0QjIpAAAAAIw6sXmFG_6x86GTgGd6eXbx8mM1"
    data-callback='onSubmit'
    data-action='submit' type="submit">Envoyer</button>
    <p>Vos données personnelles font l'objet d'un traitement informatique pour répondre à vos demandes d'informations et/ou de devis. Pour en savoir plus et pour exercer vos droits, consultez notre politique de données personnelles.</p> -->
</form>

</section>