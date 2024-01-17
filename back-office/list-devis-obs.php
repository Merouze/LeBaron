<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<?php
// Vérifier si le formulaire de recherche a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['recherche'])) {
    // Nettoyer et récupérer la valeur du champ de recherche
    $recherche = strip_tags($_GET['recherche']);
    // Exécuter la requête de recherche dans la base de données
    $sqlSearch = $dtLb->prepare("SELECT id_estimate, firstname, lastname, date_demande
    FROM devis_obs
    WHERE firstname OR lastname LIKE :recherche");
    $sqlSearch->execute(['recherche' => "%$recherche%"]);
    $resultats = $sqlSearch->fetchAll(PDO::FETCH_ASSOC);
    // Vérifier s'il y a des résultats
    if ($sqlSearch->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Résultat trouvé.'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Aucun résultat trouvé pour la recherche.'];
    }
}
?>
<?php
// Requête pour compter le nombre total de devis avec traite = 0
$sqlCount = $dtLb->prepare("SELECT COUNT(*) AS totalDevis
    FROM devis_obs
    WHERE traite = 0");
// Exécutez la requête de comptage
$sqlCount->execute();
// Récupérez le résultat du comptage
$totalDevis = $sqlCount->fetch(PDO::FETCH_ASSOC)['totalDevis'];
?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- section header title -->
<?php
// Display notifs
if (isset($_SESSION["notif"])) {
    $notifType = $_SESSION["notif"]["type"];
    $notifMessage = $_SESSION["notif"]["message"];
    echo '<div class="notification ' . $notifType . '">' . $notifMessage . '</div>';
    unset($_SESSION['notif']);
}
?>
<section class="header-pages">
</section>
<h1 class="text-align bold grey">Les devis obsèques<span class="blue"> à traiter</span></h1>
<?= "<p class='text-align'>Il y a actuellement $totalDevis devis à traiter.</p>" ?>
<!-- display estimate no checking -->
<section class="resultats-recherche">
    <h3 class="mb50 text-align grey">Devis à <span class="blue">traiter</span></h3>
    <?php
    $sqlDisplay = $dtLb->prepare("SELECT id_estimate, firstname, lastname, date_demande
    FROM devis_obs
    WHERE traite = 0
    LIMIT 4");
    // Exécutez la requête
    $sqlDisplay->execute();
    // Récupérez les résultats après l'exécution de la requête
    $lists = $sqlDisplay->fetchAll(PDO::FETCH_ASSOC);
    // Boucle pour générer le code HTML
    echo '<ul>';
    foreach ($lists as $list) {
        // Créer un objet DateTime pour la date de la cérémonie
        $dateCeremonie = new DateTime($list['date_demande']);
        // Formater la date en jours/mois/année
        $dateFormatee = $dateCeremonie->format('d/m/Y');
        echo '<li>';
        echo '<ul>';
        echo '<div class="display-mtb20 display_list-ad">';
        echo '<div class="display-li-ad">';
        echo '<li class="bold grey">' . $list['firstname'] . ' ' . $list['lastname'] . '</li>';
        echo '<li class="bold blue">' . $dateFormatee . '</li>';
        echo '</div>';
        echo '<div class="display-btn-list-ad">';
        echo '<p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="see-estimate-obs.php?idEstimate=' . urlencode($list['id_estimate']) . '">Consulter</a></p>';
        echo '<p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="javascript:void(0);" onclick="confirmDeleteEstimate(' . $list['id_estimate'] . ');">Supprimer</a></p>';
        echo '</div>';
        echo '</div>';
        echo '</ul>';
        echo '</li>';
    }
    echo '</ul>';
    ?>
</section>

<!-- Afficher les résultats de la recherche -->
<section class="resultats-recherche">
    <?php
    if (isset($resultats) && !empty($resultats)) : ?>
        <h2 class="text-align">Résultats de la <span class="blue">recherche</span></h2>
        <ul>
            <?php foreach ($resultats as $resultat) :
                // Créer un objet DateTime pour la date de la cérémonie
                $dateDemande = new DateTime($resultat['date_demande']);

                // Formater la date en jours/mois/année
                $dateFormatee = $dateDemande->format('d/m/Y');
            ?>

                <li>
                    <ul>
                        <div class="display-mtb20 display_list-ad display-search-admin ">
                            <div class="display-li-ad">
                                <li></li>
                                <li class="bold grey"><?= $resultat['firstname'] . ' ' . $resultat['lastname'] . '' ?></li>
                                <li class="bold blue"><?= $dateFormatee ?></li>
                            </div>
                            <div class="display-btn-list-ad">
                                <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="see-estimate-obs.php?idEstimate=<?= urlencode($resultat['id_estimate']) ?>">Consulter</a></p>
                                <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="javascript:void(0);" onclick="confirmDeleteEstimate(<?= $resultat['id_estimate'] ?>);">Supprimer</a></p>
                            </div>
                        </div>
                    </ul>
                </li>
                <!-- <?php var_dump($resultats); ?> -->
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<!-- <?php var_dump($_SESSION); ?> -->
<!-- section obituary -->
<section class="obituary mt50 mt100">
    <div class="obituary-text ad">
        <form class="recherche-ad" action="">
            <h3 class="text-align white">Recherche de devis par Nom ou Prénom</h3>
            <label for="recherche"></label>
            <input name="recherche" class="input-ad" type="text">
            <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
            <button type="submit" class="cta-ad ">Rechercher</button>
        </form>
    </div>
</section>


<script>
    function confirmDeleteEstimate(idEstimate) {
        // Utilisez la fonction confirm() pour afficher une boîte de dialogue avec les boutons OK et Annuler
        var confirmation = confirm("Êtes-vous sûr de vouloir supprimer cette demande de devis ?");

        // Si l'utilisateur clique sur OK, redirigez vers la page de suppression avec l'id
        if (confirmation) {
            window.location.href = `./_treatment/_delete-estimate.php?idEstimate=${idEstimate}`;
        }
    }
</script>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>