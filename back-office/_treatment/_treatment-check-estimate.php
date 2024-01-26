<?php
require "../../back-office/_includes/_dbCo.php";
session_start();
use \Mailjet\Resources;
$idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;

//****************************** Treatment udpdate and send pdf for estimate prev

// Vérifiez si le formulaire a été soumis
if (isset($_POST['submitUpdatePrev'])) {
    $emailDestinataire = strip_tags($_POST["email"]);
    $nameDestinataire = strip_tags($_POST["name"]);
    // Obtenez le contenu du PDF depuis la session
    $pdfContentPrev = $_SESSION['pdf_content_' . $idEstimate];
    // var_dump($pdfPath);
    // exit;
    // Envoie le PDF par e-mail avec Mailjet
    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);

    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => 'aurelienmerouze@gmail.com',
                    'Name' => 'P.F. Le Baron.'
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
                        //  'Base64Content' => base64_encode(file_get_contents($pdfPath))
                        'Base64Content' => base64_encode($pdfContentPrev)

                    ]
                ]
            ]
        ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);

    //   Gestion des erreurs lors de l'envoi d'e-mails
    if ($response->success()) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Email envoyé avec succès!'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'email: ' . $response->getStatus()];
    }

    //   Requête SQL pour mettre à jour le devis
    $sqlEstimate = $dtLb->prepare("UPDATE devis_prevoyance SET traite = 1 WHERE id_estimate = :id_estimate");
    $sqlEstimate->execute(['id_estimate' => $idEstimate]);

    //   Gestion des erreurs SQL
    if ($sqlEstimate->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis classé avec succès'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors du traitement du devis'];
    }

    //   Redirection avec un code de statut approprié
    header('Location: /LeBaron/back-office/list-devis-prev.php', true, 303);
    exit;
}
//****************************** Treatment udpdate and send pdf for marbrerie

// Vérifiez si le formulaire a été soumis
if (isset($_POST['submitUpdateMar'])) {
    $emailDestinataire = strip_tags($_POST["email"]);
    $nameDestinataire = strip_tags($_POST["name"]);
    // Obtenez le contenu du PDF depuis la session
    $pdfContentMar = $_SESSION['pdf_content_' . $idEstimate];
    // var_dump($pdfPath);
    // exit;
    // Envoie le PDF par e-mail avec Mailjet
    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);

    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => 'aurelienmerouze@gmail.com',
                    'Name' => 'P.F. Le Baron.'
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
                        'Filename' => 'devis-marbrerie.pdf',
                        'Base64Content' => base64_encode($pdfContentMar)

                    ]
                ]
            ]
        ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);

    //   Gestion des erreurs lors de l'envoi d'e-mails
    if ($response->success()) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Email envoyé avec succès!'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'email: ' . $response->getStatus()];
    }

    //   Requête SQL pour mettre à jour le devis
    $sqlEstimate = $dtLb->prepare("UPDATE devis_prevoyance SET traite = 1 WHERE id_estimate = :id_estimate");
    $sqlEstimate->execute(['id_estimate' => $idEstimate]);

    //   Gestion des erreurs SQL
    if ($sqlEstimate->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis classé avec succès'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors du traitement du devis'];
    }

    //   Redirection avec un code de statut approprié
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
//****************************** Treatment udpdate and send pdf for marbrerie

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

//****************************** */ Treatment udpdate and send pdf for obs

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
