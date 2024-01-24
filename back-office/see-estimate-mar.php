<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<?php
$idEstimate = isset($_GET['idEstimate']) ? $_GET['idEstimate'] : null;
// var_dump($idEstimate);
// Exécuter la requête de recherche dans la base de données
$sqlDisplay = $dtLb->prepare("SELECT * FROM devis_mar WHERE id_estimate = :id_estimate");

$sqlDisplay->execute(['id_estimate' => $idEstimate]); // Utilisez un tableau associatif pour lier les paramètres

// Récupérer les résultats après l'exécution de la requête
$resultats = $sqlDisplay->fetchAll(PDO::FETCH_ASSOC);
// Afficher les résultats uniquement si l'ID est spécifié et si des résultats sont trouvés
if ($idEstimate && count($resultats) > 0) {
    $resultat = $resultats[0]; // Prenez le premier résultat, car il devrait y en avoir un seul avec l'ID unique
    // Créer un objet DateTime pour la date de la demande
    $dateDemande = new DateTime($resultat['date_demande']);
    // Formater la date en jours/mois/année
    $dateFormatee = $dateDemande->format('d/m/Y');
}
?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- section header title -->
<section class="infos-estimate">
    <div class="infos">
        <div class="border-check">
            <h2>Infos Travaux</h2>
            <ul>
                <?= '<li ><span class="bold grey">Date de demande :</span> ' . $dateFormatee . '</li>'; ?>
                <?= '<li><span class="bold grey">Nature des travaux :</span> ' . $resultat['type_works'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Type de monument :</span> ' . $resultat['type_monument'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Demande Entretien :</span> ' . $resultat['type_entretien'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Demande Fleurissement :</span> ' . $resultat['flowering'] . '</li>'; ?>
                <?= '<li><span class="bold grey"> Emplacement et n° de concession:</span> ' . $resultat['location_fall'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Nom du cimetière :</span> ' . $resultat['cimetary_name'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Ville et/ou code postal du cimetière :</span> ' . $resultat['location_cimetary'] . '</li>'; ?>
            </ul>
        </div>
        <div class="border-check">
            <h2>Infos Client</h2>
            <ul>
                <?= '<li><span class="bold grey">Prénom :</span> ' . $resultat['firstname'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Nom :</span> ' . $resultat['lastname'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Ville :</span> ' . $resultat['city'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Mail :</span> ' . $resultat['mail'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Message :</span> ' . $resultat['message_marble'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Horaire de contact :</span> ' . $resultat['hour_contact'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Conditions acceptés:</span> ' . $resultat['accept_conditions'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Devis traité:</span> ' . $resultat['traite'] . '</li>'; ?>
            </ul>
        </div>
    </div>
    <div>
        <form class="form-estimate" method="post" action="_treatment/_treatment-estimate-mar.php">
            <!-- Ajoutez les champs nécessaires pour le traitement du devis -->
            <div>
                <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
                <input type="hidden" name="idEstimate" value="<?= $idEstimate; ?>" required>
                <input type="hidden" name="mail" value="<?= $resultat['mail']; ?>" required>
                <label class="bold" for="commentaire">Commentaire :</label>
                <textarea rows="6" id="commentaire" name="commentaire"></textarea>
            </div>
            <button type="submit" formtarget="_blank" name="submitTraitement">Voir la version PDF</button>
            <br>
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
            <button type="submit" name="submitUpdateMar">Valider</button>
        </form>
    </div>
</section>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>