<?php
require "../../back-office/_includes/_dbCo.php";
$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();

if (isset($_GET['idDefunt'])) {
    $idDefunt = $_GET['idDefunt'];

   // _treatment/_delete_family_data.php

require "../../back-office/_includes/_dbCo.php";

if (isset($_GET['idDefunt'])) {
    $idDefunt = $_GET['idDefunt'];
    // var_dump($idDefunt);
    // exit;

    // Supprimez les données familiales liées au défunt dans la table user_famille
    $sqlDeleteFamilyData = $dtLb->prepare("DELETE FROM defunt WHERE id_defunt = :idDefunt");
    $sqlDeleteFamilyData->execute(['idDefunt' => $idDefunt]);

    // Supprimez les données familiales liées au défunt dans la table user_famille
    $sqlDeleteFamilyData = $dtLb->prepare("DELETE FROM user_famille WHERE id_defunt = :idDefunt");
    $sqlDeleteFamilyData->execute(['idDefunt' => $idDefunt]);

    // Supprimez les avis liés au défunt dans la table avis
    $sqlDeleteAvis = $dtLb->prepare("DELETE FROM avis WHERE id_defunt = :idDefunt");
    $sqlDeleteAvis->execute(['idDefunt' => $idDefunt]);

    // Supprimez les données de cérémonie liées au défunt dans la table ceremonie
    $sqlDeleteCeremonie = $dtLb->prepare("DELETE FROM ceremonie WHERE id_defunt = :idDefunt");
    $sqlDeleteCeremonie->execute(['idDefunt' => $idDefunt]);

    // Supprimez les condoléances liées au défunt dans la table condolences
    $sqlDeleteCondolences = $dtLb->prepare("DELETE FROM condolences WHERE id_defunt = :idDefunt");
    $sqlDeleteCondolences->execute(['idDefunt' => $idDefunt]);

    // Supprimez les données familiales principales liées au défunt dans la table main_family
    $sqlDeleteMainFamily = $dtLb->prepare("DELETE FROM main_family WHERE id_defunt = :idDefunt");
    $sqlDeleteMainFamily->execute(['idDefunt' => $idDefunt]);

    // Supprimez les données des proches liées au défunt dans la table proche
    $sqlDeleteProche = $dtLb->prepare("DELETE FROM proche WHERE id_defunt = :idDefunt");
    $sqlDeleteProche->execute(['idDefunt' => $idDefunt]);

    $_SESSION['notif'] = ['type' => 'success', 'message' => 'Les données familiales ont été supprimées avec succès.'];
    header('Location: /LeBaron/back-office/see-accounts.php');
    exit;
}

}

// Vérifiez si le formulaire de recherche a été soumis
if (isset($_POST['search-accounts'])) {
    // Récupérez la valeur de recherche à partir du formulaire POST
    $search = isset($_POST['search']) ? strip_tags($_POST['search']) : '';

    // Préparez la requête SQL
    $sql = "SELECT email, nom_prenom_defunt, id_defunt
            FROM user_famille
            JOIN defunt USING (id_defunt)
            WHERE email LIKE :search
               OR nom_prenom_defunt LIKE :search";

    // Préparez la requête avec PDO
    $stmt = $dtLb->prepare($sql);

    // Exécutez la requête en incluant directement la valeur dans le tableau d'exécution
    $stmt->execute(['search' => "%$search%"]);

 // Vérifiez si la recherche a donné des résultats
 if ($stmt->rowCount() > 0) {
    // Récupérez les résultats
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ajoutez une notification de succès
    $_SESSION['notif'] = [
        'type' => 'success',
        'message' => 'Recherche effectuée avec succès.'
    ];

    // Redirigez vers la page appropriée avec les résultats de la recherche
    $_SESSION['search_results'] = $results;
    header('Location: /LeBaron/back-office/see-accounts.php');
    exit;
} else {
    // Aucun résultat trouvé, ajoutez une notification d'erreur
    $_SESSION['notif'] = [
        'type' => 'error',
        'message' => 'Aucun résultat trouvé.'
        
    ];

    // Redirigez vers la page appropriée
    header('Location: /LeBaron/back-office/see-accounts.php');
    exit;
}
}
?>
