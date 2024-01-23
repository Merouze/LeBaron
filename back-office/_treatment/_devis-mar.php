<?php
require "../../back-office/_includes/_dbCo.php";
$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
use \Mailjet\Resources;


session_start();

if (isset($_POST['firstname']) && isset($_POST['mail'])) {
    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);
    
    $firstname = "Prénom : " . $_POST['firstname'];
    $lastname = "Nom : " . $_POST['lastname'];
    $email = $_POST['mail'];
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
                'Subject' => "Nouveau Devis Marbrerie.",
                'TextPart' => "Un nouveau devis venant de Devis Marbrerie.",
                'HTMLPart' => "<h1>Nouveau Devis Marbrerie</h1><p>$firstname</p><p>$lastname</p><p>$message</p><p>$email</p>",
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['token']) && isset($_POST['d-mar'])) {
    try {
        // Récupération des données du formulaire
        $typeWorks = strip_tags($_POST['type-works']);
        $typeMonument = strip_tags($_POST['type-monument']);
        $typeEntretien = strip_tags($_POST['type-entretien']);
        $flowering = strip_tags($_POST['flowering']);
        $messageMarble = strip_tags($_POST['message-marble']);
        $locationFall = strip_tags($_POST['location-fall']);
        $cimetaryName = strip_tags($_POST['cimetary-name']);
        $locationCimetary = strip_tags($_POST['location-cimetary']);
        $firstname = strip_tags($_POST['firstname']);
        $lastname = strip_tags($_POST['lastname']);
        $city = strip_tags($_POST['city']);
        $mail = strip_tags($_POST['mail']);
        $confirmMail = strip_tags($_POST['confirm-mail']);
        $phone = strip_tags($_POST['phone']);
        $hourContact = strip_tags($_POST['hour-contact']);

        // Requête SQL pour l'insertion des données
        $stmt = $dtLb->prepare("INSERT INTO devis_mar (type_works, type_monument, type_entretien, flowering, message_marble, location_fall, cimetary_name, location_cimetary, firstname, lastname, city, mail, confirm_mail, phone, hour_contact, accept_conditions) 
                               VALUES (:type_works, :type_monument, :type_entretien, :flowering, :message_marble, :location_fall, :cimetary_name, :location_cimetary, :firstname, :lastname, :city, :mail, :confirm_mail, :phone, :hour_contact, :accept_conditions)");

        // Liaison des paramètres
        $stmt->bindParam(':type_works', $typeWorks);
        $stmt->bindParam(':type_monument', $typeMonument);
        $stmt->bindParam(':type_entretien', $typeEntretien);
        $stmt->bindParam(':flowering', $flowering);
        $stmt->bindParam(':message_marble', $messageMarble);
        $stmt->bindParam(':location_fall', $locationFall);
        $stmt->bindParam(':cimetary_name', $cimetaryName);
        $stmt->bindParam(':location_cimetary', $locationCimetary);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':confirm_mail', $confirmMail);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':hour_contact', $hourContact);
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
