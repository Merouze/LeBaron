<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<?php
$idEstimate = isset($_GET['idEstimate']) ? $_GET['idEstimate'] : null;
// var_dump($idEstimate);
// Exécuter la requête de recherche dans la base de données
$sqlDisplay = $dtLb->prepare("SELECT * FROM devis_prevoyance WHERE id_estimate = :id_estimate");

$sqlDisplay->execute(['id_estimate' => $idEstimate]); // Utilisez un tableau associatif pour lier les paramètres

// Récupérer les résultats après l'exécution de la requête
$resultats = $sqlDisplay->fetchAll(PDO::FETCH_ASSOC);
// Afficher les résultats uniquement si l'ID est spécifié et si des résultats sont trouvés
if ($idEstimate && count($resultats) > 0) {
    $resultat = $resultats[0]; // Prenez le premier résultat, car il devrait y en avoir un seul avec l'ID unique
    // Créer un objet DateTime pour la date de la demande
    $dateDemande = new DateTime($resultat['date_demande']);
    $dateBorn = new DateTime($resultat['date_naissance']);
    // Formater la date en jours/mois/année
    $dateFormatee = $dateDemande->format('d/m/Y');
    $dateBornFormatee = $dateBorn->format('d/m/Y');
}
?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- section header title -->

<div class="border-check">
    <ul class="border-check">
        <h3>Infos client</h3>
        <?= '<li><span class="bold">Nom :</span> ' . $resultat['prenom'] . ' ' . $resultat['nom'] . '</li>'; ?>
        <?= '<li><span class="bold">Situation familiale :</span> ' . $resultat['situation_familiale'] . '</li>'; ?>
        <?= '<li><span class="bold">Date de naissance :</span> ' . $dateBornFormatee . '</li>'; ?>
        <?= '<li><span class="bold">Profession :</span> ' . $resultat['profession'] . '</li>'; ?>
        <?= '<li><span class="bold">Ville :</span> ' . $resultat['ville'] . '</li>'; ?>
        <?= '<li><span class="bold">Téléphone :</span> ' . $resultat['tel'] . '</li>'; ?>
        <?= '<li><span class="bold">Email :</span> ' . $resultat['email'] . '</li>'; ?>
        <?= '<li><span class="bold">Horaire de contact :</span> ' . $resultat['horaire_contact'] . '</li>'; ?>
        <?= '<li><span class="bold">Message :</span> ' . $resultat['message'] . '</li>'; ?>
    </ul>

    <ul class="border-check">
        <h3>Infos demande</h3>
        <?= '<li><span class="bold">Type de demande :</span> ' . $resultat['type_demande'] . '</li>'; ?>
        <?= '<li><span class="bold">Type de contrat :</span> ' . $resultat['type_contrat'] . '</li>'; ?>
        <?= '<li><span class="bold">Accepte les conditions :</span> ' . $resultat['accept_conditions'] . '</li>'; ?>


    </ul>
</div>

<form method="post" action="_treatment/_treatment-estimate-prev.php">
    <!-- Ajoutez les champs nécessaires pour le traitement du devis -->
    <div>

        
        <input type="text" id="prix" name="prix" required>
        <input type="hidden" name="idEstimate" value="<?= $idEstimate; ?>" required>
        <label for="commentaire">Commentaire :</label>
        <textarea id="commentaire" name="commentaire"></textarea>
    </div>



    <button type="submit" name="submitTraitement">Valider le traitement</button>
</form>

<script>
    function confirmDeleteEstimate(idEstimate) {
        // Utilisez la fonction confirm() pour afficher une boîte de dialogue avec les boutons OK et Annuler
        var confirmation = confirm("Êtes-vous sûr de vouloir supprimer cette demande de devis ?");

        // Si l'utilisateur clique sur OK, redirigez vers la page de suppression avec l'id
        if (confirmation) {
            window.location.href = `./_treatment/_delete-estimate-prev.php?idEstimate=${idEstimate}`;
        }
    }
</script>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>