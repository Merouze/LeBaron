<?php

require "../../back-office/_includes/_dbCo.php";
use \Mailjet\Resources;

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../back-office/_includes/');
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
    echo "Erreur lors du chargement du fichier .env : " . $e->getMessage();
    exit;
}

if (isset($_POST['firstname']) && isset($_POST['email'])) {
    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);
    
    $firstname = "Prénom : " . $_POST['firstname'];
    $lastname = "Nom : " . $_POST['lastname'];
    $email = $_POST['email'];
    $message = "Message : " . $_POST['message'];

    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "p.lim61@hotmail.fr",
                ],
                'To' => [
                    [
                        'Email' => "p.lim61@hotmail.fr",
                        'Name' => "Aurélien"
                    ]
                ],
                'Subject' => "Nouveau message.",
                'TextPart' => "Un nouveau message venant du formulaire de contact.",
                'HTMLPart' => "<h1>Nouveau message</h1><p>$firstname</p><p>$lastname</p><p>$message</p><p>$email</p>",
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
