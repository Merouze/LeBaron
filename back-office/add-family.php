<?php
// Inclure les fichiers nécessaires, y compris la connexion à la base de données
include './_includes/_head.php';
include './_includes/_nav-admin.php';
include './_includes/_check-login.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']);
    $confirmPassword = strip_tags($_POST['confirm-password']);

    // Vérifier si les mots de passe correspondent
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = 'Les mots de passe ne correspondent pas';
        header("Location: admin.php");
        exit;
    }

    // Vérifier si l'email existe déjà dans la base de données
    $queryCheckEmail = $dtLb->prepare("SELECT COUNT(*) FROM user_famille WHERE email = :email");
    $queryCheckEmail->execute(['email' => $email]);
    $emailExists = $queryCheckEmail->fetchColumn();

    // Si l'email existe, ajouter une notification d'erreur à la session
    if ($emailExists) {
        $_SESSION['error'] = 'Un compte avec cet email existe déjà';
    } else {
        // Hasher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insérer les données dans la base de données
        $sqlInsertFamille = $dtLb->prepare("INSERT INTO user_famille (email, mot_de_passe, id_defunt) VALUES (:email, :password, :id_defunt)");
        $sqlInsertFamille->execute([
            'email' => $email,
            'password' => $hashedPassword,
            'id_defunt' => $_GET['idDefunt']
        ]);

        // Vérifier si l'insertion a réussi
        if ($sqlInsertFamille) {
            $_SESSION['notif'] = 'Compte famille ajouté';
        } else {
            $_SESSION['error'] = 'Erreur à la création du compte';
        }
    }

    // Rediriger vers une page de confirmation ou une autre page pertinente
    header("Location: admin.php");
    exit;
}
?>


<!-- section header title -->
<section class="header-pages"></section>
<h1 class="display grey text-align padding-title">Ajouter une&nbsp;<span class="blue">Famille</span></h1>

<!-- Formulaire d'ajout de famille -->
<form method="post" action="">
    <label for="email">Email :</label>
    <input type="text" id="email" name="email" required>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>
    
    <label for="confirm-password">Confirmer le mot de passe :</label>
    <input type="password" id="confirm-password" name="confirm-password" required>
    
    <button type="submit">Créer le compte famille</button>
</form>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php'; ?>

<script src=".././asset/Js/script.js"></script>
<script src=".././asset/Js/fonctions.js"></script>
</body>
</html>
