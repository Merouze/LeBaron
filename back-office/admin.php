<!-- // ----- # HEAD # ----- // -->
<?php include '../back-office/_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>


<!-- section header title -->
<?php

// Display welcome message
if (isset($_SESSION["welcome_message"])) {
    echo '<div class="notification">' . $_SESSION["welcome_message"] . '</div>';
}

?>
<section class="header-pages">
</section>

<h1 class="display grey text-align padding-title">Espace&nbsp;<span class="blue">admin</span></h1>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>