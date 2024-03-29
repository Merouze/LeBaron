<?php
require "../../back-office/_includes/_dbCo.php";
$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer l'ID de l'estimation depuis l'URL
$idEstimate = $_GET['idEstimate'];
session_start();

// Assurez-vous que l'ID de l'estimation est passé dans l'URL
if (isset($_GET['idEstimate'])) {
    try {
        // Récupérer l'id_estimate_obs depuis la table estimate_obs
        $sqlGetId = $dtLb->prepare("SELECT id_estimate_obs FROM estimate_obs WHERE id_estimate = :id_estimate");
        $sqlGetId->bindParam(':id_estimate', $idEstimate);
        $sqlGetId->execute();
        $getId = $sqlGetId->fetch(PDO::FETCH_ASSOC);

        // Vérifier si une estimation avec cet ID existe
        if (!$getId) {
            // Redirection vers une page appropriée si l'estimation n'est pas trouvée
            $_SESSION['notif'] = [
                'type' => 'error',
                'message' => 'Estimation non trouvée.'
            ];
            header("Location: .././list-devis-obs.php");
            exit();
        }

        // Récupérer l'id_estimate_obs
        $id_estimate_obs = $getId['id_estimate_obs'];

        // Supprimer les enregistrements des trois tables
        $stmt = $dtLb->prepare("DELETE FROM devis_obs WHERE id_estimate = :id_estimate");
        $stmt->bindParam(':id_estimate', $idEstimate);
        $stmt->execute();

        $stmt = $dtLb->prepare("DELETE FROM estimate_obs WHERE id_estimate_obs = :id_estimate_obs");
        $stmt->bindParam(':id_estimate_obs', $id_estimate_obs);
        $stmt->execute();

        $dltRe = $dtLb->prepare("DELETE FROM raw_estimate WHERE id_estimate_obs = :id_estimate_obs");
        $dltRe->bindParam(':id_estimate_obs', $id_estimate_obs);
        $dltRe->execute();

        // Définir la notification de suppression avec succès
        $_SESSION['notif'] = [
            'type' => 'success',
            'message' => 'Estimation et demande de devis supprimées avec succès.'
        ];

        // Redirection après la suppression
        header("Location: .././list-devis-obs.php");
        exit();
    } catch (PDOException $e) {
        // En cas d'erreur lors de la suppression
        $_SESSION['notif'] = [
            'type' => 'error',
            'message' => 'Erreur lors de la suppression de l\'estimation : ' . $e->getMessage()
        ];
        header("Location: .././list-devis-obs.php");
        exit();
    }
} else {
    // Redirection vers une page appropriée si l'ID n'est pas défini
    header("Location: .././list-devis-obs.php");
    exit();
}
?>
