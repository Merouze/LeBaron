<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login-family.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav-family.php' ?>

<?php
$idDefunt = isset($_GET['idDefunt']) ? $_GET['idDefunt'] : null;

// Requête pour récupérer les messages de condoléances
$sqlSelectCondolences = $dtLb->prepare("SELECT id_defunt, id_condolence, nom_expditeur, email_expditeur, message, date_envoi, is_published FROM condolences WHERE id_defunt = :id_defunt AND is_published = 1 ORDER BY date_envoi DESC");
$sqlSelectCondolences->execute(['id_defunt' => $idDefunt]);
$condolences = $sqlSelectCondolences->fetchAll(PDO::FETCH_ASSOC);


?>
<!-- section header title -->

<section class="header-pages">
</section>
<?php
// var_dump($_SESSION["id_defunt"]);
?>
<h1 class="display grey text-align padding-title">Message(s) de&nbsp;<span class="blue">Condoléance(s)</span></h1>
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
                    </li>
                <?php endforeach; ?>
            </ul>
        </form>
    <?php else : ?>
        <p class="text-align"><span class="error">Aucun message de condoléances trouvé.</span></p>
    <?php endif; ?>
</div>
<div class="nav-links justify">
    <ul>
        <li><a href="obituary-family.php?idDefunt=<?= urlencode($idDefunt) ?>">Voir l'Avis de Décès</a></li>
    </ul>
</div>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>