<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- section header title -->
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>

<?php
use \Mailjet\Resources;

if (isset($_POST['forget'])) {
    $mail = $_POST['email'];
    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);
    
    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "aurelienmerouze@gmail.com",
                    'Name' => "P.F Le Baron"

                ],
                'To' => [
                    [
                        'Email' => $mail
                    ]
                ],
                'Subject' => "Nouveau message.",
                'TextPart' => "Lien de réinitialisation du mot de passe.",
                'HTMLPart' => "<h1>Nouveau message</h1><p><a href='http://localhost/LeBaron/forget-password.php'>Lien de réinitialisation du mot de passe</a></p>",
            ]
        ]
    ];

    $response = $mj->post(Resources::$Email, ['body' => $body]);

    if ($response->success()) {
      // La requête Mailjet a réussi, vous pouvez définir une notification de succès
      $_SESSION['notif'] = "L'e-mail a été envoyé avec succès!";
  } else {
      // Gestion des erreurs
      $_SESSION['error'] = "Erreur lors de l'envoi de l'e-mail : " . $response->getReasonPhrase();
  }

    // Rediriger l'utilisateur
    header('Location: /LeBaron/index.php');
    exit;
}
?>
<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si la clé 'admin' existe dans $_POST
    if (isset($_POST['email'])) {
        var_dump($_POST);
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
        // Rechercher l'utilisateur dans la base de données
        $query = $dtLb->prepare("SELECT email, mot_de_passe, id_defunt FROM user_famille WHERE email = :email");
        $query->execute(['email' => $email]);      
        $user = $query->fetch();
        // Vérifier si la requête a renvoyé des résultats avant d'accéder à $result['password']
        if ($query->rowCount() == 1 && password_verify($password, $user['mot_de_passe'])) {        
            $_SESSION["id_defunt"] = $user['id_defunt'];   
                // Utilisateur authentifié, rediriger vers l'espace administrateur
                $_SESSION["loggedin"] = true;
                // Ajouter un message de bienvenue à la session
                $_SESSION["notif"] = 'Vous êtes connecté';
                $_SESSION["welcome_mess"] = "<p class='mt30 text-align'><span class='mt30 text-align blue bold'>Bienvenue,</span> vous êtes bien connecté.</p>";

                $welcomeMess = urlencode($_SESSION["welcome_mess"]);

                header("location: ./index-family.php?welcome_mess=$welcomeMess");

                // header("location: ./index-family.php");
            } else {
                // Identifiants invalides, afficher un message d'erreur
                $_SESSION['error'] = 'Identifiants invalides';
                // header("location: ./login.php");
            };
        }
    }
?>
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Connexion à l'espace&nbsp;<span class="blue">Famille</span></h1>
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
        <label class="label" for="email">Adresse e-mail:</label>
        <input type="email" id="email" name="email" required>
        <label class="label" for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" >
        <button type="submit">Se connecter</button>
        <br>
        <button name="forget" type="submit-forget">Réinitialiser le mot de passe</button>
    </form>
    <!-- <p class="text-align"><a class="grey" href="_treatment/_send-link-forget-password.php?email=<?= urlencode($email) ?>">Mot de passe oublié</a></p> -->

    <!-- <p class="text-align"><a class="grey" href="_treatment/_send-link-forget-password.php?email=' . $email . '">Mot de passe oublié</a></p> -->
</section>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>

<script src="asset/Js/script.js"></script>
<script src="asset/Js/fonctions.js"></script>
</body>
</html>