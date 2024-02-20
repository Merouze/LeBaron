<?php
require ".././back-office/_includes/_dbCo.php";
session_start();
// var_dump($_POST);
// exit;
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'  && isset($_POST['token'])) {
    $token = strip_tags($_POST['token']);

    if (isset($_POST['email']) && $token === $_SESSION['myToken']) {
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['new-password']);
        
        $confirmPassword = strip_tags($_POST['confirm-new-password']);

        // Rechercher l'utilisateur dans la base de données
        $query = $dtLb->prepare("SELECT email, mot_de_passe, id_defunt FROM user_famille WHERE email = :email");
        $query->execute(['email' => $email]);
        $user = $query->fetch();
        $mail = $user['email'];

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Les mots de passe ne correspondent pas';
        } else {
            $queryUpdate = $dtLb->prepare("UPDATE user_famille SET mot_de_passe = :password WHERE email = :email");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $queryUpdate->execute([
                
                'password' => $hashedPassword,
                'email' => $email
            ]);

            if ($queryUpdate->rowCount() == 1) {
                $_SESSION['notif'] = 'Mot de passe modifié avec succès';
            } else {
                $_SESSION['error'] = 'Impossible de changer le mot de passe';
            }
        }

        header("Location: .././login-family.php");
    }
}
?>
