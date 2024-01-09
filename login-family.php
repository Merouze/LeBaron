<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- section header title -->
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>
<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

   // Rechercher l'utilisateur dans la base de données
$query = $dtLb->prepare("SELECT id_user, email, mot_de_passe, id_defunt FROM user_famille WHERE email = :email");
$query->execute(['email' => $email]);
$user = $query->fetch();

// Vérifier si l'utilisateur existe et si le mot de passe est correct
if ($user && password_verify($password, $user['mot_de_passe'])) {
    // Stocker des informations dans la session
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['id_defunt'] = $user['id_defunt']; // Récupérer également l'ID du défunt

    // Rediriger vers l'espace famille
    header("Location: see-message.php?idDefunt=" . urlencode($user['id_defunt'])); // Utiliser l'ID du défunt dans la redirection
    exit;
} else {
    // Identifiants invalides, afficher un message d'erreur
    $_SESSION['error'] = 'Identifiants invalides';
    header("Location: connexion-famille.php");
    exit;
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