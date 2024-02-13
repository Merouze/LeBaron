<?php
require "../../back-office/_includes/_dbCo.php";
session_start();

use \Mailjet\Resources;

// var_dump($_POST);
// exit;

//****************************** Treatment udpdate

if (isset($_POST['submitTraitePrev'])) {
    $idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;

    //   Requête SQL pour mettre à jour le devis
    $sqlEstimate = $dtLb->prepare("UPDATE devis_prevoyance SET traite = 1 WHERE id_estimate = :id_estimate");
    $sqlEstimate->execute(['id_estimate' => $idEstimate]);
    
    if ($sqlEstimate->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis classé avec succès'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors du traitement du devis'];
    }


    //   Redirection avec un code de statut approprié
    header('Location: /LeBaron/back-office/list-devis-prev.php');
    exit;

}

if (isset($_POST['submitTraiteObs'])) {
    $idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;

    //   Requête SQL pour mettre à jour le devis
    $sqlEstimate = $dtLb->prepare("UPDATE devis_obs SET traite = 1 WHERE id_estimate = :id_estimate");
    $sqlEstimate->execute(['id_estimate' => $idEstimate]);
    
    if ($sqlEstimate->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis classé avec succès'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors du traitement du devis'];
    }


    //   Redirection avec un code de statut approprié
    header('Location: /LeBaron/back-office/list-devis-obs.php');
    exit;

}

if (isset($_POST['submitTraiteMar'])) {
    $idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;

    //   Requête SQL pour mettre à jour le devis
    $sqlEstimate = $dtLb->prepare("UPDATE devis_mar SET traite = 1 WHERE id_estimate = :id_estimate");
    $sqlEstimate->execute(['id_estimate' => $idEstimate]);
    
    if ($sqlEstimate->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis classé avec succès'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors du traitement du devis'];
    }


    //   Redirection avec un code de statut approprié
    header('Location: /LeBaron/back-office/list-devis-mar.php');
    exit;

}

//****************************** Treatment udpdate and send pdf for estimate prev

// Vérifiez si le formulaire a été soumis
if (isset($_POST['submitUpdatePrev'])) {
    $idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;
    if (($_POST['traited']) == 1) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis déja envoyé ultérieurement.'];
        header('Location: /LeBaron/back-office/list-devis-prev.php');
        exit;
    }


    $emailDestinataire = strip_tags($_POST["email"]);
    $nameDestinataire = strip_tags($_POST["name"]);
    // Obtenez le contenu du PDF depuis la session
    $pdfContentPrev = $_SESSION['pdf_content_' . $idEstimate];
    // var_dump($_POST);
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
    // var_dump($_POST);
    // exit;
    $idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;
    if (($_POST['traite']) == 1) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis déja envoyé ultérieurement.'];
        header('Location: /LeBaron/back-office/list-devis-mar.php');
        exit;
    }


    $emailDestinataire = strip_tags($_POST["email"]);
    $nameDestinataire = strip_tags($_POST["name"]);
    // Obtenez le contenu du PDF depuis la session
    $pdfContent = $_SESSION['pdf_content_' . $idEstimate];

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
                        'Base64Content' => base64_encode($pdfContent)
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
    $sqlEstimate = $dtLb->prepare("UPDATE devis_mar SET traite = 1 WHERE id_estimate = :id_estimate");
    $sqlEstimate->execute(['id_estimate' => $idEstimate]);

    if ($sqlEstimate->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis classé avec succès'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors du traitement du devis'];
    }

    //   Redirection avec un code de statut approprié
    header('Location: /LeBaron/back-office/list-devis-mar.php', true, 303);
    exit;
}
//****************************** Treatment udpdate and send pdf for estimate obs

// Vérifiez si le formulaire a été soumis
if (isset($_POST['submitUpdateObs'])) {
    $idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;
    if (($_POST['traited']) == 1) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis déja envoyé ultérieurement.'];
        header('Location: /LeBaron/back-office/list-devis-obs.php');
        exit;
    }

    // var_dump($_POST);
    // exit;

    $emailDestinataire = strip_tags($_POST["mail"]);
    $nameDestinataire = strip_tags($_POST["name"]);
    // Obtenez le contenu du PDF depuis la session
    $pdfContent = $_SESSION['pdf_content_' . $idEstimate];
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
                        'Filename' => 'devis-obsèques.pdf',
                        'Base64Content' => base64_encode($pdfContent)

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
    $sqlEstimate = $dtLb->prepare("UPDATE devis_obs SET traite = 1 WHERE id_estimate = :id_estimate");
    $sqlEstimate->execute(['id_estimate' => $idEstimate]);

    if ($sqlEstimate->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis classé avec succès'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors du traitement du devis'];
    }


    //   Redirection avec un code de statut approprié
    header('Location: /LeBaron/back-office/list-devis-obs.php', true, 303);
    exit;
}
