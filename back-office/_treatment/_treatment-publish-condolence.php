<!-- <?php
require "../../back-office/_includes/_dbCo.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $condolenceId = isset($_POST['condolence_id']) ? intval($_POST['condolence_id']) : null;
    $publish = isset($_POST['publish']) ? ($_POST['publish'] === 'on') : false;

    // Mettre à jour la base de données
    $sqlUpdate = $dtLb->prepare("UPDATE condolences SET is_published = :is_published WHERE id_condolence = :condolence_id");
    $sqlUpdate->execute(['is_published' => $publish, 'condolence_id' => $condolenceId]);

    // Rediriger l'administrateur vers la page check-message.php
    header('Location: http://localhost/LeBaron/back-office/list-avis.php');
    exit();
}
?> -->
