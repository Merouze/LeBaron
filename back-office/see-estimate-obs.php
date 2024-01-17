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
    // Formater la date en jours/mois/année
    $dateFormatee = $dateDemande->format('d/m/Y');
?>
    <!-- // ----- # NAV # ----- // -->
    <?php include './_includes/_nav-admin.php' ?>
    <!-- section header title -->
<?php 
    echo '<ul>';
    echo '<li>';
    echo '<ul>';
    echo '<div class="display-mtb20 display_list-ad">';
    echo '<div class="display-li-ad">';
    echo '<li class="bold grey">' . $resultat['firstname'] . ' ' . $resultat['lastname'] . ' ans</li>';
    echo '<li class="bold blue">' . $dateFormatee . '</li>';
    echo '<li><span class="bold grey">Type de demande:</span> ' . $resultat['type_demande'] . '</li>';
    echo '<li>Type de contrat: ' . $resultat['firstname_defunt'] . '</li>';
    echo '<li>Situation familiale: ' . $resultat['lastname_defunt'] . '</li>';
    echo '<li>Date de naissance: ' . $resultat['date_born'] . '</li>';
    echo '<li>Profession: ' . $resultat['location_born'] . '</li>';
    echo '<li>Ville: ' . $resultat['cp_born'] . '</li>';
    echo '<li>Email: ' . $resultat['date_death'] . '</li>';
    echo '<li>Téléphone: ' . $resultat['location_death'] . '</li>';
    echo '<li>Horaire de contact: ' . $resultat['city_death'] . '</li>';
    echo '<li>Message: ' . $resultat['city_death_cp'] . '</li>';
    echo '<li>Accepte les conditions: ' . $resultat['presentation_corps'] . '</li>';
    echo '<li>Traité: ' . $resultat['body_care'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['type_funeral'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['city_ceremony'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['type_ceremony'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['type_sepulture'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['message'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['firstname'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['lastname'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['link_defunt'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['city'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['mail'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['phone'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['hour_contact'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['accept_conditions'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['traite'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['obituary_online'] . '</li>';
    echo '<li>Date de demande: ' . $resultat['obituary_press'] . '</li>';
   
    // Ajoutez d'autres colonnes ici
    echo '</div>';
    echo '<div class="display-btn-list-ad">';
    // ... (autres parties du code)
    echo '</div>';
    echo '</div>';
    echo '</ul>';
    echo '</li>';
    echo '</ul>';
    // var_dump($resultats);
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