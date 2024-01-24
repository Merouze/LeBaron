<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<?php
$idEstimate = isset($_GET['idEstimate']) ? $_GET['idEstimate'] : null;
// var_dump($idEstimate);
// Exécuter la requête de recherche dans la base de données
$sqlDisplay = $dtLb->prepare("SELECT * FROM devis_obs WHERE id_estimate = :id_estimate");

$sqlDisplay->execute(['id_estimate' => $idEstimate]); // Utilisez un tableau associatif pour lier les paramètres

// Récupérer les résultats après l'exécution de la requête
$resultats = $sqlDisplay->fetchAll(PDO::FETCH_ASSOC);
// Afficher les résultats uniquement si l'ID est spécifié et si des résultats sont trouvés
if ($idEstimate && count($resultats) > 0) {
    $resultat = $resultats[0]; // Prenez le premier résultat, car il devrait y en avoir un seul avec l'ID unique
    // Créer un objet DateTime pour la date de la demande
    $dateDemande = new DateTime($resultat['date_demande']);
    $dateBorn = new DateTime($resultat['date_born']);
    $dateDeath = new DateTime($resultat['date_death']);
    // Formater la date en jours/mois/année
    $dateFormatee = $dateDemande->format('d/m/Y');
    $dateBornformatee = $dateBorn->format('d/m/Y');
    $dateDeathformatee = $dateDeath->format('d/m/Y');
}

?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- section header title -->

<?= '<div class="mb50 text-align"><span class="bold"><h2>Type de demande :</h2></span> ' . $resultat['type_demande'] . '</div>'; ?>
<section class="infos-estimate">
    <div class="infos">
        <div class="border-check">
            <h2>Infos Cérémonies</h2>
            <ul>
                <?= '<li><span class="bold grey">Type de demande:</span> ' . $resultat['type_demande'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Présentation du corps :</span> ' . $resultat['presentation_corps'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Soin de conservation du corps :</span> ' . $resultat['body_care'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Type d\'obsèques :</span> ' . $resultat['type_funeral'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Type de cérémonie :</span> ' . $resultat['type_ceremony'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Type de sépulture :</span> ' . $resultat['type_sepulture'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Ville et/ou code postal de la cérémonie :</span> ' . $resultat['city_ceremony'] . '</li>'; ?>
            </ul>
        </div>
        <div class="border-check">
            <h2>Infos Défunt</h2>
            <ul>
                <?= '<li><span class="bold grey">Prénom du défunt :</span> ' . $resultat['firstname_defunt'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Nom défunt :</span> ' . $resultat['lastname_defunt'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Date de naissance du défunt :</span> ' . $dateBornformatee . '</li>'; ?>
                <?= '<li><span class="bold grey">Lieu de naissance du défunt :</span> ' . $resultat['location_born'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Code postale du lieu de naissance :</span> ' . $resultat['cp_born'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Date du décès :</span> ' . $dateDeathformatee . '</li>'; ?>
                <?= '<li><span class="bold grey">Lieu du décès:</span> ' . $resultat['location_death'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Ville du décès :</span> ' . $resultat['city_death'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Code postal :</span> ' . $resultat['city_death_cp'] . '</li>'; ?>
                <!-- <?= var_dump($resultat); ?> -->
            </ul>
        </div>
        <div class="border-check">
            <h2>Infos Client</h2>
            <ul>

                <?= '<li><span class="bold grey">Prénom:</span> ' . $resultat['firstname'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Nom :</span> ' . $resultat['lastname'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Lien avec le défunt :</span> ' . $resultat['link_defunt'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Ville :</span> ' . $resultat['city'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Numéro de téléphone :</span> ' . $resultat['phone'] . '</li>'; ?>
                <?= '<li><span class="bold grey">E-mail :</span> ' . $resultat['mail'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Horaire préférentiel pour être contacté :</span> ' . $resultat['hour_contact'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Conditions acceptés:</span> ' . $resultat['accept_conditions'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Devis traité :</span> ' . $resultat['traite'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Parution avis de décès en ligne :</span> ' . $resultat['obituary_online'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Parution avis de décès en presse :</span> ' . $resultat['obituary_press'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Message :</span> ' . $resultat['message'] . '</li>'; ?>
            </ul>
        </div>
    </div>
    <div>
        <form class="form-estimate" method="post" action="_treatment/_treatment-estimate-obs.php">
            <!-- Ajoutez les champs nécessaires pour le traitement du devis -->
            <div>
                <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
                <input type="hidden" name="idEstimate" value="<?= $idEstimate; ?>" required>
                <label class="bold" for="commentaire">Commentaire :</label>
                <textarea rows="6" id="commentaire" name="commentaire"></textarea>
            </div>
            <button type="submit" formtarget="_blank" name="submitTraitement">Voir la version PDF</button>
        </form>
        <form class="form-estimate" method="post" action="_treatment/_treatment-check-estimate.php">
            <div>
                <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
                <input type="hidden" name="idEstimate" value="<?= $idEstimate; ?>" required>

                <label class="form-check-label"><span class="bold">
                    Demande traité :</span>
                    <input type="checkbox" class="check-input" name="traited" value="1" <?= $resultat['traite'] == 1 ? 'checked' : ''; ?>>
                </label>
            </div>
            <button type="submit" name="submitUpdateObs">Valider</button>
        </form>
    </div>
    <!-- <form class="form-estimate" method="post" action="_treatment/_treatment-estimate-obs.php"> -->
    <!-- Ajoutez les champs nécessaires pour le traitement du devis -->
    <!-- <div>
            <label for="presentation"><span class="bold grey">Présentation du corps : <?= $resultat['presentation_corps']; ?>
            </label>
            <input type="text" id="presentation" name="presentation" required>
            <input type="hidden" name="idEstimate" value="<?= $idEstimate; ?>" required>
            <label for="prix-presentation"><span class="bold grey">Prix :</span></label>
            <textarea id="prix-presentation" name="prix-presentation"></textarea>
        </div>
        <div>
            <label for="body-care"><span class="bold grey">Soin de conservation du corps :</span> <?= $resultat['body_care']; ?></label>
            <input type="text" id="body-care" name="body-care" required>
            <label for="prix-body-care"><span class="bold grey">Prix :</span></label>
            <textarea id="prix-body-care" name="prix-body-care"></textarea>
        </div>
        <div>
            <label for="type-obs"><span class="bold grey">Type d\'obsèques :</span> <?= $resultat['type_funeral']; ?></label>
            <input type="text" id="type-obs" name="type-obs" required>
            <label for="prix-type-obs"><span class="bold grey">Prix :</span></label>
            <textarea id="prix-type-obs" name="prix-type-obs"></textarea>
        </div>
        <div>
            <label for="type-ceremony"><span class="bold grey">Type de cérémonie :</span> <?= $resultat['type_ceremony']; ?></label>
            <input type="text" id="type-ceremony" name="type-ceremony" required>
            <label for="prix-type-ceremony"><span class="bold grey">Prix :</span></label>
            <textarea id="prix-type-ceremony" name="prix-type-ceremony"></textarea>
        </div>
        <div>
            <label for="type-sepulture"><span class="bold grey">Type de sépulture :</span> <?= $resultat['type_sepulture']; ?></label>
            <input type="text" id="type-sepulture" name="type-sepulture" required>
            <label for="prix-type-sepulture"><span class="bold grey">Prix :</span></label>
            <textarea id="prix-type-sepulture" name="prix-type-sepulture"></textarea>
        </div>
        <div>
            <label for="commentaire"> Commentaire :</label>
            <textarea id="commentaire" name="commentaire"></textarea>
        </div>


        <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">


        <button formtarget="_blank" type="submit" name="submitTraitement">Valider le traitement</button>
    </form> -->
</section>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>