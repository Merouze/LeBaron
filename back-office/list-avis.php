<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<?php
// Vérifier si le formulaire de recherche a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['recherche']) && isset($_GET['token'])) {
    // Nettoyer et récupérer la valeur du champ de recherche
    $token = strip_tags($_GET['token']);
    $recherche = strip_tags($_GET['recherche']);
    $idCondolence = isset($_GET['idCondolence']) ? $_GET['idCondolence'] : null;
    if ($token === $_SESSION['myToken']) {

        // Exécuter la requête de recherche dans la base de données
        $sqlSearch = $dtLb->prepare("SELECT d.id_defunt, d.nom_prenom_defunt, d.age, c.date_ceremonie
    FROM ceremonie c
    JOIN defunt d ON c.id_defunt = d.id_defunt WHERE nom_prenom_defunt LIKE :recherche");
        $sqlSearch->execute(['recherche' => "%$recherche%"]);
        $resultats = $sqlSearch->fetchAll(PDO::FETCH_ASSOC);

        // Vérifier s'il y a des résultats
        if ($sqlSearch->rowCount() > 0) {
            $_SESSION['notif'] = ['type' => 'success', 'message' => 'Résultat trouvé.'];
        } else {
            $_SESSION['notif'] = ['type' => 'error', 'message' => 'Aucun résultat trouvé pour la recherche.'];
        }
    }
}
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
    if (isset($resultats) && !empty($resultats)) :
    ?>
        <h2 class="text-align">Résultats de la <span class="blue">recherche</span></h2>
        <ul>
            <?php foreach ($resultats as $resultat) :
                $sqlCountCondolences = $dtLb->prepare("SELECT COUNT(id_condolence) AS nb_condolences FROM condolences WHERE id_defunt = :id_defunt AND is_published = 0");
                $sqlCountCondolences->execute(['id_defunt' => $resultat['id_defunt']]);
                $row = $sqlCountCondolences->fetch(PDO::FETCH_ASSOC);
                $nbCondolences = $row['nb_condolences'];
                // Créer un objet DateTime pour la date de la cérémonie
                $dateCeremonie = new DateTime($resultat['date_ceremonie']);
                // Formater la date en jours/mois/année
                $dateFormatee = $dateCeremonie->format('d/m/Y');
            ?>
                <li>
                    <ul>
                        <div class="display-mtb20 display_list-ad display-search-admin ">
                            <div class="display-li-ad">
                                <li class="bold grey"><?= $resultat['nom_prenom_defunt'] . ' ' . $resultat['age'] . ' ans' ?></li>
                                <li class="bold blue"><?= $dateFormatee ?></li>
                            </div>
                            <div class="display-btn-list-ad">
                                <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="see-avis.php?idDefunt=<?= urlencode($resultat['id_defunt']) ?>">Consulter</a></p>
                                <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="modif-avis.php?idDefunt=<?= urlencode($resultat['id_defunt']) ?>">Modifier</a></p>
                                <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="check-message.php?idDefunt=<?= urlencode($resultat['id_defunt']) ?>">Condoléances (<?= $nbCondolences ?>)</a></p>
                                <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="add-family.php?idDefunt=<?= urlencode($resultat['id_defunt']) ?>">Ajouter un compte</a></p>
                                <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="javascript:void(0);" onclick="confirmDelete(<?= $resultat['id_defunt'] ?>);">Supprimer</a></p>
                            </div>
                        </div>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<!-- <?php var_dump($_SESSION); ?> -->
<!-- section obituary -->
<section class="obituary mt50 mt100">
    <div class="obituary-text ad">
        <form class="recherche-ad" action="">
            <h3 class="text-align white">Recherche par Nom ou Prénom</h3>
            <label for="recherche"></label>
            <input name="recherche" class="input-ad" type="text">
            <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
            <button type="submit" class="cta-ad ">Rechercher</button>
        </form>
    </div>
</section>
<!-- Afficher les derniers avis de deces publiés -->
<section class="resultats-recherche">
    <h3 class="mb50 text-align grey">Nos derniers avis de <span class="blue">décès publiés</span></h3>

    <?php
    $idDefunt = isset($_GET['idDefunt']) ? $_GET['idDefunt'] : null;
    $idCondolence = isset($_GET['idCondolence']) ? $_GET['idCondolence'] : null;

    $sqlGetLastAvis = $dtLb->query("SELECT d.id_defunt, d.nom_prenom_defunt, d.age, c.date_ceremonie, GROUP_CONCAT(co.id_condolence) AS id_condolence
    FROM ceremonie c
    JOIN defunt d ON c.id_defunt = d.id_defunt
    LEFT JOIN condolences co ON d.id_defunt = co.id_defunt
    GROUP BY d.id_defunt
    ORDER BY c.date_ceremonie DESC
    LIMIT 4");

    $lastAvis = $sqlGetLastAvis->fetchAll(PDO::FETCH_ASSOC);
    // Boucle pour générer le code HTML
    echo '<ul>';
    foreach ($lastAvis as $avis) {
        $sqlCountCondolences = $dtLb->prepare("SELECT COUNT(id_condolence) AS nb_condolences FROM condolences WHERE id_defunt = :id_defunt AND is_published = 0");
        $sqlCountCondolences->execute(['id_defunt' => $avis['id_defunt']]);
        $row = $sqlCountCondolences->fetch(PDO::FETCH_ASSOC);
        $nbCondolences = $row['nb_condolences'];
        // Créer un objet DateTime pour la date de la cérémonie
        $dateCeremonie = new DateTime($avis['date_ceremonie']);

        // Formater la date en jours/mois/année
        $dateFormatee = $dateCeremonie->format('d/m/Y');
        echo '<li>';
        echo '<ul>';
        echo '<div class="display-mtb20 display_list-ad">';
        echo '<div class="display-li-ad">';
        echo '<li class="bold grey">' . $avis['nom_prenom_defunt'] . ' ' . $avis['age'] . ' ans</li>';
        echo '<li class="bold blue">' . $dateFormatee . '</li>';
        echo '</div>';
        echo '<div class="display-btn-list-ad">';
        echo '<p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="see-avis.php?idDefunt=' . urlencode($avis['id_defunt']) . '">Consulter</a></p>';
        echo '<p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="modif-avis.php?idDefunt=' . urlencode($avis['id_defunt']) . '">Modifier</a></p>';
        echo '<p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="check-message.php?idDefunt=' . urlencode($avis['id_defunt']) . '">Condoléances (' . $nbCondolences . ')</a></p>';
        echo '<p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="add-family.php?idDefunt=' . urlencode($avis['id_defunt']) . '">Ajouter un compte</a></p>';
        echo '<p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="javascript:void(0);" onclick="confirmDelete(' . $avis['id_defunt'] . ');">Supprimer</a></p>';
        echo '</div>';
        echo '</div>';
        echo '</ul>';
        echo '</li>';
    }
    echo '</ul>';
    ?>
</section>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>

<script src=".././asset/Js/script.js"></script>
<script src=".././asset/Js/fonctions.js"></script>
</body>

</html>