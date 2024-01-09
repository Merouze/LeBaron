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

// Affichage des notifications
if (isset($_SESSION['notif'])) {
    $notifType = $_SESSION['notif']['type'];
    $notifMessage = $_SESSION['notif']['message'];

    echo "<div class='notification $notifType'>$notifMessage</div>";

    // Nettoyer la notification après l'affichage
    unset($_SESSION['notif']);
}
?>
<section class="header-pages">
</section>
<?php var_dump($idDefunt); ?>

<h1 class="display grey text-align padding-title">Espace&nbsp;<span class="blue">Famille</span></h1>
<div class="nav-links">
    <ul>
        <li><a href="obituary-family.php?idDefunt=<?= urlencode($idDefunt) ?>">Voir l'Avis de Décès</a></li>
        <li><a href="condolences-family.php?idDefunt=<?= urlencode($idDefunt) ?>">Voir les Condoléances</a></li>
    </ul>
</div>
<?php include './_includes./_form.php' ?>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>