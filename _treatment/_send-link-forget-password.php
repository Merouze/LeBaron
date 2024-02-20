<?php
require ".././back-office/_includes/_dbCo.php";
session_start();

use \Mailjet\Resources;
// var_dump($_POST);
// exit;
?>
<?php

if (isset($_POST['email'])) {
    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);

    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "aurelienmerouze@gmail.com"
                ],
                'To' => [
                    [
                        'Email' => "aurelienmerouze@gmail.com",
                        'Name' => "Aurélien"
                    ]
                ],
                'Subject' => "Nouveau message.",
                'TextPart' => "Lien de réinitialisation.",
                'HTMLPart' => "<h1>Nouveau message</h1><p>Voici le lien pour réinitialiser le mot de passe.</p><p><a href='_treatment/_send-link-forget-password.php'>Cliquer ici.</a></p>",
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
