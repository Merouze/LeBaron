<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<?php
// Vérifier si le formulaire de recherche a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['recherche'])) {
    // Nettoyer et récupérer la valeur du champ de recherche
    $recherche = strip_tags($_GET['recherche']);
    
    // Exécuter la requête de recherche dans la base de données
    $sqlSearch = $dtLb->prepare("SELECT d.id_defunt, d.nom_prenom_defunt, d.age, c.date_ceremonie
    FROM ceremonie c
    JOIN defunt d ON c.id_defunt = d.id_defunt WHERE nom_prenom_defunt LIKE :recherche");
    $sqlSearch->execute(['recherche' => "%$recherche%"]);
    $resultats = $sqlSearch->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>
<!-- Afficher les résultats de la recherche -->
<?php

// Affichage des notifications
if (isset($_SESSION['notif'])) {
    $notifType = $_SESSION['notif']['type'];
    $notifMessage = $_SESSION['notif']['message'];
    
    echo "<div class='notification $notifType'>$notifMessage</div>";
    
    // Nettoyer la notification après l'affichage
    unset($_SESSION['notif']);
}
?>
<h1 class="display grey text-align padding-title">Liste des&nbsp;<span class="blue">Avis de décès</span></h1>
<!-- Afficher les résultats de la recherche -->
<section class="resultats-recherche">
    <?php
    if (isset($resultats) && !empty($resultats)) : ?>
        <h2 class="text-align">Résultats de la <span class="blue">recherche</span></h2>
        <ul>
            <?php foreach ($resultats as $resultat) : ?>
                <li>
                    <ul>
                        <div class="display-mtb20 display_list-ad display-search-admin ">
                            <div class="display-li-ad">
                                <li class="bold grey"><?= $resultat['nom_prenom_defunt'] . ' ' . $resultat['age'] . ' ans' ?></li>
                                <li class="bold blue"><?= $resultat['date_ceremonie'] ?></li>
                            </div>
                            <div class="display-btn-list-ad-cl">
                            <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="avis-deces.php?idDefunt=<?= urlencode($resultat['id_defunt']) ?>">Consulter</a></p>
                            </div>
                        </div>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</section>


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
<!-- section li defunt -->

<section class="display-ad">
    <h3 class="mb50 text-align grey">Nos derniers avis de <span class="blue">décès publiés</span></h3>
    <?php
    $idDefunt = isset($_GET['idDefunt']) ? $_GET['idDefunt'] : null;
    
    $sqlGetLastAvis = $dtLb->query("SELECT d.id_defunt, d.nom_prenom_defunt, d.age, c.date_ceremonie
    FROM ceremonie c
    JOIN defunt d ON c.id_defunt = d.id_defunt
    ORDER BY c.date_ceremonie DESC
    LIMIT 4");

    $lastAvis = $sqlGetLastAvis->fetchAll(PDO::FETCH_ASSOC);

    echo '<ul>';
    foreach ($lastAvis as $avis) {
        echo '<li>';
        echo '<ul>';
        echo '<div class="display-mtb20 display_list-ad-cl">';
        echo '<div>';
        echo '<li class="bold grey">' . $avis['nom_prenom_defunt'] . ' ' . $avis['age'] . ' ans</li>';
        echo '<li class="bold blue">' . $avis['date_ceremonie'] . '</li>';
        echo '</div>';
        echo '<div>';
        echo '<p class="obituary-cta"><a class="cta-obituary" href="avis-deces.php?idDefunt=' . urlencode($avis['id_defunt']) . '">Consulter</a></p>';
        echo '</div>';
        echo '</div>';
        echo '</ul>';
        echo '</li>';
    }
    echo '</ul>';
    ?>
</section>
<!-- // ----- # FORM # ----- // -->
<?php include './_includes./_form.php' ?>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>