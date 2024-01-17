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
    // Formater la date en jours/mois/année
    $dateFormatee = $dateDemande->format('d/m/Y');
    ?>
    <!-- // ----- # NAV # ----- // -->
    <?php include './_includes/_nav-admin.php' ?>
    <!-- section header title -->
    <?php
    echo '<ul >';
echo '<li>';
echo '<ul>';
echo '<div class="display-mtb20 display_list-ad">';
echo '<div class="display-li-ad">';
echo '<li class="bold grey">' . $resultat['prenom'] . ' ' . $resultat['nom'] . ' ans</li>';
echo '<li class="bold blue">' . $dateFormatee . '</li>';
echo '<li>Type de demande: ' . $resultat['type_demande'] . '</li>';
echo '<li>Type de contrat: ' . $resultat['type_contrat'] . '</li>';
echo '<li>Situation familiale: ' . $resultat['situation_familiale'] . '</li>';
echo '<li>Date de naissance: ' . $resultat['date_naissance'] . '</li>';
echo '<li>Profession: ' . $resultat['profession'] . '</li>';
echo '<li>Ville: ' . $resultat['ville'] . '</li>';
echo '<li>Email: ' . $resultat['email'] . '</li>';
echo '<li>Téléphone: ' . $resultat['tel'] . '</li>';
echo '<li>Horaire de contact: ' . $resultat['horaire_contact'] . '</li>';
echo '<li>Message: ' . $resultat['message'] . '</li>';
echo '<li>Accepte les conditions: ' . $resultat['accept_conditions'] . '</li>';
echo '<li>Traité: ' . $resultat['traite'] . '</li>';
echo '<li>Date de demande: ' . $resultat['date_demande'] . '</li>';
// Ajoutez d'autres colonnes ici en suivant le même modèle
echo '</div>';
echo '<div class="display-btn-list-ad">';
// ... (autres parties du code)
echo '</div>';
echo '</div>';
echo '</ul>';
echo '</li>';
echo '</ul>';

} else {
    // Afficher un message si aucun résultat n'est trouvé
    echo 'Aucun résultat trouvé.';
}
?>

<!-- 
    <script>
        function confirmDelete(idDefunt) {
            // Utilisez la fonction confirm() pour afficher une boîte de dialogue avec les boutons OK et Annuler
            var confirmation = confirm("Êtes-vous sûr de vouloir supprimer cet avis de décès ?");

        // Si l'utilisateur clique sur OK, redirigez vers la page de suppression avec l'id du défunt
        if (confirmation) {
            window.location.href = `./_treatment/_delete.php?idDefunt=${idDefunt}`;
        }
    }
</script> -->
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>