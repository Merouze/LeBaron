<?php
require "../../back-office/_includes/_dbCo.php";
$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérification de la soumission du formulaire
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['token']) && isset($_POST['d-obs'])) {
    try {
        // Récupération des données du formulaire
        $typeDemande = strip_tags($_POST['type-demande']);
        $firstnameDefunt = strip_tags($_POST['firstname-defunt']);
        $lastnameDefunt = strip_tags($_POST['lastname-defunt']);
        $dateBorn = strip_tags($_POST['date-born']);
        $locationBorn = strip_tags($_POST['location-born']);
        $cpBorn = strip_tags($_POST['cp-born']);
        $dateDeath = strip_tags($_POST['date-death']);
        $locationDeath = strip_tags($_POST['location-death']);
        $cityDeath = strip_tags($_POST['city-death']);
        $cityDeathCp = strip_tags($_POST['city-death-cp']);
        $presentationCorps = strip_tags($_POST['presentation-corps']);
        $bodyCare = strip_tags($_POST['body-care']);
        $obituaryOnline = isset($_POST['obituary-online']) ? 1 : 0;
        $obituaryPress = isset($_POST['obituary-press']) ? 1 : 0;
        $typeFuneral = strip_tags($_POST['type-funeral']);
        $cityCeremony = strip_tags($_POST['city-ceremony']);
        $typeCeremony = strip_tags($_POST['type-ceremony']);
        $typeSepulture = strip_tags($_POST['type-sepulture']);
        $message = strip_tags($_POST['message']);
        $firstname = strip_tags($_POST['firstname']);
        $lastname = strip_tags($_POST['lastname']);
        $linkDefunt = strip_tags($_POST['link-defunt']);
        $city = strip_tags($_POST['city']);
        $mail = strip_tags($_POST['mail']);
        $confirmMail = strip_tags($_POST['confirm-mail']);
        $phone = strip_tags($_POST['phone']);
        $hourContact = strip_tags($_POST['hour-contact']);

        // Requête SQL pour l'insertion des données
        $stmt = $dtLb->prepare("INSERT INTO devis_obs (type_demande, firstname_defunt, lastname_defunt, date_born, location_born, cp_born, date_death, location_death, city_death, city_death_cp, presentation_corps, body_care, obituary_online, obituary_press, type_funeral, city_ceremony, type_ceremony, type_sepulture, message, firstname, lastname, link_defunt, city, mail, confirm_mail, phone, hour_contact, accept_conditions) 
                               VALUES (:type_demande, :firstname_defunt, :lastname_defunt, :date_born, :location_born, :cp_born, :date_death, :location_death, :city_death, :city_death_cp, :presentation_corps, :body_care, :obituary_online, :obituary_press, :type_funeral, :city_ceremony, :type_ceremony, :type_sepulture, :message, :firstname, :lastname, :link_defunt, :city, :mail, :confirm_mail, :phone, :hour_contact, :accept_conditions)");

        // Liaison des paramètres
        $stmt->bindParam(':type_demande', $typeDemande);
        $stmt->bindParam(':firstname_defunt', $firstnameDefunt);
        $stmt->bindParam(':lastname_defunt', $lastnameDefunt);
        $stmt->bindParam(':date_born', $dateBorn);
        $stmt->bindParam(':location_born', $locationBorn);
        $stmt->bindParam(':cp_born', $cpBorn);
        $stmt->bindParam(':date_death', $dateDeath);
        $stmt->bindParam(':location_death', $locationDeath);
        $stmt->bindParam(':city_death', $cityDeath);
        $stmt->bindParam(':city_death_cp', $cityDeathCp);
        $stmt->bindParam(':presentation_corps', $presentationCorps);
        $stmt->bindParam(':body_care', $bodyCare);
        $stmt->bindParam(':obituary_online', $obituaryOnline, PDO::PARAM_INT);
        $stmt->bindParam(':obituary_press', $obituaryPress, PDO::PARAM_INT);        
        $stmt->bindParam(':type_funeral', $typeFuneral);
        $stmt->bindParam(':city_ceremony', $cityCeremony);
        $stmt->bindParam(':type_ceremony', $typeCeremony);
        $stmt->bindParam(':type_sepulture', $typeSepulture);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':link_defunt', $linkDefunt);
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
        $_SESSION['error'] = "Erreur : " . $e->getMessage();
        header("Location: /LeBaron/index.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Le formulaire n'a pas été soumis correctement.";
    header("Location: /LeBaron/index.php");
    exit();
}
