<?php
require "../../back-office/_includes/_dbCo.php";
$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
$_SESSION['myToken'] = md5(uniqid(mt_rand(), true));

if (isset($_POST['send'])) {
    try {
        // Récupérer les données du formulaire
        $name = strip_tags($_POST['name']);
        $mainName = strip_tags($_POST['main-name']);
        $mainLink = strip_tags($_POST['main-link']);
        $familyNames = $_POST['family-name'];
        $familyLinks = $_POST['family-link'];
        $deathDate = strip_tags($_POST['death-date']);
        $ageDeath = strip_tags($_POST['age-death']);
        $ceremonyDate = strip_tags($_POST['ceremony-date']);
        $locationCeremony = strip_tags($_POST['location_ceremony']);
        $hourCeremony = strip_tags($_POST['hour_ceremony']);
        $details = strip_tags($_POST['details']);

        // Requête SQL pour insérer le défunt
        $sqlDefunt = $dtLb->prepare("INSERT INTO defunt (nom_prenom_defunt, date_deces, age) VALUES (:name, :deathDate, :ageDeath)");
        $sqlDefunt->execute([
            'name' => $name,
            'deathDate' => $deathDate,
            'ageDeath' => $ageDeath,
        ]);

        $idDefunt = $dtLb->lastInsertId();

        // Requête SQL pour insérer le proche principal
        $sqlProchePrincipal = $dtLb->prepare("INSERT INTO main_family (main_proche, main_link, id_defunt) VALUES (:mainName, :mainLink, :idDefunt)");
        $sqlProchePrincipal->execute([
            'mainName' => $mainName,
            'mainLink' => $mainLink,
            'idDefunt' => $idDefunt,
        ]);

        // Requête SQL pour insérer les membres de la famille
        foreach ($familyNames as $index => $familyName) {
            $familyLink = $familyLinks[$index];
            $sqlFamilyMember = $dtLb->prepare("INSERT INTO proche (nom_prenom_proche, lien_familial, id_defunt) VALUES (:familyName, :familyLink, :idDefunt)");
            $sqlFamilyMember->execute([
                'familyName' => $familyName,
                'familyLink' => $familyLink,
                'idDefunt' => $idDefunt,
            ]);
        }

        // Requête SQL pour insérer la cérémonie
        $sqlCeremonie = $dtLb->prepare("INSERT INTO ceremonie (date_ceremonie, heure_ceremonie, lieu_ceremonie, id_defunt) VALUES (:ceremonyDate, :hourCeremony, :locationCeremony, :idDefunt)");
        $sqlCeremonie->execute([
            'ceremonyDate' => $ceremonyDate,
            'hourCeremony' => $hourCeremony,
            'locationCeremony' => $locationCeremony,
            'idDefunt' => $idDefunt,
        ]);

        // Requête SQL pour insérer l'avis
        $sqlAvis = $dtLb->prepare("INSERT INTO avis (avis_contenu, date_publication, id_defunt) VALUES (:details, NOW(), :idDefunt)");
        $sqlAvis->execute([
            'details' => $details,
            'idDefunt' => $idDefunt,
        ]);

        // Réussite de l'ajout
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Avis de décès ajouté avec succès'];

        // Redirection après l'insertion
        header('Location: /LeBaron/back-office/list-avis.php');
        exit();
    } catch (Exception $e) {
        // Échec de l'ajout
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Une erreur est survenue lors de l\'ajout de l\'avis : ' . $e->getMessage()];
    }
}

// Redirection en cas d'erreur
header('Location: /LeBaron/back-office/list-avis.php');
exit();
?>
