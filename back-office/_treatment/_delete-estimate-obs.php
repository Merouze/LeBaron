<?php
require "../../back-office/_includes/_dbCo.php";
$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
$_SESSION['myToken'];

// Assurez-vous que l'ID de l'estimation est passé dans l'URL
if (isset($_GET['idEstimate'])) {
    require "../../back-office/_includes/_dbCo.php";
    $dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer l'ID de l'estimation depuis l'URL
    $idEstimate = $_GET['idEstimate'];

    try {
        // Requête SQL pour supprimer l'estimation
        $stmt = $dtLb->prepare("DELETE FROM devis_obs WHERE id_estimate = :id_estimate");

        // Liaison du paramètre
        $stmt->bindParam(':id_estimate', $idEstimate);

        // Exécution de la requête
        $stmt->execute();
        // Définir la notification de suppression avec succès
        $_SESSION['notif'] = [
            'type' => 'success',
            'message' => 'Demande de devis supprimées avec succès.'
        ];
        // Redirection après la suppression
        header("Location: .././list-devis-obs.php");
        exit();
    } catch (PDOException $e) {
        // Gérer les erreurs de la suppression
        echo "Erreur : " . $e->getMessage();
        exit();
    }
} else {
    // Redirection vers une page appropriée après la suppression
    header("Location: .././list-devis-obs.php");
    exit();
}
