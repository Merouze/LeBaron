<!-- // ----- # HEAD # ----- // -->
<?php include '../back-office/_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>

<?php $_SESSION['myToken'] = md5(uniqid(mt_rand(), true));
include '.././back-office/_treatment/_treatment-display-ad.php';
?>
<?php

$idDefunt = isset($_GET['idDefunt']) ? $_GET['idDefunt'] : null;

// Exécutez une requête pour récupérer les données actuelles du défunt
$sqlGetDefunt = $dtLb->prepare("SELECT nom_prenom_defunt, date_deces, age FROM defunt WHERE id_defunt = :idDefunt");
$sqlGetDefunt->execute(['idDefunt' => $idDefunt]);
$defunt = $sqlGetDefunt->fetch(PDO::FETCH_ASSOC);

// Exécutez une requête pour récupérer les données actuelles des proches
$sqlGetProche = $dtLb->prepare("SELECT nom_prenom_proche, lien_familial FROM proche WHERE id_defunt = :idDefunt");
$sqlGetProche->execute(['idDefunt' => $idDefunt]);
$proche = $sqlGetProche->fetch(PDO::FETCH_ASSOC);

// Exécutez une requête pour récupérer les données actuelles du proche principal
$sqlGetMainProche = $dtLb->prepare("SELECT main_proche, main_link FROM main_family WHERE id_defunt = :idDefunt");
$sqlGetMainProche->execute(['idDefunt' => $idDefunt]);
$Mainproche = $sqlGetMainProche->fetch(PDO::FETCH_ASSOC);

// Exécutez une requête pour récupérer les données actuelles de la ceremonie
$sqlGetCeremonie = $dtLb->prepare("SELECT date_ceremonie, heure_ceremonie, lieu_ceremonie FROM ceremonie WHERE id_defunt = :idDefunt");
$sqlGetCeremonie->execute(['idDefunt' => $idDefunt]);
$ceremonie = $sqlGetCeremonie->fetch(PDO::FETCH_ASSOC);

// Exécutez une requête pour récupérer les données actuelles de l'avis
$sqlGetAvis = $dtLb->prepare("SELECT avis_contenu FROM avis WHERE id_defunt = :idDefunt");
$sqlGetAvis->execute(['idDefunt' => $idDefunt]);
$avis = $sqlGetAvis->fetch(PDO::FETCH_ASSOC);

// Récupérez la valeur du nom et prénom actuel du défunt
$nomPrenomDefuntActuel = $defunt['nom_prenom_defunt'];
$dateDeathActuel = $defunt['date_deces'];
$ageActuel = $defunt['age'];
$nomProcheActuel = $proche['nom_prenom_proche'];
$lienActuel = $proche['lien_familial'];
$mainFamily = $Mainproche['main_proche'];
$mainLink = $Mainproche['main_link'];
$getDateCeremonie = $ceremonie['date_ceremonie'];
$getHourCeremonie = $ceremonie['heure_ceremonie'];
$getLocationCeremonie = $ceremonie['lieu_ceremonie'];
$getAvis = $avis['avis_contenu'];

if (!$idDefunt || !is_numeric($idDefunt)) {
    // Ajouter les nouveaux membres de la famille
foreach ($_POST['family-name'] as $index => $FamilyName) {
    $FamilyLinkValue = $_POST['family-link'][$index];

    $sqlFamilyMember = $dtLb->prepare("INSERT INTO proche (nom_prenom_proche, lien_familial, id_defunt) VALUES (:FamilyName, :FamilyLink, :idDefunt)");
    $sqlFamilyMember->execute([
        'FamilyName' => $FamilyName,
        'FamilyLink' => $FamilyLinkValue,
        'idDefunt' => $idDefunt,
    ]);
}}
    
    ?>

<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Modifier un&nbsp;<span class="blue">Avis de décès</span></h1>

<!-- <?php var_dump($proche); ?> -->

<!-- section form modif obituary -->
<form action="./_treatment/_treatment-modify.php" method="post" onsubmit="addFamilyMembersOnSubmit()">
    <input type="hidden" name="idDefunt" value="<?php echo $idDefunt; ?>">
    <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
    <label for="new-name">Nom et Prénom du défunt :</label>
    <input type="text" id="new-name" name="new-name" value="<?= $nomPrenomDefuntActuel ?>" required><br>
    <label for="new-main-name">Nom et Prénom Proche Principal :</label>
    <input type="text" id="new-main-name" name="new-main-name" value="<?= $mainFamily ?>" required><br>
    <select name="new-main-link" class="main-link" required>
        <option value="<?= $mainLink ?>"><?= $mainLink ?></option>
        <option value="Son epouse">Son épouse</option>
        <option value="Son epoux">Son époux</option>
        <hr>
        <option value="Sa fille">Sa fille</option>
        <option value="Ses filles">Ses filles</option>
        <option value="Son fils">Son fils</option>
        <option value="Ses fils">Ses fils</option>
        <option value="Ses enfants">Ses enfants</option>
        <option value="Sa belle fille">Sa belle fille</option>
        <option value="Son gendre">Son gendre</option>
        <hr>
        <option value="Sa soeur">Sa soeur</option>
        <option value="Ses soeurs">Ses soeurs</option>
        <option value="Son frere">Son frère</option>
        <option value="Ses freres">Ses frères</option>
        <option value="Ses freres et soeurs">Ses frères et soeurs</option>
        <hr>
        <option value="Son petit-fils">Son petit-fils</option>
        <option value="Sa petite-fille">Sa petite-fille</option>
        <option value="Ses petits-enfants">Ses petits-enfants</option>
        <option value="Ses arrière-petit-fils">Ses arrière-petit-fils</option>
        <option value="Ses arrière-petite-fille">Ses arrière-petite-fille</option>
        <option value="Ses arrières-petits-enfants">Ses arrières-petits-enfants</option>
        <hr>
        <option value="Son neveux">Son neuveux</option>
        <option value="Sa niece">Sa nièce</option>
        <option value="Ses neveux">Ses neveux</option>
        <hr>
        <option value="Son cousin">Son cousin</option>
        <option value="Ses cousins">Ses cousins</option>
        <option value="Sa cousine">Sa cousine</option>
        <option value="Ses cousines">Ses cousines</option>
        <hr>
        <option value="Sa tante">Sa tante</option>
        <option value="Ses tantes">Ses tantes</option>
        <option value="Son oncle">Son oncle</option>
        <option value="Ses oncles">Ses oncles</option>
        <option value="Ses oncles et tantes">Ses oncles et tantes</option>
        <hr>
        <option value="Son ami(e)">Son ami(e)</option>
        <option value="Ses ami(e)s">Ses ami(e)s</option>
    </select>
    <div id="family-members-container">
        <?php foreach ($proches as $proche) : ?>
            <div class="family-member">
                <label for="new-family-name[]">Nom et Prénom Famille et Proche :</label>
                <input type="text" id="new-family-name[]" class="family-name" name="new-family-name[]" value="<?= $proche['nom_prenom_proche'] ?>" required>
                <select name="new-family-link[]" class="family-name" required>
                    <option value="<?= $proche['lien_familial'] ?>"><?= $proche['lien_familial'] ?></option>
                    <option value="Sa fille">Sa fille</option>
                    <option value="Ses filles">Ses filles</option>
                    <option value="Son fils">Son fils</option>
                    <option value="Ses fils">Ses fils</option>
                    <option value="Ses enfants">Ses enfants</option>
                    <option value="Sa belle fille">Sa belle fille</option>
                    <option value="Son gendre">Son gendre</option>
                    <hr>
                    <option value="Sa soeur">Sa soeur</option>
                    <option value="Ses soeurs">Ses soeurs</option>
                    <option value="Son frere">Son frère</option>
                    <option value="Ses freres">Ses frères</option>
                    <option value="Ses freres et soeurs">Ses frères et soeurs</option>
                    <hr>
                    <option value="Son petit-fils">Son petit-fils</option>
                    <option value="Sa petite-fille">Sa petite-fille</option>
                    <option value="Ses petits-enfants">Ses petits-enfants</option>
                    <option value="Ses arrière-petit-fils">Ses arrière-petit-fils</option>
                    <option value="Ses arrière-petite-fille">Ses arrière-petite-fille</option>
                    <option value="Ses arrières-petits-enfants">Ses arrières-petits-enfants</option>
                    <hr>
                    <option value="Son neveux">Son neuveux</option>
                    <option value="Sa niece">Sa nièce</option>
                    <option value="Ses neveux">Ses neveux</option>
                    <hr>
                    <option value="Son cousin">Son cousin</option>
                    <option value="Ses cousins">Ses cousins</option>
                    <option value="Sa cousine">Sa cousine</option>
                    <option value="Ses cousines">Ses cousines</option>
                    <hr>
                    <option value="Sa tante">Sa tante</option>
                    <option value="Ses tantes">Ses tantes</option>
                    <option value="Son oncle">Son oncle</option>
                    <option value="Ses oncles">Ses oncles</option>
                    <option value="Ses oncles et tantes">Ses oncles et tantes</option>
                    <hr>
                    <option value="Son ami(e)">Son ami(e)</option>
                    <option value="Ses ami(e)s">Ses ami(e)s</option>
                </select>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="btn-add">
        <button type="button" onclick="addFamilyMember()">Ajouter un membre</button>
        <button type="button" onclick="removeFamilyMember()">Supprimer le dernier membre</button>
    </div>

    <label for="new-death-date">Date du décès :</label>
    <input type="date" id="new-death-date" name="new-death-date" value="<?= $dateDeathActuel ?>" required><br>

    <label for="new-age-death">Age :</label>
    <input type="text" id="new-age-death" name="new-age-death" value="<?= $ageActuel ?>" required><br>

    <label for="new-ceremony-date">Date de la cérémonie :</label>
    <input type="date" id="new-ceremony-date" name="new-ceremony-date" value="<?= $getDateCeremonie ?>" required><br>

    <label for="new-location_ceremony">Lieu de la cérémonie :</label>
    <input type="text" id="new-location_ceremony" name="new-location_ceremony" value="<?= $getLocationCeremonie ?>" required><br>

    <label for="new-hour_ceremony">heure de la cérémonie :</label>
    <input type="time" id="new-hour_ceremony" name="new-hour_ceremony" value="<?= $getHourCeremonie ?>" required><br>


    <label for="new-details">Détails :</label>
    <textarea id="new-details" name="new-details" rows="10" required><?= $getAvis ?></textarea><br>

    <button name="update" type="submit">Modifier</button>
</form>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>

<script src=".././asset/Js/script.js"></script>
<script src=".././asset/Js/fonctions.js"></script>
</body>
</html>