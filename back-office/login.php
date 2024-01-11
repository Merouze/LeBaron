<!-- // ----- # HEAD # ----- // -->
<?php include '../back-office/_includes/_head.php' ?>
<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si la clé 'admin' existe dans $_POST
    if (isset($_POST['admin'])) {
        $admin = strip_tags($_POST['admin']);
        $password = strip_tags($_POST['password']);
        // Utiliser une requête préparée pour éviter les injections SQL
        $query = $dtLb->prepare("SELECT admin, password FROM admin WHERE admin = :admin");
        $query->execute([
            'admin' => $admin,
        ]);
        $result = $query->fetch();
        // Vérifier si la requête a renvoyé des résultats avant d'accéder à $result['password']
        if ($query->rowCount() == 1 && isset($result['password'])) {
            $hash = $result['password'];
            if (password_verify($password, $hash)) {
                // Utilisateur authentifié, rediriger vers l'espace administrateur
                $_SESSION["loggedin"] = true;
                $_SESSION["notif"] = 'Vous êtes connecté';
                $_SESSION["welcome_message"] = "<p class='mt30 text-align bold'>Bienvenue <span class='blue'> $admin </span></p>";

                $welcomeMessage = urlencode($_SESSION["welcome_message"]);

                header("location: ../back-office/admin.php?welcome_message=$welcomeMessage");
                // header("location: ../back-office/admin.php");
                exit();
            }
        }
        // Si nous arrivons ici, c'est que les identifiants sont invalides
        $_SESSION['error'] = 'Identifiants invalides';
        header("location: ../back-office/login.php");
        exit();
    }
}
?>

<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Connexion&nbsp;<span class="blue">Admin</span></h1>
<section class="form-co">
    <form class="connexion" action="" method="post">
    <?php
    
    // Récupérer le message de bienvenue depuis le paramètre GET
    $notification = isset($_GET['notif']) ? urldecode($_GET['notif']) : '';
    if (isset($_GET['notif'])) {
        echo $notification;
    }

    // Affichage des notifications ou erreurs
    if (isset($_SESSION['notif'])) {
        echo '<span class="success">' . $_SESSION['notif'] . '</span>';
        unset($_SESSION['notif']);
    }
    if (isset($_SESSION['error'])) {
        echo '<span class="text-align error">' . $_SESSION['error'] . '</span>';
        unset($_SESSION['error']);
    }
    ?>
        <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
        <label class="label" for="admin">Nom:</label>
        <input type="text" id="admin" name="admin" required>
        <label class="label" for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Se connecter</button>
    </form>
</section>
<!-- // ----- # FOOTER # ----- // -->
<?php include '.././_includes/_footer.php' ?>