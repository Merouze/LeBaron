<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>

<?php include './back-office/_treatment/_treatment-display-ad.php' ?>


<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Avis de décés et &nbsp;<span class="blue">Condoléances</span></h1>
<!-- section condoleance -->
<section class="avis-deces">
    <div class="title-top">
        <h2 class="defunt-name white"><?= $defunt['nom_prenom_defunt'] ?></h2>
    </div>
    <div class="list-family">

        <?php if ($defunt !== false) : ?>
    
            <!-- <?php var_dump($proches); ?> -->
            <!-- <?php var_dump($prochePrincipale); ?> -->
            <?php if (!empty($prochePrincipale)) : ?>
                <!-- Affichage du proche principal -->
                <p><?= $prochePrincipale[0]['main_proche'] ?> <?= $prochePrincipale[0]['main_link'] ?></p>
                <!-- Affichage des membres de la famille -->
                <ul>
                    <?php foreach ($proches as $proche) : ?>
                        <li><?= $proche['nom_prenom_proche'] ?>, <?= $proche['lien_familial'] ?>.</li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <p> Ont la tristesse de vous faire part du décès de :</p>
            <p><span class="blue bold"><?= $defunt['nom_prenom_defunt'] ?></span></p><br>
            <p>Survenu le <?= $defunt['date_deces'] ?> à l'age de <?= $defunt['age'] ?> ans.</p>
            <p  class="text-align">La cérémonie sera célébrée le <?= $dateCeremonieFormattee ?> à <?= $ceremonie['heure_ceremonie'] ?>.</p>
            <p>Lieu : <?= $ceremonie['lieu_ceremonie'] ?>.</p>
            <p><?= $avis['avis_contenu'] ?></p>
        <?php endif; ?>
    </div>
    <div class="link-bottom">
        <div class="defunt-name">
            <a href="condoleance.php">Transmettre ses condoléances</a>
        </div>
    </div>
</section>

<!-- // ----- # FORM # ----- // -->
<?php include './_includes./_form.php' ?>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>