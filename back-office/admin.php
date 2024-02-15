<!-- // ----- # HEAD # ----- // -->
<?php include '../back-office/_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_see-count-estimate-condolence.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>
<div class="display-flex">
    <?php
    // Récupérer le message de bienvenue depuis le paramètre GET
    $welcomeMessage = isset($_GET['welcome_message']) ? urldecode($_GET['welcome_message']) : '';
    if (isset($_GET['welcome_message'])) {
        echo $welcomeMessage;
    }
    ?>
    <h1 class="mb50 display grey text-align padding-title">Espace&nbsp;<span class="blue">admin</span></h1>
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
       <div class="text-align">
        <h2>Vous avez <span class="blue"><?= $totalDevisPrev + $totalDevisObs + $totalDevisMar; ?> </span>devis à traiter, et <span class="blue"><?= $totalCondolences ?></span> condoléance(s) à vérifié.</h2>
    </div>
</div>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>

<script src=".././asset/Js/script.js"></script>
<script src=".././asset/Js/fonctions.js"></script>
</body>
</html>