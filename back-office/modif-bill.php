<!-- // ----- # HEAD # ----- // -->
<?php include '../back-office/_includes/_head.php' ?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<!-- request for get values from bill -->
<?php
if (isset($_GET['idBill'])) {

    // Récupération de l'id_bill généré
    $id_bill = $_GET['idBill'];

    // var_dump($_GET);
    // exit;
    // Utilisez directement $id_bill pour récupérer les données de la facture principale
    $sqlRetrieveFacture = $dtLb->prepare("SELECT * FROM factures WHERE id_bill = :id_bill");
    $sqlRetrieveFacture->execute(['id_bill' => $id_bill]);
    $factureData = $sqlRetrieveFacture->fetch(PDO::FETCH_ASSOC);

    /// Utilisez également $id_bill pour récupérer les données spécifiques de la table raw_bill
    $sqlRetrieveRawBill = $dtLb->prepare("SELECT * FROM raw_bill WHERE id_bill = :id_bill");
    $sqlRetrieveRawBill->execute(['id_bill' => $id_bill]);
    $rawBillData = $sqlRetrieveRawBill->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($factureData);
    // exit;

    // Reformatez les données de raw_bill si nécessaire
    $reformattedRawBillData = [];

    foreach ($rawBillData as $row) {
        $reformattedRawBillData[] = [
            'designation' => $row['designation'],
            'frais_avances' => $row['frais_avances'],
            'prix_ht_10' => $row['prix_ht_10'],
            'prix_ht_20' => $row['prix_ht_20'],
        ];
    }
    $reformattedRawBillData = array_reverse($reformattedRawBillData);
    // Récupération de l'id_bill s'il existe déjà
    $existingIdBill = $factureData['id_bill'];
    // var_dump($reformattedRawBillData);
    // exit;
    // Récupération des données des champs statiques
    $designation = $reformattedRawBillData[0]['designation'] ?? array();
    $advance = $reformattedRawBillData[0]['frais_avances'] ?? array();
    $htPrice10 = $reformattedRawBillData[0]['prix_ht_10'] ?? array();
    $htPrice20 = $reformattedRawBillData[0]['prix_ht_20'] ?? array();
    // Utilisation des valeurs récupérées pour remplir les champs statiques
    $idBill = $factureData['id_bill'] ?? '';
    $name = $factureData['name'] ?? '';
    $adress = $factureData['adress'] ?? '';
    $cP = $factureData['cP'] ?? '';
    $city = $factureData['city'] ?? '';
    $email = $factureData['email'] ?? '';
    $totalHt = $factureData['total_ht'] ?? '';
    $tva10 = $factureData['tva_10'] ?? '';
    $tva20 = $factureData['tva_20'] ?? '';
    $totalAdvance = $factureData['total_frais_avances'] ?? '';
    $ttc = $factureData['ttc'] ?? '';
    $commentaire = $factureData['message'] ?? '';
    $is_Sent = $factureData['is_sent'] ?? '';
    setlocale(LC_TIME, 'fr_FR.utf8');
    $currentDate = new DateTime();
    $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
    $formattedDate = $dateFormatter->format($currentDate->getTimestamp());
}
?>
<!-- section header title -->
<section class="header-pages">
</section>
<div class="display-flex">
    <h1 class="mb50 display grey text-align padding-title">Modifier la&nbsp;<span class="blue">facture</span></h1>
    <!-- <?= var_dump($reformattedRawBillData); ?> -->
    <?php
    // Affichage des notifications ou erreurs
    if (isset($_SESSION['notif']) && is_array($_SESSION['notif'])) {
        echo '<span class="mb50 display-flex-center ' . $_SESSION['notif']['type'] . '">' . $_SESSION['notif']['message'] . '</span>';
        unset($_SESSION['notif']);
    } elseif (isset($_SESSION['error'])) {
        echo '<span class="mb50 display-flex-center error">' . $_SESSION['error'] . '</span>';
        unset($_SESSION['error']);
    }
    ?>
</div>

<section class="infos-estimate">

    <div>
        <form class="form-estimate" method="post" action="_treatment/_treatment-modif-bill.php">
            <div>
                <label class="bold" for="Name">Nom et Prénom :</label>
                <input type="text" id="name" name="name" value="<?= $name ?>" required>

                <label class="bold" for="adress">Adresse :</label>
                <input type="text" id="adress" name="adress" value="<?= $adress ?>" required>

                <label class="bold" for="cP">Code Postal :</label>
                <input type="text" id="cP" name="cP" value="<?= $cP ?>" required>

                <label class="bold" for="city">Ville :</label>
                <input type="text" id="city" name="city" value="<?= $city ?>" required>

                <label class="bold" for="email">E-mail :</label>
                <input type="email" id="email" name="email" value="<?= $email ?>" required>
                <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
                <input type="hidden" name="id_bill" value="<?= $idBill ?>">
                <div>
                    <table id="devisTable">
                        <thead>
                            <tr>
                                <th>Désignation</th>
                                <th>Frais avancés</th>
                                <th>Prix H.T. à 10%</th>
                                <th>Prix H.T. à 20%</th>
                                <th>Ajouter une ligne</th>
                            </tr>
                        </thead>
                 
                        <tbody id="devisBody">
        <?php foreach ($reformattedRawBillData as $row) : ?>
            <tr>
                <td><input type="text" name="designation[]" value="<?= $row['designation'] ?>"></td>
                <td><input type="text" name="frais_avances[]" value="<?= $row['frais_avances'] ?>"></td>
                <td><input type="text" name="prix_ht_10[]" value="<?= $row['prix_ht_10'] ?>"></td>
                <td><input type="text" name="prix_ht_20[]" value="<?= $row['prix_ht_20'] ?>"></td>
                <td>
                    <ul class="icon-estimate">
                        <li><img class="addRow" src="../asset/img/icons8-add-30.png" alt="logo-add"></li>
                        <li><img class="moveUp" src="../asset/img/icons8-up-30.png" alt="icons-up"></li>
                        <li><img class="moveDown" src="../asset/img/icons8-down-30.png" alt="icons-down"></li>
                        <li><img class="removeRow" src="../asset/img/icons8-delete-30.png" alt="logo-delete"></li>
                    </ul>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>Total HT</td>
                            <td><input type="text" id="total_ht" name="total_ht" value="<?= $totalHt ?>"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>TVA à 10%</td>
                            <td><input type="text" id="tva_10" name="tva_10" value="<?= $tva10 ?>"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>TVA à 20%</td>
                            <td><input type="text" id="tva_20" name="tva_20" value="<?= $tva20 ?>"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>Frais avancés</td>
                            <td><input type="text" id="total_frais_avances" name="total_frais_avances" value="<?= $totalAdvance ?>"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>TTC</td>
                            <td><input type="text" id="ttc" name="ttc" value="<?= $ttc ?>"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                    </table>
                </div>
                <br>
                <br>
                <label class="bold" for="commentaire">Commentaire :</label>
                <textarea rows="6" id="commentaire" name="commentaire"><?= $commentaire ?></textarea>
            </div>
            <button type="submit" formtarget="_blank" name="submitPDF">Visualiser PDF</button>
            <br>
            <button type="submit" name="submitUpdateBill">Enregistrer</button>
        </form>
    </div>
</section>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>

<script src=".././asset/Js/bill.js"></script>
<!-- <script src=".././asset/Js/script.js"></script> -->
<script src=".././asset/Js/fonctions.js"></script>
</body>

</html>