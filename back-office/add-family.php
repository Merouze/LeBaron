<?php
// Inclure les fichiers nécessaires, y compris la connexion à la base de données
include './_includes/_head.php';
include './_includes/_nav-admin.php';
include './_includes/_check-login.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hasher le mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insérer les données dans la base de données (utilisez votre propre requête SQL)
    $sqlInsertFamille = $dtLb->prepare("INSERT INTO user_famille (email, mot_de_passe, id_defunt) VALUES (:email, :password, :id_defunt)");
    $sqlInsertFamille->execute([
        'email' => $email,
        'password' => $hashedPassword,
        'id_defunt' => $_GET['idDefunt']
    ]);

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

    <button type="submit">Créer le compte famille</button>
</form>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php'; ?>
