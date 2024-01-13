<!-- // ----- # HEAD # ----- // -->
<?php include '../back-office/_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
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
    if (isset($_SESSION['notif'])) {
        echo '<span class="mb50 display-flex-center success">' . $_SESSION['notif'] . '</span>';
        unset($_SESSION['notif']);
    }
    if (isset($_SESSION['error'])) {
        echo '<p class="mb50 display-flex-center error">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>
</div>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>