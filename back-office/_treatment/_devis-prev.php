<?php
require "../../back-office/_includes/_dbCo.php";
$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

use \Mailjet\Resources;

session_start();
// var_dump($_POST);
// exit;

if (isset($_POST['firstname']) && isset($_POST['mail']) && isset($_POST['token'])) {
    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);
    $token = strip_tags($_POST['token']);
    $firstname = "Prénom : " . strip_tags($_POST['firstname']);
    $lastname = "Nom : " . strip_tags($_POST['lastname']);
    $email = strip_tags($_POST['mail']);
    $message = "Message : " . strip_tags($_POST['message-pre']);

    if ($token === $_SESSION['myToken']) {

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "aurelienmerouze@gmail.com",
                    ],
                    'To' => [
                        [
                            'Email' => "aurelienmerouze@gmail.com",
                            'Name' => "Aurélien"
                        ]
                    ],
                    'Subject' => "Nouveau Devis Prévoyance.",
                    'TextPart' => "Un nouveau devis venant de Devis Prévoyance.",
                    'HTMLPart' => "<h1>Nouveau Devis Prévoyance</h1><p>$firstname</p><p>$lastname</p><p>$message</p><p>$email</p>",
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
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['token']) && isset($_POST['d-prev'])) {
        try {
            // Récupération des données du formulaire
            $typeObs = strip_tags($_POST['type-obs']);
            $timeFinance = strip_tags($_POST['time-finance']);
            $firstname = strip_tags($_POST['firstname']);
            $lastname = strip_tags($_POST['lastname']);
            $familySituation = strip_tags($_POST['family-situation']);
            $birthdate = strip_tags($_POST['birthdate']);
            $profession = strip_tags($_POST['profession']);
            $adress = strip_tags($_POST['adress']);
            $city = strip_tags($_POST['city']);
            $mail = strip_tags($_POST['mail']);
            $confirmMail = strip_tags($_POST['confirm-mail']);
            $phone = strip_tags($_POST['phone']);
            $hourContact = strip_tags($_POST['hour-contact']);
            $messagePre = strip_tags($_POST['message-pre']);
            $traite = strip_tags($_POST['traite']);
            // $dateDemande = strip_tags($_POST['date-demande']);

            // Requête SQL pour l'insertion des données
            $stmt = $dtLb->prepare("INSERT INTO devis_prevoyance (type_demande, type_contrat, prenom, nom, situation_familiale, date_naissance, profession, adress, ville, email, tel, horaire_contact, message, accept_conditions, traite) 
                               VALUES (:type_obs, :time_finance, :firstname, :lastname, :family_situation, :birthdate, :profession, :adress, :city, :mail, :phone, :hour_contact, :message_pre,  :accept_conditions, :traite)");

            // Liaison des paramètres
            $stmt->bindParam(':type_obs', $typeObs);
            $stmt->bindParam(':time_finance', $timeFinance);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':family_situation', $familySituation);
            $stmt->bindParam(':birthdate', $birthdate);
            $stmt->bindParam(':profession', $profession);
            $stmt->bindParam(':adress', $adress);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':hour_contact', $hourContact);
            $stmt->bindParam(':message_pre', $messagePre);
            $stmt->bindParam(':traite', $traite);
            $acceptConditions = isset($_POST['accept-conditions']) ? 1 : 0;
            $stmt->bindParam(':accept_conditions', $acceptConditions);


            // Exécution de la requête
            $stmt->execute();

            $_SESSION['notif'] = "Devis envoyé avec succès.";

            // Redirection après l'insertion
            header('Location: /LeBaron/index.php');
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de la soumission du formulaire. Erreur : " . $e->getMessage();
            header('Location: /LeBaron/index.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Le formulaire n'a pas été soumis correctement.";
        header('Location: /LeBaron/index.php');
        exit();
    }
}
