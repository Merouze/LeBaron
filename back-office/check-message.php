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
    // var_dump($_POST);
    // Rediriger l'administrateur vers la page check-message.php
    header('Location: http://localhost/LeBaron/back-office/list-avis.php');
    exit();
}
?>

<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Messages de condoléances :</span></h1>
<!-- section message condolences -->
<div id="condolencesList">
    <?php if (!empty($condolences)) : ?>
        <form class="form-check" action="" method="post">
            <ul class="align-content">
                <?php foreach ($condolences as $condolence) : ?>
                    <li class="border-check">
                        <strong>Nom :</strong> <?= $condolence['nom_expditeur'] ?><br>
                        <strong>Email :</strong> <?= $condolence['email_expditeur'] ?><br>
                        <strong>Message :</strong> <?= $condolence['message'] ?><br>
                        <input class="input-check" type="hidden" name="condolence_ids[]" value="<?= $condolence['id_condolence'] ?>">
                        <label for="publish<?= $condolence['id_condolence'] ?>"><strong>Publier :</strong></label>
                        <input class="input-check condolence-checkbox" type="checkbox" name="publish[<?= $condolence['id_condolence'] ?>]" id="publish<?= $condolence['id_condolence'] ?>" value="<?= $condolence['id_condolence'] ?>" <?= $condolence['is_published'] ? 'checked' : '' ?>>
                        <p class="obituary-cta">
                            <a class="cta-btn-list-ad cta-obituary" href="javascript:void(0);" onclick="confirmDelete(<?= $condolence['id_condolence'] ?>)">Supprimer le message</a>
                        </p>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="btn-form-check">
                <div> <label for="checkAll">Tout cocher / décocher
                        <input class="input-check" type="checkbox" id="checkAll"></label>
                    <figure class="figure">Les messages cochés sont publié sur l'espace famille</figure>
                </div>
                <div>
                    <button class="cta-btn-list-ad" type="submit">Enregistrer</button>
                    <!-- btn print -->
                    <button class="cta-btn-list-ad" onclick="window.print()">Imprimer</button>
                </div>
            </div>
        </form>
    <?php else : ?>
        <p>Aucun message de condoléances trouvé.</p>
    <?php endif; ?>
</div>

<script>
    function confirmDelete(idCondolence) {
        // Utilisez la fonction confirm() pour afficher une boîte de dialogue avec les boutons OK et Annuler
        const confirmation = confirm("Êtes-vous sûr de vouloir supprimer ce message de condoléance ?");

        // Si l'utilisateur clique sur OK, redirigez vers la page de suppression avec l'id du défunt
        if (confirmation) {
            window.location.href = `./_treatment/_treatment_message.php?idCondolence=${idCondolence}&idDefunt=<?= $idDefunt ?>`;
        }
    }
</script>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>