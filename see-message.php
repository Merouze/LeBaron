<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<?php include './back-office/_treatment/_treatment-display-ad.php' ?>
<?php

$idDefunt = isset($_GET['idDefunt']) ? $_GET['idDefunt'] : null;

// Requête pour récupérer les messages de condoléances
$sqlSelectCondolences = $dtLb->prepare("SELECT id_defunt, id_condolence, nom_expditeur, email_expditeur, message, date_envoi, is_published FROM condolences WHERE id_defunt = :id_defunt AND is_published = 1  ORDER BY date_envoi DESC");
$sqlSelectCondolences->execute(['id_defunt' => $idDefunt]);
$condolences = $sqlSelectCondolences->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez les ID des messages de condoléances à mettre à jour
    $condolenceIds = isset($_POST['condolence_ids']) ? $_POST['condolence_ids'] : [];

    // Assurez-vous que $condolenceIds est un tableau
    if (!is_array($condolenceIds)) {
        $condolenceIds = [$condolenceIds];
    }
    try {

        // Mettez à jour la base de données pour chaque message de condoléances
        // Mettez à jour la base de données pour chaque message de condoléances
        foreach ($condolenceIds as $condolenceId) {
            $condolenceId = intval($condolenceId);

            // Vérifiez si la checkbox est cochée ou décochée
            $publish = isset($_POST['publish'][$condolenceId]) ? 1 : 0;

            // Mettez à jour la base de données
            $sqlUpdate = $dtLb->prepare("UPDATE condolences SET is_published = :is_published WHERE id_condolence = :condolence_id");
            $sqlUpdate->execute(['is_published' => $publish, 'condolence_id' => $condolenceId]);
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    // var_dump($_GET['idDefunt']);
    // Rediriger l'administrateur vers la page check-message.php
    header('Location: http://localhost/LeBaron/back-office/list-avis.php');
    exit();
}
?>
<?php
?>

<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav-family.php' ?>
<?php
    var_dump($_GET['idDefunt']);

// Affichage des notifications
if (isset($_SESSION['notif'])) {
    $notifType = $_SESSION['notif']['type'];
    $notifMessage = $_SESSION['notif']['message'];
    
    echo "<div class='notification $notifType'>$notifMessage</div>";
    
    // Nettoyer la notification après l'affichage
    unset($_SESSION['notif']);
}
?>
<h1 class="display grey text-align padding-title">Espace&nbsp;<span class="blue">Famille</span></h1>
<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Messages de condoléances :</span></h1>
<!-- Afficher les messages de condoléances -->
<?php if (!empty($condolences)) : ?>
    <div>
        <ul class="align-div">
            <?php foreach ($condolences as $condolence) : ?>
                <li class="border-message">
                    <strong class="blue">Nom :</strong> <?= $condolence['nom_expditeur'] ?><br><br>
                    <strong class="blue">Email :</strong> <?= $condolence['email_expditeur'] ?><br><br>
                    <strong class="blue">Message :</strong> <?= $condolence['message'] ?><br><br>
                    <input class="input-check" type="hidden" name="condolence_ids[]" value="<?= $condolence['id_condolence'] ?>">
                    
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php else : ?>
    <p>Aucun message de condoléances trouvé.</p>
<?php endif; ?>
</section>



<?php include './_includes./_form.php' ?>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>