<?php
require "../../back-office/_includes/_dbCo.php";
$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
$_SESSION['myToken'] = md5(uniqid(mt_rand(), true));

if (isset($_POST['update'])) {
    // Récupérer les données du formulaire
    $newName = strip_tags($_POST['new-name']);
    $newMainName = strip_tags($_POST['new-main-name']);
    $newMainLink = $_POST['new-main-link'];
    $newFamilyNames = $_POST['new-family-name'];
    $newFamilyLinks = $_POST['new-family-link'];
    $newDeathDate = $_POST['new-death-date'];
    $newAgeDeath = strip_tags($_POST['new-age-death']);
    $newCeremonyDate = $_POST['new-ceremony-date'];
    $newLocationCeremony = strip_tags($_POST['new-location_ceremony']);
    $newHourCeremony = $_POST['new-hour_ceremony'];
    $newDetails = strip_tags($_POST['new-details']);

    // Requête SQL pour insérer le défunt
    $sqlDefunt = $dtLb->prepare("INSERT INTO defunt (nom_prenom_defunt, date_deces, age) VALUES (:newName, :newDeathDate, :newAgeDeath)");
    $sqlDefunt->execute([
        'newName' => $newName,
        'newDeathDate' => $newDeathDate,
        'newAgeDeath' => $newAgeDeath,
    ]);

    $idDefunt = $dtLb->lastInsertId();

    // Requête SQL pour insérer le proche principal
    $sqlProchePrincipal = $dtLb->prepare("INSERT INTO main_family (main_proche, main_link, id_defunt) VALUES (:newMainName, :newMainLink, :idDefunt)");
    $sqlProchePrincipal->execute([
        'newMainName' => $newMainName,
        'newMainLink' => $newMainLink,
        'idDefunt' => $idDefunt,
    ]);

    // Requête SQL pour insérer les membres de la famille
    foreach ($newFamilyNames as $index => $newFamilyName) {
        $newFamilyLinkValue = $newFamilyLinks[$index];
        $sqlFamilyMember = $dtLb->prepare("INSERT INTO proche (nom_prenom_proche, lien_familial, id_defunt) VALUES (:newFamilyName, :newFamilyLink, :idDefunt)");
        $sqlFamilyMember->execute([
            'newFamilyName' => $newFamilyName,
            'newFamilyLink' => $newFamilyLinkValue,
            'idDefunt' => $idDefunt,
        ]);
    }

    // Requête SQL pour insérer la cérémonie
    $sqlCeremonie = $dtLb->prepare("INSERT INTO ceremonie (date_ceremonie, heure_ceremonie, lieu_ceremonie, id_defunt) VALUES (:newCeremonyDate, :newHourCeremony, :newLocationCeremony, :idDefunt)");
    $sqlCeremonie->execute([
        'newCeremonyDate' => $newCeremonyDate,
        'newHourCeremony' => $newHourCeremony,
        'newLocationCeremony' => $newLocationCeremony,
        'idDefunt' => $idDefunt,
    ]);

    // Requête SQL pour insérer l'avis
    $sqlAvis = $dtLb->prepare("INSERT INTO avis (avis_contenu, date_publication, id_defunt) VALUES (:newDetails, NOW(), :idDefunt)");
    $sqlAvis->execute([
        'newDetails' => $newDetails,
        'idDefunt' => $idDefunt,
    ]);

    // Rediriger l'utilisateur après l'insertion
    header('Location: .././admin.php');
    exit();
}
?>
