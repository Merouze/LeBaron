
<?php

require "../../back-office/_includes/_dbCo.php";

use \Mailjet\Resources;

$idDefunt = isset($_POST['idDefunt']) ? $_POST['idDefunt'] : null;
$idCondolences = isset($_POST['condolence_id']) ? $_POST['condolence_id'] : null;

// Update sent-thanks
try {
    // Mettre à jour la colonne sent_thanks dans la base de données
    $sqlUpdateCondolence = $dtLb->prepare("UPDATE condolences SET sent_thanks = 1 WHERE id_defunt = :idDefunt AND id_condolence = :idCondolences");
    $sqlUpdateCondolence->execute(['idDefunt' => $idDefunt, 'idCondolences' => $idCondolences]);
    
} catch (PDOException $e) {
    // Gérer les erreurs de mise à jour
    $_SESSION['error'] = "Erreur lors de la mise à jour de la base de données : " . $e->getMessage();
    // Rediriger l'utilisateur vers une page d'erreur
    header('Location: /LeBaron/error-page.php');
}

// Sent-thanks

if (isset($_POST['message']) && isset($_POST['email'])) {
    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);
    $name = "Nom : " . strip_tags($_POST['name']);
    $email = strip_tags($_POST['email']);
    $message = "Message : " . strip_tags($_POST['message']);
    // var_dump($email);
    // exit;
    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "aurelienmerouze@gmail.com",
                    'Name' => "Pompe funèbres Le Baron"

                ],
                'To' => [
                    [
                        'Email' => $email,
                        'Name' => $name
                    ],
                ],
                'Subject' => "Nouveau message.",
                'TextPart' => "Remerciements.",
                'HTMLPart' => "<h1>Nouveau message</h1><p>$name</p><p>$message</p>",
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
    
    header('Location: /LeBaron/condolences-family.php?idDefunt=' . $idDefunt);
    exit;
}

?>
