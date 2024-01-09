<?php
setlocale(LC_TIME, 'fr_FR.utf8'); // Définit le local en français

$idDefunt = isset($_GET['idDefunt']) ? $_GET['idDefunt'] : null;


// Requête SQL pour récupérer les informations du défunt
$sqlSelectDefunt = $dtLb->prepare("SELECT * FROM defunt WHERE id_defunt = :idDefunt");
$sqlSelectDefunt->execute(['idDefunt' => $idDefunt]);

$defunt = $sqlSelectDefunt->fetch(PDO::FETCH_ASSOC);

// Requête SQL pour récupérer les informations du proche principale

$sqlSelectProchePrincipal = $dtLb->prepare("SELECT main_proche, main_link FROM main_family WHERE id_defunt = :idDefunt");
$sqlSelectProchePrincipal->execute(['idDefunt' => $idDefunt]);
$prochePrincipale = $sqlSelectProchePrincipal->fetchAll(PDO::FETCH_ASSOC);

// Requête SQL pour récupérer les informations des proches 
$sqlSelectProche = $dtLb->prepare("SELECT nom_prenom_proche, lien_familial FROM proche WHERE id_defunt = :idDefunt");
$sqlSelectProche->execute(['idDefunt' => $idDefunt]);
$proches = $sqlSelectProche->fetchAll(PDO::FETCH_ASSOC);

// Requête SQL pour récupérer les informations de la cérémonie
$sqlSelectCeremonie = $dtLb->prepare("SELECT * FROM ceremonie WHERE id_defunt = :idDefunt");
$sqlSelectCeremonie->execute(['idDefunt' => $idDefunt]);
$ceremonie = $sqlSelectCeremonie->fetch(PDO::FETCH_ASSOC);

// Convertir la date en objet DateTime
$dateCeremonie = new DateTime($ceremonie['date_ceremonie']);

// Définir la localisation en français
$locale = 'fr_FR';
$formatter = new IntlDateFormatter($locale, IntlDateFormatter::FULL, IntlDateFormatter::NONE);
// Formater la date en français
$dateCeremonieFormattee = $formatter->format($dateCeremonie);
$ceremonie = new DateTime($ceremonie['heure_ceremonie']);
$heureCeremonieFormattee = $ceremonie->format('H:i');

// Requête SQL pour récupérer les informations de la cérémonie
$sqlSelectCeremonie = $dtLb->prepare("SELECT * FROM ceremonie WHERE id_defunt = :idDefunt");
$sqlSelectCeremonie->execute(['idDefunt' => $idDefunt]);
$ceremonie = $sqlSelectCeremonie->fetch(PDO::FETCH_ASSOC);


// Requête SQL pour récupérer les informations de l'avis
$sqlSelectAvis = $dtLb->prepare("SELECT * FROM avis WHERE id_defunt = :idDefunt");
$sqlSelectAvis->execute(['idDefunt' => $idDefunt]);
$avis = $sqlSelectAvis->fetch(PDO::FETCH_ASSOC);

?>
