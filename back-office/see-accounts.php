<!-- // ----- # HEAD # ----- // -->
<?php include '../back-office/_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<!-- section header title -->
<section class="header-pages">
</section class="resultats-recherche">
<div class="display-flex">
    <h1 class="mb50 display grey text-align padding-title">Comptes&nbsp;<span class="blue">Familles</span></h1>
    <?php
    // Affichage des notifications ou erreurs
    if (isset($_SESSION['notif']) && is_array($_SESSION['notif'])) {
        echo '<span class="mb50 display-flex-center ' . $_SESSION['notif']['type'] . '">' . $_SESSION['notif']['message'] . '</span>';
        unset($_SESSION['notif']);
    } elseif (isset($_SESSION['error'])) {
        echo '<span class="mb50 display-flex-center error">' . $_SESSION['error'] . '</span>';
        unset($_SESSION['error']);
    }
    ?>
</div>
<!-- Search accounts -->
<?php
if (isset($_SESSION['search_results'])) {
    // Récupérez les résultats de la session
    $results = $_SESSION['search_results'];

    // Affichez le tableau de résultats dans une liste
    echo '<ul class="resultats-recherche">';
    echo '<h3>Résultat(s)</h3>';
    foreach ($results as $result) {
        echo '<div class="display-mtb20 display_list-ad display-search-admin"><div class="text-align"><li>';
        echo '<span class="bold">Email :</span> ' . $result['email'] . '<br>';
        echo '<span class="bold">Nom/Prénom du défunt :</span> ' . $result['nom_prenom_defunt'] . '<br>';
        echo '<span class="bold">ID du défunt :</span> ' . $result['id_defunt'];
        echo '</li></div>';
        echo '<div class="display-btn-list-ad">
        <p class="obituary-cta">
            <a class="cta-btn-list-ad cta-obituary" href="_treatment/_search_accounts.php?idDefunt=' . urlencode($result['id_defunt']) . '" onclick="confirmDeleteAll(' . $result['id_defunt'] . ')">
                Supprimez toute les données famille
            </a>
        </p>
    </div></div>';
    }
    echo '</ul>';

    // Effacez les résultats de la session une fois affichés
    unset($_SESSION['search_results']);
} else {
 
}
?>
<section>
    <form method="post" action="_treatment/_search_accounts.php">
        <h3>Rechercher par le Nom/Prénom du défunt, <p>ou l'adresse mail famille :</p>
        </h3>
        <input name="search" type="text">
        <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
        <button name="search-accounts" type="submit">Rechercher</button>
    </form>
</section>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>

<script src=".././asset/Js/script.js"></script>
<script src=".././asset/Js/fonctions.js"></script>
</body>

</html>