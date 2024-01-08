<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<?php

?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav-family.php' ?>
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
<h1 class="display grey text-align padding-title">Espace&nbsp;<span class="blue">Famille</span></h1>


<?php include './_includes./_form.php' ?>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>