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

<?php var_dump($proches); ?>
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
                        <li><?= $proche['nom_prenom_proche'] ?>, <?= $proche['lien_familial'] ?>.</li><br>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <p> Ont la tristesse de vous faire part du décès de :</p><br>
            <p><span class="blue bold"><?= $defunt['nom_prenom_defunt'] ?></span></p><br>
            <p>Survenu le <?= $defunt['date_deces'] ?> à l'age de <?= $defunt['age'] ?> ans.</p>
            <p>La cérémonie sera célébrée le <?= $ceremonie['date_ceremonie'] ?> à <?= $ceremonie['heure_ceremonie'] ?>.</p>
            <p>Lieu : <?= $ceremonie['lieu_ceremonie'] ?>.</p>
            <p><?= $avis['avis_contenu'] ?></p>

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

<script>
    function confirmDelete(idDefunt) {
        // Utilisez la fonction confirm() pour afficher une boîte de dialogue avec les boutons OK et Annuler
        var confirmation = confirm("Êtes-vous sûr de vouloir supprimer cet avis de décès ?");

        // Si l'utilisateur clique sur OK, redirigez vers la page de suppression avec l'id du défunt
        if (confirmation) {
            window.location.href = `./_treatment/_delete.php?idDefunt=${idDefunt}`;
        }
    }
</script>





<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>