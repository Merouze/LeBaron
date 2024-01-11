<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login-family.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav-family.php' ?>
<?php
// Récupérer l'id_defunt de la session
$idDefunt = isset($_SESSION['id_defunt']) ? $_SESSION['id_defunt'] : null;
// Requête pour récupérer les messages de condoléances
$sqlSelectCondolences = $dtLb->prepare("SELECT id_defunt, id_condolence, nom_expditeur, email_expditeur, message, date_envoi, is_published FROM condolences WHERE id_defunt = :id_defunt ORDER BY date_envoi DESC");
$sqlSelectCondolences->execute(['id_defunt' => $idDefunt]);
$condolences = $sqlSelectCondolences->fetchAll(PDO::FETCH_ASSOC);
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Rediriger vers la page de connexion
    header("location: ./login-family.php");
    exit;
}
?>
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Espace&nbsp;<span class="blue">Famille</span></h1>
<?php
// Récupérer le message de bienvenue depuis le paramètre GET
$welcomeMess = isset($_GET['welcome_mess']) ? urldecode($_GET['welcome_mess']) : '';
if (isset($_GET['welcome_mess'])) {
    echo $welcomeMess;
}    // Affichage des notifications ou erreurs
if (isset($_SESSION['notif'])) {
    echo '<span class="mb50 display-flex-center success">' . $_SESSION['notif'] . '</span>';
    unset($_SESSION['notif']);
}
if (isset($_SESSION['error'])) {
    echo '<p class="mb50 display-flex-center error">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
?>
<div class="nav-links justify">
    <ul>
        <li><a href="obituary-family.php?idDefunt=<?= urlencode($idDefunt) ?>">Voir l'Avis de Décès</a></li>
        <li><a href="condolences-family.php?idDefunt=<?= urlencode($idDefunt) ?>">Voir les Condoléances</a></li>
    </ul>
</div>
<?php include './_includes./_form.php' ?>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>