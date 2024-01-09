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
                // Ajouter un message de bienvenue à la session
                $_SESSION["welcome_message"] = "<h1 class='display grey text-align padding-title'>Bienvenue&nbsp;<span class='blue'>$admin</span></h1>";
                

                header("location: ../back-office/admin.php");
            } else {
                    // Identifiants invalides, afficher un message d'erreur
                    $_SESSION['error'] = 'Identifiants invalides';
                    header("location: ../back-office/login.php");
                };
            }
        }
    }


?>


<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Connexion&nbsp;<span class="blue">Admin</span></h1>
<?php

if (isset($_SESSION["logout_message"])) {
    echo '<div class="notification">' . $_SESSION["logout_message"] . '</div>';
}
if (isset($_SESSION["error"])) {
    echo '<div class="notification">' . $_SESSION["error"] . '</div>';
}
var_dump($_SESSION);
?>
<section class="form-co">
    <form class="connexion" action="" method="post">
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