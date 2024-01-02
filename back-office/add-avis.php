<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<?php $_SESSION['myToken'] = md5(uniqid(mt_rand(), true));
?>

<!-- section header title -->
<section class="header-pages">
</section>
<h1 class="display grey text-align padding-title">Ajouter un&nbsp;<span class="blue">Avis de décès</span></h1>

<!-- section form add obituary -->
<form action="./_treatment/_treatment-add-ad.php" method="post">
    <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">


    <label for="name">Nom et Prénom du défunt :</label>
    <input type="text" id="name" name="name" required><br>

    <label for="main-name">Nom et Prénom Proche Principal :</label>
    <input type="text" id="main-name" name="main-name" required>
    <select name="main-link" class="main-link" required>
        <option value="Son epouse">Son épouse</option>
        <option value="Son epoux">Son époux</option>
        <hr>
        <option value="Sa fille">Sa fille</option>
        <option value="Ses filles">Ses filles</option>
        <option value="Son fils">Son fils</option>
        <option value="Ses fils">Ses fils</option>
        <option value="Ses enfants">Ses enfants</option>
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
    </select><br>

    <div id="family-members-container">
        <label for="family-name">Nom et Prénom Famille et Proche :</label>
        <input type="text" id="family-name" name="family-name[]" required>
        <select name="family-link[]" class="family-name" required>
            <option value="Sa fille">Sa fille</option>
            <option value="Ses filles">Ses filles</option>
            <option value="Son fils">Son fils</option>
            <option value="Ses fils">Ses fils</option>
            <option value="Ses enfants">Ses enfants</option>
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
        </select><br>
    </div>
    <br>
    <div class="btn-add">
        <button type="button" onclick="addFamilyMember()">Ajouter un membre</button>
        <button type="button" onclick="removeFamilyMember()">Supprimer le dernier membre</button>
    </div>

    <label for="death-date">Date du décès :</label>
    <input type="date" id="death-date" name="death-date" required><br>

    <label for="age-death">Age :</label>
    <input type="text" id="age-death" name="age-death" required><br>

    <label for="ceremony-date">Date de la cérémonie :</label>
    <input type="date" id="ceremony-date" name="ceremony-date" required><br>

    <label for="location_ceremony">Lieu de la cérémonie :</label>
    <input type="text" id="location_ceremony" name="location_ceremony" required><br>

    <label for="hour_ceremony">heure de la cérémonie :</label>
    <input type="time" id="hour_ceremony" name="hour_ceremony" required><br>


    <label for="details">Détails :</label>
    <textarea id="details" name="details" rows="10" required></textarea><br>

    <button name="send" type="submit">Ajouter l'avis de décès</button>
</form>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>