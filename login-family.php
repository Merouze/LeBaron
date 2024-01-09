<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- section header title -->
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>
<?php

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si la clé 'admin' existe dans $_POST
    if (isset($_POST['email'])) {
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
        
        // Rechercher l'utilisateur dans la base de données
        $query = $dtLb->prepare("SELECT email, mot_de_passe, id_defunt FROM user_famille WHERE email = :email");
        $query->execute(['email' => $email]);
        
        
        $user = $query->fetch();
        $_SESSION["id_defunt"] = $user['id_defunt'];
        
        // Vérifier si la requête a renvoyé des résultats avant d'accéder à $result['password']
        if ($query->rowCount() == 1 && password_verify($password, $user['mot_de_passe'])) {
            
            $hash = $user['mot_de_passe'];

            if (password_verify($password, $hash)) {
                // Utilisateur authentifié, rediriger vers l'espace administrateur
                $_SESSION["loggedin"] = true;
                // Ajouter un message de bienvenue à la session
                $_SESSION["welcome_message"] = "<h1 class='display grey text-align padding-title'>Bienvenue</h1>";


                header("location: ./index-family.php");
            } else {
                // Identifiants invalides, afficher un message d'erreur
                $_SESSION['error'] = 'Identifiants invalides';
                // header("location: ./login.php");
            };
        }
    }
}
?>

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
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Connexion à l'espace&nbsp;<span class="blue">Famille</span></h1>
<section class="form-co">
    <form class="connexion" action="" method="post">
        <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
        <label class="label" for="email">Adresse e-mail:</label>
        <input type="email" id="email" name="email" required>
        <label class="label" for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Se connecter</button>
    </form>
</section>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>