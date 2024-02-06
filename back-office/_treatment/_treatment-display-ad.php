<?php
setlocale(LC_TIME, 'fr_FR.utf8'); // Définit le local en français

$idDefunt = isset($_GET['idDefunt']) ? $_GET['idDefunt'] : null;


// Définir la localisation en français
$locale = 'fr_FR';
$formatter = new IntlDateFormatter($locale, IntlDateFormatter::FULL, IntlDateFormatter::NONE);

// Requête SQL pour récupérer les informations du défunt
$sqlSelectDefunt = $dtLb->prepare("SELECT * FROM defunt WHERE id_defunt = :idDefunt");
$sqlSelectDefunt->execute(['idDefunt' => $idDefunt]);

// var_dump($_GET);
// exit;
$defunt = $sqlSelectDefunt->fetch(PDO::FETCH_ASSOC);
// Créer un objet DateTime pour la date de décès
$deathDate = new DateTime($defunt['date_deces']);
// Formater la date en français
$dateDeDecesFormattee = $formatter->format($deathDate);
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
$ceremonieData = $sqlSelectCeremonie->fetch(PDO::FETCH_ASSOC);

// Convertir la date en objet DateTime
$dateCeremonie = new DateTime($ceremonieData['date_ceremonie']);
$heureCeremonie = new DateTime($ceremonieData['heure_ceremonie']);

// Définir la localisation en français
$locale = 'fr_FR';
$formatter = new IntlDateFormatter($locale, IntlDateFormatter::FULL, IntlDateFormatter::NONE);

// Formater la date en français
$dateCeremonieFormattee = $formatter->format($dateCeremonie);
$heureCeremonieFormattee = $heureCeremonie->format('H:i');



// Requête SQL pour récupérer les informations de l'avis
$sqlSelectAvis = $dtLb->prepare("SELECT * FROM avis WHERE id_defunt = :idDefunt");
$sqlSelectAvis->execute(['idDefunt' => $idDefunt]);
$avis = $sqlSelectAvis->fetch(PDO::FETCH_ASSOC);

?>
