<?php
require "../../back-office/_includes/_dbCo.php";
$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();

// Assurez-vous que l'ID de l'estimation est passé dans l'URL
if (isset($_GET['idEstimate'])) {
    require "../../back-office/_includes/_dbCo.php";
    $dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer l'ID de l'estimation depuis l'URL
    $idEstimate = $_GET['idEstimate'];

    try {
        // Requête SQL pour supprimer l'estimation
        $stmt = $dtLb->prepare("DELETE FROM estimate_obs WHERE id_estimate = :id_estimate");
        // Liaison du paramètre
        $stmt->bindParam(':id_estimate', $idEstimate);
        // Exécution de la requête
        $stmt->execute();
      
        $dltRe = $dtLb->prepare("DELETE FROM raw_estimate WHERE id_estimate = :id_estimate");
        // Liaison du paramètre
        $dltRe->bindParam(':id_estimate', $idEstimate);
        // Exécution de la requête
        $dltRe->execute();

         // Définir la notification de suppression avec succès
         $_SESSION['notif'] = [
            'type' => 'success',
            'message' => 'Estimation supprimée avec succès.'
        ];

        // Redirection après la suppression
        header("Location: .././list-devis-obs.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['notif'] = [
            'type' => 'error',
            'message' => 'Erreur lors de la suppression de l\'estimation : ' . $e->getMessage()
        ];
        header("Location: .././list-devis-obs.php");
        exit();
    }
} else {
   // Redirection vers une page appropriée après la suppression
   header("Location: .././list-devis-obs.php");
   exit();
}

?>
