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
<div class="border-check">
    <h2>Infos Défunt</h2>
    <p> 
        <?= '<li><span class="bold grey">Prénom du défunt :</span> ' . $resultat['firstname_defunt'] . '</li>'; ?>
        <?= '<li><span class="bold grey">Nom défunt :</span> ' . $resultat['lastname_defunt'] . '</li>'; ?>
        <?= '<li><span class="bold grey">Date de naissance du défunt :</span> ' . $dateBornformatee . '</li>'; ?>
        <?= '<li><span class="bold grey">Lieu de naissance du défunt :</span> ' . $resultat['location_born'] . '</li>'; ?>
        <?= '<li><span class="bold grey">Code postale du lieu de naissance :</span> ' . $resultat['cp_born'] . '</li>'; ?>
        <?= '<li><span class="bold grey">Date du décès :</span> ' . $dateDeathformatee . '</li>'; ?>
        <?= '<li><span class="bold grey">Lieu du décès:</span> ' . $resultat['location_death'] . '</li>'; ?>
        <?= '<li><span class="bold grey">Ville du décès :</span> ' . $resultat['city_death'] . '</li>'; ?>
        <?= '<li><span class="bold grey">Code postal :</span> ' . $resultat['city_death_cp'] . '</li>'; ?>
        <!-- <?= var_dump($resultat);?> -->
    </p>
</div>
<div class="border-check">
    <h2>Infos Cérémonies</h2>
    <p>
    <?= '<li><span class="bold grey">Type de demande:</span> ' . $resultat['type_demande'] . '</li>'; ?>
    <?= '<li><span class="bold grey">Présentation du corps :</span> ' . $resultat['presentation_corps'] . '</li>'; ?>
        <?= '<li><span class="bold grey">Soin de conservation du corps :</span> ' . $resultat['body_care'] . '</li>'; ?>

        <?= '<li><span class="bold grey">Type d\'obsèques:</span> ' . $resultat['type_funeral'] . '</li>'; ?>
        <?= '<li><span class="bold grey">Type de cérémonie :</span> ' . $resultat['type_ceremony'] . '</li>'; ?>
        <?= '<li><span class="bold grey">Type de sépulture :</span> ' . $resultat['type_sepulture'] . '</li>'; ?>
        <?= '<li><span class="bold grey">Ville et/ou code postal de la cérémonie :</span> ' . $resultat['city_ceremony'] . '</li>'; ?>
    </p>
</div>
<div class="border-check">
    <h2>Infos Client</h2>
    <p>

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
    </p>
</div>

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