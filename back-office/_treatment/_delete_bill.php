
<?php
require "../../back-office/_includes/_dbCo.php";
session_start();
// var_dump($_GET);
// exit;

if (isset($_GET['idBill'])) {
    $idBill = $_GET['idBill'];

    // Supprimez les données liées à la facture dans la table factures
    $sqlDeleteFacture = $dtLb->prepare("DELETE FROM factures WHERE id_bill = :idBill");
    $sqlDeleteFacture->execute(['idBill' => $idBill]);

    // Supprimez les données liées à la facture dans la table raw_bill
    $sqlDeleteRawBill = $dtLb->prepare("DELETE FROM raw_bill WHERE id_bill = :idBill");
    $sqlDeleteRawBill->execute(['idBill' => $idBill]);

    $_SESSION['notif'] = ['type' => 'success', 'message' => 'La facture a été supprimée avec succès.'];
    header('Location: /LeBaron/back-office/see-list-bills.php');
    exit;
}
?>

