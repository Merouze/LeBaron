<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>

<?php include './back-office/_treatment/_treatment-display-ad.php' ?>


<!-- // ----- # NAV # ----- // -->
<?php include './_includes./_nav.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Avis de décés et &nbsp;<span class="blue">Condoléances</span></h1>
<!-- section obituary -->
<section class="avis-deces">
    <div class="title-top">
        <h2 class="defunt-name white"><?= $defunt['nom_prenom_defunt'] ?></h2>
    </div>
    <div class="list-family">
        <?php if ($defunt !== false) : ?>
            <!--                 
            <?php var_dump($proches); ?>
            <?php var_dump($prochePrincipale); ?>
            <?php var_dump($_GET); ?> -->
            <?php if (!empty($prochePrincipale)) : ?>
                <ul class="text-align">
                    <!-- Affichage du proche principal -->
                    <li class="blue bold"><?= $prochePrincipale[0]['main_proche'] ?>,</span> <?= $prochePrincipale[0]['main_link'] ?>.</li>
                    <br>
                    <!-- Affichage des membres de la famille -->
                    <?php foreach ($proches as $proche) : ?>
                        <li><?= $proche['nom_prenom_proche'] ?>, <?= $proche['lien_familial'] ?>.</li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <p class="text-align"> Ont la tristesse de vous faire part du décès de :</p>
            <p><span class="blue bold"><?= $defunt['nom_prenom_defunt'] ?>.</span></p><br>
            <p>Survenu le <span class="blue bold"><?= $dateDeDecesFormattee ?>,</span></p>
            <p>A l'age de <span class="blue bold"><?= $defunt['age'] ?> ans.</span></p>
            <p class="text-align">La cérémonie sera célébrée le <span class="blue bold"><?= $dateCeremonieFormattee ?>.</span></p>
            <p class="text-align">A <span class="blue bold"><?= $heureCeremonieFormattee ?> heures.</p>
            <p><span class="grey bold">Lieu :</span> <?= $ceremonieData['lieu_ceremonie'] ?>.</p>
            <p class="text-align"><?= $avis['avis_contenu'] ?></p>
        <?php endif; ?>
    </div>
    <div class="link-bottom">
        <div class="defunt-name">
            <a href="condoleance.php?idDefunt=<?= urlencode($_GET['idDefunt']) ?>">Transmettre ses condoléances</a>
        </div>
    </div>
</section>

<!-- // ----- # FORM # ----- // -->
<?php include './_includes./_form.php' ?>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes./_footer.php' ?>

<script src="asset/Js/script.js"></script>
<script src="asset/Js/fonctions.js"></script>
</body>
</html>