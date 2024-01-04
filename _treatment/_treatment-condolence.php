<?php
require ".././back-office/_includes/_dbCo.php";
session_start();
$_SESSION['myToken'] = md5(uniqid(mt_rand(), true));


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $name = strip_tags($_POST['name']);
    $email = strip_tags($_POST['email']);
    $message = strip_tags($_POST['message']);
    $token = strip_tags($_POST['token']); 
    $idDefunt = isset($_POST['idDefunt']) ? intval($_POST['idDefunt']) : null;
    
    // var_dump($_POST);
    // exit;

    // Valider les données (ajoutez des validations supplémentaires au besoin)
    if (empty($name) || empty($email) || empty($message)) {
        // Gérer les erreurs de validation
        $_SESSION['notif'] = array('type' => 'error', 'message' => 'Veuillez remplir tous les champs.');
        header('Location: .././recherche-avis.php');
        exit();
    }
    // Requête d'Insertion dans la table condolences
    $sqlInsert = $dtLb->prepare("INSERT INTO condolences (id_defunt, nom_expditeur, email_expditeur, message) VALUES (:id_defunt, :nom_expditeur, :email_expditeur, :message)");
    $sqlInsert->execute([
        'id_defunt' => $idDefunt,
        'nom_expditeur' => $name,
        'email_expditeur' => $email,
        'message' => $message,
    ]);

    $_SESSION['notif'] = ['type' => 'success', 'message' => 'Condoléances envoyées avec succès.'];
    
    header('Location: .././recherche-avis.php');
    exit();
}
?>
