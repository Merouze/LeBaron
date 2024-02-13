<?php
require "../../back-office/_includes/_dbCo.php";
session_start();
//****************************** Treatment create pdf for billing

if (isset($_POST['submitAddBill'])) {

    $designations = isset($_POST["designation"]) ? $_POST["designation"] : [];
    $advances = isset($_POST["frais_avances"]) ? $_POST["frais_avances"] : [];
    $htPrices10 = isset($_POST["prix_ht_10"]) ? $_POST["prix_ht_10"] : [];
    $htPrices20 = isset($_POST["prix_ht_20"]) ? $_POST["prix_ht_20"] : [];
    $name = strip_tags($_POST["name"]);
    $adress = strip_tags($_POST["adress"]);
    $cP = strip_tags($_POST["cP"]);
    $city = strip_tags($_POST["city"]);
    $email = strip_tags($_POST["email"]);
    $totalHt = strip_tags($_POST["total_ht"]);
    $tva10 = strip_tags($_POST["tva_10"]);
    $tva20 = strip_tags($_POST["tva_20"]);
    $totalAdvance = strip_tags($_POST["total_frais_avances"]);
    $ttc = strip_tags($_POST["ttc"]);
    $message = strip_tags($_POST["commentaire"]);
    $isSave = 1;

    // Requête SQL pour les données générales
    $sqlGeneral = $dtLb->prepare("INSERT INTO factures (name, adress, cP, city, email, total_ht, tva_10, tva_20, total_frais_avances, ttc, message, is_save) VALUES (:name, :adress, :cP, :city, :email, :total_ht, :tva_10, :tva_20, :total_frais_avances, :ttc, :message, :is_save)");

    // Exécution de la requête pour les données générales
    $sqlGeneral->execute([
        'name' => $name,
        'adress' => $adress,
        'cP' => $cP,
        'city' => $city,
        'email' => $email,
        'total_ht' => $totalHt,
        'tva_10' => $tva10,
        'tva_20' => $tva20,
        'total_frais_avances' => $totalAdvance,
        'ttc' => $ttc,
        'message' => $message,
        'is_save' => $isSave,
    ]);

    // Récupération de l'id_bill généré
    $id_bill = $dtLb->lastInsertId();

    // Requête SQL pour les lignes spécifiques
    $sqlSpecific = $dtLb->prepare("INSERT INTO raw_bill (id_bill, designation, frais_avances, prix_ht_10, prix_ht_20) VALUES (:id_bill, :designation, :frais_avances, :prix_ht_10, :prix_ht_20)");

    // ...
    // var_dump($id_bill);
    // exit;

    foreach ($designations as $key => $designation) {
        // Exécution de la requête pour chaque ligne
        $sqlSpecific->execute([
            'id_bill' => $id_bill,
            'designation' => $designation,
            'frais_avances' => $advances[$key],
            'prix_ht_10' => $htPrices10[$key],
            'prix_ht_20' => $htPrices20[$key],
        ]);
    }}
    //   Redirection avec un code de statut approprié
    header('Location: /LeBaron/back-office/billing.php');
    exit;
?>