<!-- // ----- # HEAD # ----- // -->
<?php include '../back-office/_includes/_head.php' ?>
<?php include '../back-office/_treatment/_treatment-display-ad.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<?php

$idDefunt = isset($_GET['idDefunt']) ? $_GET['idDefunt'] : null;

// Requête pour récupérer les messages de condoléances
$sqlSelectCondolences = $dtLb->prepare("SELECT id_defunt, id_condolence, nom_expditeur, email_expditeur, message, date_envoi, is_published FROM condolences WHERE id_defunt = :id_defunt ORDER BY date_envoi DESC");
$sqlSelectCondolences->execute(['id_defunt' => $idDefunt]);
$condolences = $sqlSelectCondolences->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'])) {
    // Récupérez les ID des messages de condoléances à mettre à jour
    $condolenceIds = isset($_POST['condolence_ids']) ? $_POST['condolence_ids'] : [];
    $token = strip_tags($_POST['token']);

    if ($token === $_SESSION['myToken']) {

        // Assurez-vous que $condolenceIds est un tableau
        if (!is_array($condolenceIds)) {
            $condolenceIds = [$condolenceIds];
        }
        try {
            // Mettez à jour la base de données pour chaque message de condoléances
            foreach ($condolenceIds as $condolenceId) {
                $condolenceId = intval($condolenceId);

                // Vérifiez si la checkbox est cochée ou décochée
                $publish = isset($_POST['publish'][$condolenceId]) ? 1 : 0;

                // Mettez à jour la base de données
                $sqlUpdate = $dtLb->prepare("UPDATE condolences SET is_published = :is_published WHERE id_condolence = :condolence_id");
                $sqlUpdate->execute(['is_published' => $publish, 'condolence_id' => $condolenceId]);
            }
            $_SESSION['notif'] = ['type' => 'success', 'message' => 'Les données ont été mises à jour avec succès.'];
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        // var_dump($_POST);
        // Rediriger l'administrateur vers la page check-message.php
        header('Location: http://localhost/LeBaron/back-office/list-avis.php');
        exit();
    }
}
?>

<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Messages de condoléances :</span></h1>
<!-- section message condolences -->
<div>
    <?php if (!empty($condolences)) : ?>
        <form class="form-check" action="" method="post">
            <ul class="align-content">
                <?php foreach ($condolences as $condolence) : ?>
                    <li class="border-check">
                        <strong class="print">Nom :</strong> <?= $condolence['nom_expditeur'] ?><br>
                        <strong class="print">Email :</strong> <?= $condolence['email_expditeur'] ?><br>
                        <strong class="print">Message :</strong> <?= $condolence['message'] ?><br>
                        <input class="input-check" type="hidden" name="condolence_ids[]" value="<?= $condolence['id_condolence'] ?>">
                        <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
                        <label for="publish<?= $condolence['id_condolence'] ?>" class="no-print"><strong>Publier :</strong></label>
                        <input class="input-check condolence-checkbox no-print" type="checkbox" name="publish[<?= $condolence['id_condolence'] ?>]" id="publish<?= $condolence['id_condolence'] ?>" value="<?= $condolence['id_condolence'] ?>" <?= $condolence['is_published'] ? 'checked' : '' ?>>
                        <p class="obituary-cta no-print">
                            <a class="cta-btn-list-ad cta-obituary" href="javascript:void(0);" onclick="confirmDeleteMessage(<?= $condolence['id_condolence'] ?>)">Supprimer le message</a>
                        </p>
                    </li>
                <?php endforeach; ?>
            </ul>
</div>
<div class="btn-form-check">
    <div> <label for="checkAll">Tout cocher / décocher
            <input class="input-check" type="checkbox" id="checkAll"></label>
        <figure class="figure">Les messages cochés sont publié sur l'espace famille</figure>
    </div>
    <div>
        <button class="cta-btn-list-ad" type="submit">Publier</button>
        <button class="cta-btn-list-ad"><a target="_blank" href="_treatment/_print-condolence.php?idDefunt=<?= urlencode($idDefunt) ?>">Voir le pdf</a></button>
    </div>
</div>
</form>
<?php else : ?>
    <p>Aucun message de condoléances trouvé.</p>
<?php endif; ?>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>

<script src=".././asset/Js/script.js"></script>
<script src=".././asset/Js/fonctions.js"></script>
</body>

</html>