<?php
require "../../back-office/_includes/_dbCo.php";
$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
$_SESSION['myToken'] = md5(uniqid(mt_rand(), true));


if (isset($_GET['idDefunt']) && isset($_GET['idCondolence'])) {
    $idDefunt = $_GET['idDefunt'];
    $idCondolence = $_GET['idCondolence'];

    // Supprimer le message de condoléances spécifique lié à l'ID du défunt
    $sqlDeleteCondolence = $dtLb->prepare("DELETE FROM condolences WHERE id_defunt = :idDefunt AND id_condolence = :idCondolence");
    $sqlDeleteCondolence->execute(['idDefunt' => $idDefunt, 'idCondolence' => $idCondolence]);

    // Vérifier si la suppression a réussi
    if ($sqlDeleteCondolence->rowCount() > 0) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Message de condoléances supprimé avec succès'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors de la suppression du message de condoléances'];
    }

    // Redirection vers une page appropriée après la suppression
    header("Location: .././list-avis.php");
    exit();
}
?>
