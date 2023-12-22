<?php
// ... (votre code précédent pour l'insertion)
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

// Requête SQL pour récupérer les informations de l'avis
$sqlSelectAvis = $dtLb->prepare("SELECT * FROM avis WHERE id_defunt = :idDefunt");
$sqlSelectAvis->execute(['idDefunt' => $idDefunt]);
$avis = $sqlSelectAvis->fetch(PDO::FETCH_ASSOC);

?>
