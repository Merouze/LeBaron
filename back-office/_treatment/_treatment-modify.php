<?php
// var_dump($_POST);
require "../../back-office/_includes/_dbCo.php";

$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
$_SESSION['myToken'] = md5(uniqid(mt_rand(), true));

try {
    var_dump($_POST);

    // Récupérer l'ID du défunt
    $idDefunt = isset($_POST['idDefunt']) ? intval($_POST['idDefunt']) : null;

    // Vérifier que l'ID du défunt est présent et est une valeur numérique
    if (!$idDefunt || !is_numeric($idDefunt)) {
        throw new Exception("ID du défunt manquant ou invalide.");
    }

    // Début de la transaction
    $dtLb->beginTransaction();

    // Récupérer les données du formulaire
    
    $idDefunt = $_POST['idDefunt'];
    $newName = strip_tags($_POST['new-name']);
    $newMainName = strip_tags($_POST['new-main-name']);
    $newMainLink = $_POST['new-main-link'];
    $newFamilyNames = $_POST['new-family-name'];
    $newFamilyLinks = $_POST['new-family-link'];
    // $FamilyNames = $_POST['family-name[]'];
    // $FamilyLinks = $_POST['family-link[]'];
    $newDeathDate = $_POST['new-death-date'];
    $newAgeDeath = strip_tags($_POST['new-age-death']);
    $newCeremonyDate = $_POST['new-ceremony-date'];
    $newLocationCeremony = strip_tags($_POST['new-location_ceremony']);
    $newHourCeremony = $_POST['new-hour_ceremony'];
    $newDetails = strip_tags($_POST['new-details']);
    
   

    // Requête SQL pour mettre à jour le défunt
    $sqlDefunt = $dtLb->prepare("UPDATE defunt SET nom_prenom_defunt = :newName, date_deces = :newDeathDate, age = :newAgeDeath WHERE id_defunt = :idDefunt");
    $sqlDefunt->execute([
        'newName' => $newName,
        'newDeathDate' => $newDeathDate,
        'newAgeDeath' => $newAgeDeath,
        'idDefunt' => $idDefunt,
    ]);

    // Requête SQL pour mettre à jour le proche principal
    $sqlProchePrincipal = $dtLb->prepare("UPDATE main_family SET main_proche = :newMainName, main_link = :newMainLink WHERE id_defunt = :idDefunt");
    $sqlProchePrincipal->execute([
        'newMainName' => $newMainName,
        'newMainLink' => $newMainLink,
        'idDefunt' => $idDefunt,
    ]);

    // // Supprimer les membres de la famille existants
    // $sqlDeleteFamilyMembers = $dtLb->prepare("DELETE FROM proche WHERE id_defunt = :idDefunt");
    // $sqlDeleteFamilyMembers->execute(['idDefunt' => $idDefunt]);

   // Supprimer les membres de la famille existants
$sqlDeleteFamilyMembers = $dtLb->prepare("DELETE FROM proche WHERE id_defunt = :idDefunt");
$sqlDeleteFamilyMembers->execute(['idDefunt' => $idDefunt]);

// Réinsérer les membres de la famille mis à jour
foreach ($newFamilyNames as $index => $newFamilyName) {
    $newFamilyLinkValue = $newFamilyLinks[$index];

    $sqlFamilyMember = $dtLb->prepare("INSERT INTO proche (nom_prenom_proche, lien_familial, id_defunt) VALUES (:newFamilyName, :newFamilyLink, :idDefunt)");
    $sqlFamilyMember->execute([
        'newFamilyName' => $newFamilyName,
        'newFamilyLink' => $newFamilyLinkValue,
        'idDefunt' => $idDefunt,
    ]);


}
// Ajouter les nouveaux membres de la famille
foreach ($_POST['family-name'] as $index => $FamilyName) {
    $FamilyLinkValue = $_POST['family-link'][$index];

    $sqlFamilyMember = $dtLb->prepare("INSERT INTO proche (nom_prenom_proche, lien_familial, id_defunt) VALUES (:FamilyName, :FamilyLink, :idDefunt)");
    $sqlFamilyMember->execute([
        'FamilyName' => $FamilyName,
        'FamilyLink' => $FamilyLinkValue,
        'idDefunt' => $idDefunt,
    ]);
}


    // Requête SQL pour mettre à jour la cérémonie
    $sqlCeremonie = $dtLb->prepare("UPDATE ceremonie SET date_ceremonie = :newCeremonyDate, heure_ceremonie = :newHourCeremony, lieu_ceremonie = :newLocationCeremony WHERE id_defunt = :idDefunt");
    $sqlCeremonie->execute([
        'newCeremonyDate' => $newCeremonyDate,
        'newHourCeremony' => $newHourCeremony,
        'newLocationCeremony' => $newLocationCeremony,
        'idDefunt' => $idDefunt,
    ]);

    // Requête SQL pour mettre à jour l'avis
    $sqlAvis = $dtLb->prepare("UPDATE avis SET avis_contenu = :newDetails WHERE id_defunt = :idDefunt");
    $sqlAvis->execute([
        'newDetails' => $newDetails,
        'idDefunt' => $idDefunt,
    ]);


    // Commit de la transaction
    $dtLb->commit();
    
    // Notification de succès
    $_SESSION['notif'] = array('type' => 'success', 'message' => 'Les données ont été mises à jour avec succès.');

    // Rediriger l'utilisateur après la mise à jour
    header('Location: /LeBaron/back-office/list-avis.php');
    exit();
} catch (Exception $e) {
    // Gérer l'erreur (vous pouvez logguer l'erreur, afficher un message à l'utilisateur, etc.)
    $_SESSION['notif'] = array('type' => 'error', 'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage());
    // Rediriger l'utilisateur avec une notification d'erreur
    header('Location: /LeBaron/back-office/list-avis.php');
    exit();
}
?>