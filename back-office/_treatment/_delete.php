<?php
require "../../back-office/_includes/_dbCo.php";
$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
$_SESSION['myToken'] = md5(uniqid(mt_rand(), true));



if (isset($_GET['idDefunt'])) {
    $idDefunt = $_GET['idDefunt'];
    // var_dump($_GET['idDefunt']);
    // exit;
    // Supprimer les informations du défunt
    $sqlDeleteDefunt = $dtLb->prepare("DELETE FROM defunt WHERE id_defunt = :idDefunt");
    $sqlDeleteDefunt->execute(['idDefunt' => $idDefunt]);
    // Supprimer l'avis de décès
    $sqlDeleteAvis = $dtLb->prepare("DELETE FROM avis WHERE id_defunt = :idDefunt");
    $sqlDeleteAvis->execute(['idDefunt' => $idDefunt]);

    // Supprimer les informations du proche principal
    $sqlDeleteProchePrincipal = $dtLb->prepare("DELETE FROM main_family WHERE id_defunt = :idDefunt");
    $sqlDeleteProchePrincipal->execute(['idDefunt' => $idDefunt]);

    // Supprimer les membres de la famille
    $sqlDeleteFamille = $dtLb->prepare("DELETE FROM proche WHERE id_defunt = :idDefunt");
    $sqlDeleteFamille->execute(['idDefunt' => $idDefunt]);

    // Supprimer les informations de la cérémonie
    $sqlDeleteCeremonie = $dtLb->prepare("DELETE FROM ceremonie WHERE id_defunt = :idDefunt");
    $sqlDeleteCeremonie->execute(['idDefunt' => $idDefunt]);


    // Redirection vers une page appropriée après la suppression
    header("Location: .././list-avis.php");
    exit();
} else {
    // Gérer le cas où l'ID du défunt n'est pas défini
    echo "ID du défunt non spécifié.";
}
