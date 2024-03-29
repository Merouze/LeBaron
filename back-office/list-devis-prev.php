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
    $sqlSearch = $dtLb->prepare("SELECT id_estimate, prenom, nom, date_demande
    FROM devis_prevoyance
    WHERE prenom LIKE :recherche
    AND traite = 1");
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
// Request count estimate with traite = 0
$sqlCount = $dtLb->prepare("SELECT COUNT(*) AS totalDevis
    FROM devis_prevoyance
    WHERE traite = 0");
$sqlCount->execute();
$totalDevis = $sqlCount->fetch(PDO::FETCH_ASSOC)['totalDevis'];
?>

<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- section header title -->
<?php
// Display notifs
if (isset($_SESSION["notif"]) && is_array($_SESSION["notif"])) {
    $notifType = $_SESSION["notif"]["type"];
    $notifMessage = $_SESSION["notif"]["message"];
    echo '<div class="notification ' . $notifType . '">' . $notifMessage . '</div>';
    unset($_SESSION['notif']);
}

?>
<section class="header-pages">
</section>
<!-- Afficher les résultats de la recherche -->
<section class="resultats-recherche">
    <?php
    if (isset($resultats) && !empty($resultats)) : ?>
        <h2 class="text-align">Résultats de la <span class="blue">recherche</span></h2>
        <h3><span class="blue">Devis</span> " traité ".</h3>
        <ul>
            <?php foreach ($resultats as $resultat) :
                // Créer un objet DateTime pour la date de la cérémonie
                $dateDemande = new DateTime($resultat['date_demande']);

                // Formater la date en jours/mois/année
                $dateFormatee = $dateDemande->format('d/m/Y');
            ?>
                <li>
                    <ul>
                        <div class="display-mtb20 display_list-ad display-search-admin">
                            <div class="display-li-ad">
                                <li></li>
                                <li class="bold grey"><?= $resultat['prenom'] . ' ' . $resultat['nom'] . '' ?></li>
                                <li class="bold blue"><?= $dateFormatee ?></li>
                            </div>
                            <div class="display-btn-list-ad">
                                <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" target="_blank" href="_treatment/_treatment_see_estimate_prev.php?idEstimate=<?= urlencode($resultat['id_estimate']) ?>&token=<?= $_SESSION['myToken'] ?>">Consulter</a></p>
                                <div class="display-btn-list-ad">
                                    <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="modif-estimate-prev.php?idEstimate=<?= urlencode($resultat['id_estimate']) ?>&token=<?= $_SESSION['myToken'] ?>">Modifier</a></p>
                                    <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="_treatment/_treatment_sent_estimate_prev.php?idEstimate=<?= urlencode($resultat['id_estimate']) ?>&token=<?= $_SESSION['myToken'] ?>">Envoyer</a></p>
                                    <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="javascript:void(0);" onclick="confirmDeleteEstimateTraitePrev(<?= $resultat['id_estimate'] ?>);">Supprimer le devis et la demande</a></p>
                                </div>
                            </div>
                        </div>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
<h1 class="text-align bold grey">Les devis prévoyance<span class="blue"> à traiter</span></h1>
<?= "<p class='text-align'>Il y a actuellement <span class='blue bold'>$totalDevis</span> devis à traiter.</p>" ?>

<!-- display estimate no checking -->
<section class="resultats-recherche">
    <?php
    $sqlDisplay = $dtLb->prepare("SELECT id_estimate, prenom, nom, date_demande
    FROM devis_prevoyance
    WHERE traite = 0
    LIMIT 4");

    // Exécutez la requête
    $sqlDisplay->execute();

    // Récupérez les résultats après l'exécution de la requête
    $lists = $sqlDisplay->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($lists);

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
        echo '<li class="bold grey">' . $list['prenom'] . ' ' . $list['nom'] . '</li>';
        echo '<li class="bold blue">' . $dateFormatee . '</li>'; // Modifier cette ligne
        echo '</div>';
        echo '<div class="display-btn-list-ad">';
        echo '<p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="see-estimate.php?idEstimate=' . urlencode($list['id_estimate']) . '">Traiter la demande</a></p>';
        echo '<p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="javascript:void(0);" onclick="confirmDeleteEstimatePrev(' . $list['id_estimate'] . ');">Supprimer la demande</a></p>';
        echo '</div>';
        echo '</div>';
        echo '</ul>';
        echo '</li>';
    }
    echo '</ul>';
    ?>
</section>

<!-- <?php var_dump($_SESSION); ?> -->

<!-- section obituary -->
<section class="obituary mt50 mt100">
    <div class="obituary-text ad">
        <form class="recherche-ad" action="">
            <h3 class="text-align white">Rechercher les devis traité par Nom ou Prénom</h3>
            <label for="recherche"></label>
            <input name="recherche" class="input-ad" type="text">
            <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
            <button type="submit" class="cta-ad ">Rechercher</button>
        </form>
    </div>
</section>


<!-- <script>
    function confirmDeleteEstimate(idEstimate) {
        // Utilisez la fonction confirm() pour afficher une boîte de dialogue avec les boutons OK et Annuler
        var confirmation = confirm("Êtes-vous sûr de vouloir supprimer cette demande de devis ?");

        // Si l'utilisateur clique sur OK, redirigez vers la page de suppression avec l'id
        if (confirmation) {
            window.location.href = `./_treatment/_delete-estimate-prev.php?idEstimate=${idEstimate}`;
        }
    }
</script> -->
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>

<script src=".././asset/Js/script.js"></script>
<script src=".././asset/Js/fonctions.js"></script>
</body>
</html>