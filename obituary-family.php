<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login-family.php' ?>
<?php include './back-office/_treatment/_treatment-display-ad.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav-family.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>

<h1 class="display grey text-align padding-title">Avis de <span class="blue">décès</span></h1>
<!-- section obituary -->
<section class="avis-deces">
    <div class="title-top">
        <h2 class="defunt-name white"><?= $defunt['nom_prenom_defunt'] ?></h2>
    </div>
    <div class="list-family">

        <?php if ($defunt !== false) : ?>
            <?php if (!empty($prochePrincipale)) : ?>
                <ul class="text-align">
                <!-- Affichage du proche principal -->
                <li class="bold blue"><?= $prochePrincipale[0]['main_proche'] ?>, <?= $prochePrincipale[0]['main_link'] ?>.</li>
                <br>
                <!-- Affichage des membres de la famille -->
                    <?php foreach ($proches as $proche) : ?>
                        <li><?= $proche['nom_prenom_proche'] ?>, <?= $proche['lien_familial'] ?>.</li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <p> Ont la tristesse de vous faire part du décès de :</p>
            <p><span class="blue bold"><?= $defunt['nom_prenom_defunt'] ?></span></p><br>
            <p>Survenu le <?= $defunt['date_deces'] ?> à l'age de <?= $defunt['age'] ?> ans.</p>
            <p class="text-align">La cérémonie sera célébrée le <?= $dateCeremonieFormattee ?> à <?= $heureCeremonieFormattee ?>.</p>
            <p>Lieu : <?= $ceremonieData['lieu_ceremonie'] ?>.</p>
            <p class="text-align"><?= $avis['avis_contenu'] ?></p>
        <?php endif; ?>
    </div>
    <div class="link-bottom">
        <div class="defunt-name">
        <li><a href="condolences-family.php?idDefunt=<?= urlencode($idDefunt) ?>">Voir les Condoléances</a></li>
        </div>
    </div>
</section>
<!-- <div class="nav-links justify">
    <ul>
        <li><a href="condolences-family.php?idDefunt=<?= urlencode($idDefunt) ?>">Voir les Condoléances</a></li>
    </ul>
</div> -->
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>