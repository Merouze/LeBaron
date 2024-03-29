<!-- // ----- # HEAD # ----- // -->
<?php include '../back-office/_includes/_head.php' ?>
<?php include '../back-office/_treatment/_treatment-display-ad.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Avis de&nbsp;<span class="blue">Décès</span></h1>
<!-- <?php var_dump($proches); ?> -->
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
                <ul class="text-align">
                <li class="bold blue"><?= $prochePrincipale[0]['main_proche'] ?> <?= $prochePrincipale[0]['main_link'] ?>.</li>
                <br>
                <!-- Affichage des membres de la famille -->
                    <?php foreach ($proches as $proche) : ?>
                        <li><?= $proche['nom_prenom_proche'] ?>, <?= $proche['lien_familial'] ?>.</li><br>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <p> Ont la tristesse de vous faire part du décès de :</p><br>
            <p><span class="blue bold"><?= $defunt['nom_prenom_defunt'] ?></span></p><br>
            <p>Survenu le <?= $dateDeDecesFormattee ?>,</p>
            <p>A l'age de <?= $defunt['age'] ?> ans.</p>
            <p class="text-align">La cérémonie sera célébrée le <?= $dateCeremonieFormattee ?>.</p>
            <p class="text-align">A <?= $heureCeremonieFormattee ?> heures.</p>
            <p>Lieu : <?= $ceremonieData['lieu_ceremonie'] ?>.</p>
            <p class="text-align"><?= $avis['avis_contenu'] ?></p>

        <?php endif; ?>
    </div>
    <div class="link-bottom">
        <div class="defunt-name">
            <a href='check-message.php?idDefunt=<?= urlencode($avis['id_defunt']) ?>'>Voir les condoléances</a>
        </div>
        <div class="defunt-name">
            <a href='modif-avis.php?idDefunt=<?= urlencode($avis['id_defunt']) ?>'>Modifier l'avis de décès</a>
        </div>
        <div class="defunt-name">
            <a href='javascript:void(0);' onclick="confirmDelete(<?= $avis['id_defunt'] ?>);">Supprimer l'avis de décès</a>
        </div>
    </div>
</section>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>

<script src=".././asset/Js/script.js"></script>
<script src=".././asset/Js/fonctions.js"></script>
</body>
</html>