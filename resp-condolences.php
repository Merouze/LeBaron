<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login-family.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav-family.php' ?>

<?php
$idDefunt = isset($_GET['idDefunt']) ? $_GET['idDefunt'] : null;
$idCondolences = isset($_GET['idCondolences']) ? $_GET['idCondolences'] : null;
// var_dump($idCondolences);
// Requête pour récupérer les messages de condoléances
$sqlSelectCondolences = $dtLb->prepare("SELECT id_defunt, id_condolence, nom_expditeur, email_expditeur, message, date_envoi, is_published, sent_thanks FROM condolences WHERE id_defunt = :id_defunt AND id_condolence = :id_condolence AND is_published = 1 ORDER BY date_envoi DESC");
$sqlSelectCondolences->execute(['id_defunt' => $idDefunt, 'id_condolence' => $idCondolences]);
$condolences = $sqlSelectCondolences->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- section header title -->
<section class="header-pages">
</section>
<?php
var_dump($condolences);
?>
<h1 class="display grey text-align padding-title">Message(s) de&nbsp;<span class="blue">Condoléance(s)</span></h1>
<div>
    <?php foreach ($condolences as $condolence) : ?>
        <li class="border-check">
            <strong>Nom :</strong> <?= $condolence['nom_expditeur'] ?><br>
            <strong>Email :</strong> <?= $condolence['email_expditeur'] ?><br>
            <strong>Message :</strong> <?= $condolence['message'] ?><br><br>
            <!-- <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>"> -->
            <!-- <input class="input-check" type="hidden" name="condolence_ids[]" value="<?= $condolence['id_condolence'] ?>"> -->
        </li>
    <?php endforeach; ?>
    <form action="../LeBaron/back-office/_treatment/_treatment-sent-thanks.php" method="post">
        <strong><p>Nom et Prénom :</p></strong>
        <input name="name" type="text">
        <strong><p>Message :</p></strong>
        <textarea id="message" name="message" rows="6" placeholder="Votre message" required></textarea>
        <input type="hidden" id="email" name="email" value="<?= $condolence['email_expditeur'] ?>">
        <input type="hidden" id="idDefunt" name="idDefunt" value="<?= $idDefunt ?>">
        <input class="input-check" type="hidden" name="condolence_id" value="<?= $condolence['id_condolence'] ?>">
        <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
        <button type="submit">Envoyer</button>
    </form>
</div>

<div class="link-bottom">
    <div class="defunt-name">
        <li><a href="condolences-family.php?idDefunt=<?= urlencode($idDefunt) ?>">Voir les Condoléances</a></li>
    </div>
</div>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>