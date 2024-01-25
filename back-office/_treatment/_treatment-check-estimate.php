<?php
require "../../back-office/_includes/_dbCo.php";

use \Mailjet\Resources;

$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// var_dump($_POST);
// exit;
$idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;

// Vérifiez si le formulaire a été soumis
if (isset($_POST['submitUpdatePrev'])) {

    // Récupérez les données du formulaire
    $emailDestinataire = strip_tags($_POST["email"]);
    $nameDestinataire = strip_tags($_POST["name"]);

    // Définissez le chemin du PDF déjà généré et sauvegardé sur le serveur
    // $pdfPath = './devis-prevoyance.pdf';
    $pdfPath = './devis-prevoyance-' . $idEstimate . '.pdf';
// var_dump($pdfPath);
// exit;
    // Envoie le PDF par e-mail avec Mailjet
    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);

    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => 'aurelienmerouze@gmail.com',
                    'Name' => 'Aurélien'
                ],
                'To' => [
                    [
                        'Email' => $emailDestinataire,
                        'Name' => $nameDestinataire
                    ]
                ],
                'Subject' => 'Réponse à votre demande de devis',
                'TextPart' => 'pdf.',
                'HTMLPart' => 'Bonjour veuillez trouver ci-joint le pdf.',
                'Attachments' => [
                    [
                        'ContentType' => 'application/pdf',
                        'Filename' => 'devis-prevoyance.pdf',
                        'Base64Content' => base64_encode(file_get_contents($pdfPath))
                    ]
                ]
            ]
        ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);

    // Gestion des erreurs lors de l'envoi d'e-mails
    if ($response->success()) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Email envoyé avec succès!'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'email: ' . $response->getStatus()];
    }
    
    // Requête SQL pour mettre à jour le devis
    $sqlEstimate = $dtLb->prepare("UPDATE devis_prevoyance SET traite = 1 WHERE id_estimate = :id_estimate");
    $sqlEstimate->execute(['id_estimate' => $idEstimate]);
    
    // Gestion des erreurs SQL
    if ($sqlEstimate->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis classé avec succès'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors du traitement du devis'];
    }
    
    // Redirection avec un code de statut approprié
    header('Location: /LeBaron/back-office/list-devis-prev.php', true, 303);
    exit;
}



//****************************** Treatment check estimate prev

// if (isset($_POST['submitUpdatePrev'])) {
//     // Requête SQL pour mettre à jour le devis
//     $sqlEstimate = $dtLb->prepare("UPDATE devis_prevoyance SET traite = 1 WHERE id_estimate = :id_estimate");
//     $sqlEstimate->execute([
//         'id_estimate' => $idEstimate
//     ]);

//     // Vérifier si la suppression a réussi
//     if ($sqlEstimate->rowCount() > 0) {
//         $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis classé avec succès'];

//     } else {
//         $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors du traitement du devis'];
//     }
//     header('Location: /LeBaron/back-office/list-devis-prev.php');
//     exit;
// }
//****************************** Treatment check estimate marbrerie

if (isset($_POST['submitUpdateMar'])) {
    // Requête SQL pour mettre à jour le devis
    $sqlEstimate = $dtLb->prepare("UPDATE devis_mar SET traite = 1 WHERE id_estimate = :id_estimate");
    $sqlEstimate->execute([
        'id_estimate' => $idEstimate
    ]);

    // Vérifier si la suppression a réussi
    if ($sqlEstimate->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis classé avec succès'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors du traitement du devis'];
    }
    header('Location: /LeBaron/back-office/list-devis-mar.php');
    exit;
}

//****************************** */ Treatment check estimate obs

if (isset($_POST['submitUpdateObs'])) {
    // Requête SQL pour mettre à jour le devis
    $sqlEstimate = $dtLb->prepare("UPDATE devis_obs SET traite = 1 WHERE id_estimate = :id_estimate");
    $sqlEstimate->execute([
        'id_estimate' => $idEstimate
    ]);

    // Vérifier si la suppression a réussi
    if ($sqlEstimate->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis classé avec succès'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors du traitement du devis'];
    }
    header('Location: /LeBaron/back-office/list-devis-obs.php');
    exit;
}
