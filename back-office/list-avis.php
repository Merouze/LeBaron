<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Liste des &nbsp;<span class="blue">Avis de décès</span></h1>

<section class="display-ad">
    <?php
    $idDefunt = isset($_GET['idDefunt']) ? $_GET['idDefunt'] : null;

    $sqlGetLastAvis = $dtLb->query("SELECT d.id_defunt, d.nom_prenom_defunt, d.age, c.date_ceremonie
    FROM ceremonie c
    JOIN defunt d ON c.id_defunt = d.id_defunt
    ORDER BY c.date_ceremonie DESC
    LIMIT 4");
    
    $lastAvis = $sqlGetLastAvis->fetchAll(PDO::FETCH_ASSOC);
    // Boucle pour générer le code HTML
    echo '<ul>';
    foreach ($lastAvis as $avis) {
        echo '<li>';
        echo '<ul>';
        echo '<div class="display-mtb20">';
        echo '<div>';
        echo '<li>' . $avis['nom_prenom_defunt'] . ' ' . $avis['age'] . ' ans</li>';
        echo '<li class="blue">' . $avis['date_ceremonie'] . '</li>';
        echo '</div>';
        echo '<div>';
        echo '<p class="obituary-cta"><a class="cta-obituary" href="see-avis.php?idDefunt=' . urlencode($avis['id_defunt']) . '">Consulter +</a></p>';
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