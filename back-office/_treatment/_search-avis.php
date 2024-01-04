<?php
session_start();

// Vérifier si le formulaire de recherche a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['recherche'])) {
    // Nettoyer et récupérer la valeur du champ de recherche
    $recherche = strip_tags($_GET['recherche']);
    $idCondolence = isset($_GET['idCondolence']) ? $_GET['idCondolence'] : null;
    // Exécuter la requête de recherche dans la base de données
    $sqlSearch = $dtLb->prepare("SELECT d.id_defunt, d.nom_prenom_defunt, d.age, c.date_ceremonie
    FROM ceremonie c
    JOIN defunt d ON c.id_defunt = d.id_defunt WHERE nom_prenom_defunt LIKE :recherche");
    $sqlSearch->execute(['recherche' => "%$recherche%"]);
    $resultats = $sqlSearch->fetchAll(PDO::FETCH_ASSOC);
}


    // Vérifier s'il y a des résultats
    if ($sqlSearch->rowCount() > 0) {
        $_SESSION['notif'] = array('type' => 'success', 'message' => 'La recherche a donné des résultats.');
    } else {
        $_SESSION['notif'] = array('type' => 'warning', 'message' => 'Aucun résultat trouvé pour la recherche.');
    }

