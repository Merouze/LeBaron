<?php
require "../../back-office/_includes/_dbCo.php";
$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// var_dump($_POST);
// exit;
$idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;

//****************************** Treatment check estimate prev

if (isset($_POST['submitUpdatePrev'])) {
    // Requête SQL pour mettre à jour le devis
    $sqlEstimate = $dtLb->prepare("UPDATE devis_prevoyance SET traite = 1 WHERE id_estimate = :id_estimate");
    $sqlEstimate->execute([
        'id_estimate' => $idEstimate
    ]);

    // Vérifier si la suppression a réussi
    if ($sqlEstimate->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis classé avec succès'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors du traitement du devis'];
    }
    header('Location: /LeBaron/back-office/list-devis-prev.php');
    exit;
}
//****************************** Treatment check estimate marbrerie

if (isset($_POST['submitUpdateMar'])) {
    // Requête SQL pour mettre à jour le devis
    $sqlEstimate = $dtLb->prepare("UPDATE devis_mar SET traite = 1 WHERE id_estimate = :id_estimate");
    $sqlEstimate->execute([
        'id_estimate' => $idEstimate
    ]);

    // Vérifier si la suppression a réussi
    if ($sqlEstimate->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis classé avec succès'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors du traitement du devis'];
    }
    header('Location: /LeBaron/back-office/list-devis-mar.php');
    exit;
}

//****************************** */ Treatment check estimate obs

if (isset($_POST['submitUpdateObs'])) {
    // Requête SQL pour mettre à jour le devis
    $sqlEstimate = $dtLb->prepare("UPDATE devis_obs SET traite = 1 WHERE id_estimate = :id_estimate");
    $sqlEstimate->execute([
        'id_estimate' => $idEstimate
    ]);

    // Vérifier si la suppression a réussi
    if ($sqlEstimate->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis classé avec succès'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors du traitement du devis'];
    }
    header('Location: /LeBaron/back-office/list-devis-obs.php');
    exit;
}

?>