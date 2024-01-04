<!-- // ----- # HEAD # ----- // -->
<?php include '../back-office/_includes/_head.php' ?>
<?php include '../back-office/_treatment/_treatment-display-ad.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Condoléances</span></h1>

<?php
$idDefunt = isset($_GET['idDefunt']) ? $_GET['idDefunt'] : null;
$idCondolence = isset($_GET['idCondolence']) ? $_GET['idCondolence'] : null;

// Requête pour récupérer les messages de condoléances
$sqlSelectCondolences = $dtLb->prepare("SELECT id_defunt, id_condolence, nom_expditeur, email_expditeur, message, date_envoi FROM condolences WHERE id_defunt = :id_defunt");
$sqlSelectCondolences->execute(['id_defunt' => $idDefunt]);
$condolences = $sqlSelectCondolences->fetchAll(PDO::FETCH_ASSOC);
?>


<!-- Afficher les messages de condoléances -->

<?php if (!empty($condolences)) : ?>
<?php (var_dump($condolences)); ?>
    <h2>Messages de condoléances :</h2>
    <ul>
        <?php foreach ($condolences as $condolence) : ?>
            <li>
                <strong>Nom :</strong> <?= $condolence['nom_expditeur'] ?><br>
                <strong>Email :</strong> <?= $condolence['email_expditeur'] ?><br>
                <strong>Message :</strong> <?= $condolence['message'] ?><br>
                <a href="check-message.php?idCondolence=<?= $idCondolence ?>">Supprimer</a>
                <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="javascript:void(0);" onclick="confirmDelete(<?= $condolence['id_defunt'] ?>);">Supprimer</a></p>;
            </li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>Aucun message de condoléances trouvé.</p>
<?php endif; ?>

</section>

<script>
    function confirmDelete(idDefunt) {
        // Utilisez la fonction confirm() pour afficher une boîte de dialogue avec les boutons OK et Annuler
        var confirmation = confirm("Êtes-vous sûr de vouloir supprimer ce message de condoléance ?");

        // Si l'utilisateur clique sur OK, redirigez vers la page de suppression avec l'id du défunt
        if (confirmation) {
            window.location.href = `./_treatment/_treatment_message.php?idCondolence=<?= $idCondolence ?>&idDefunt=<?= $idDefunt ?>`;
        }
    }
</script>





<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>