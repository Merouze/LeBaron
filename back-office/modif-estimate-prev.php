<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<?php
$idEstimate = isset($_GET['idEstimate']) ? $_GET['idEstimate'] : null;
// Exécuter la requête de recherche dans la base de données
$sqlDisplay = $dtLb->prepare("SELECT * FROM devis_prevoyance WHERE id_estimate = :id_estimate");

$sqlDisplay->execute(['id_estimate' => $idEstimate]);
// Récupérer les résultats de la demande de devis après l'exécution de la requête
$resultats = $sqlDisplay->fetchAll(PDO::FETCH_ASSOC);
// var_dump($resultats);
// Afficher les résultats uniquement si l'ID est spécifié et si des résultats sont trouvés
if ($idEstimate && count($resultats) > 0) {
    $resultat = $resultats[0]; // Prenez le premier résultat, car il devrait y en avoir un seul avec l'ID unique
    $estimateTraite = ($resultat['traite'] == 1) ? 'Oui' : 'Non';
    $conditionsAccept = ($resultat['accept_conditions'] == 1) ? 'Oui' : 'Non';
    // Créer un objet DateTime pour la date de la demande
    $dateDemande = new DateTime($resultat['date_demande']);
    $dateBorn = new DateTime($resultat['date_naissance']);
    // Formater la date en jours/mois/année
    $dateFormatee = $dateDemande->format('d/m/Y');
    $dateBornformatee = $dateBorn->format('d/m/Y');
}
?>

<?php
// Récupérer les résultats du devis traité

if (isset($_GET['idEstimate']) && $_GET['token']) {
    // Récupération de l'id_bill généré
    $idEstimate = $_GET['idEstimate'];

    // var_dump($_GET);
    // exit;
    // Utilisez directement $id_bill pour récupérer les données de la facture principale
    $sqlRetrieveFacture = $dtLb->prepare("SELECT * FROM estimate_prev WHERE id_estimate = :id_estimate");
    $sqlRetrieveFacture->execute(['id_estimate' => $idEstimate]);
    $factureData = $sqlRetrieveFacture->fetch(PDO::FETCH_ASSOC);
    $idEstimatePrev = $factureData['id_estimate_prev'];


    // var_dump($idEstimatePrev);


    $sqlRetrieveRawBill = $dtLb->prepare("SELECT * FROM raw_estimate WHERE id_estimate_prev = :id_estimate_prev");
    $sqlRetrieveRawBill->execute(['id_estimate_prev' => $idEstimatePrev]);
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
    // $existingIdBill = $factureData['id_estimate'];
    // var_dump($rawBillData);
    // exit;
    // Récupération des données des champs statiques
    $designation = $reformattedRawBillData[0]['designation'] ?? array();
    $advance = $reformattedRawBillData[0]['frais_avances'] ?? array();
    $htPrice10 = $reformattedRawBillData[0]['prix_ht_10'] ?? array();
    $htPrice20 = $reformattedRawBillData[0]['prix_ht_20'] ?? array();
    // Utilisation des valeurs récupérées pour remplir les champs statiques
    $idEstimate = $factureData['id_estimate'] ?? '';
    $idEstimatePrev = $factureData['id_estimate_prev'] ?? '';
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
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<h1 class="tittle grey text-align">Modifier le devis au nom de <span class="bold blue"><?= $factureData['firstname'] . ' ' . $factureData['name'] ?>.</span></h1>
<section class="infos-estimate">
    <div class="infos">
        <div class="border-check">
            <ul class="border-check">
                <h3>Infos client</h3>
                <?= '<li><span class="bold">Nom :</span> ' . $resultat['prenom'] . ' ' . $resultat['nom'] . '</li>'; ?>
                <?= '<li><span class="bold">Situation familiale :</span> ' . $resultat['situation_familiale'] . '</li>'; ?>
                <?= '<li><span class="bold">Date de naissance :</span> ' . $dateBornformatee . '</li>'; ?>
                <?= '<li><span class="bold">Profession :</span> ' . $resultat['profession'] . '</li>'; ?>
                <?= '<li><span class="bold">Adresse :</span> ' . $resultat['adress'] . '</li>'; ?>
                <?= '<li><span class="bold">Ville et code postale :</span> ' . $resultat['ville'] . '</li>'; ?>
                <?= '<li><span class="bold">Téléphone :</span> ' . $resultat['tel'] . '</li>'; ?>
                <?= '<li><span class="bold">Email :</span> ' . $resultat['email'] . '</li>'; ?>
                <?= '<li><span class="bold">Horaire de contact :</span> ' . $resultat['horaire_contact'] . '</li>'; ?>
                <?= '<li><span class="bold">Message :</span> ' . $resultat['message'] . '</li>'; ?>
            </ul>
            <ul class="border-check">
                <h3>Infos demande</h3>
                <?= '<li><span class="bold">Type de demande :</span> ' . $resultat['type_demande'] . '</li>'; ?>
                <?= '<li><span class="bold">Type de contrat :</span> ' . $resultat['type_contrat'] . '</li>'; ?>
                <?= '<li><span class="bold">Accepte les conditions :</span> ' . $conditionsAccept . '</li>'; ?>
                <?= '<li><span class="bold">Devis traité :</span> ' . $estimateTraite . '</li>'; ?>
                <?= '<li><span class="bold">iD devis :</span> ' . $idEstimate . '</li>'; ?>
            </ul>
        </div>
    </div>
    <div>
        <div>
            <section class="infos-estimate">

                <div>
                    <form class="form-estimate" method="post" action="_treatment/_treatment_modify_estimate.php">
                        <div>
                            <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
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
                            <label class="bold" for="commentaire">Commentaire :</label>
                            <textarea rows="6" id="commentaire" name="commentaire"><?= $commentaire ?></textarea>
                        </div>
                        <input type="hidden" name="idEstimate" value="<?= $idEstimate; ?>" required>
                        <input type="hidden" name="id_estimate_prev" value="<?= $idEstimatePrev; ?>" required>
                        <input type="hidden" name="mail" value="<?= $resultat['email']; ?>" required>
                        <input type="hidden" name="firstname" value="<?= $resultat['prenom']; ?>" required>
                        <input type="hidden" name="lastname" value="<?= $resultat['nom']; ?>" required>
                        <input type="hidden" name="mail" value="<?= $resultat['email']; ?>" required>
                        <input type="hidden" name="adress" value="<?= $resultat['adress']; ?>" required>
                        <input type="hidden" name="city" value="<?= $resultat['ville']; ?>" required>
                        <button type="submit" formtarget="_blank" name="submitPDF">Visualiser PDF</button>
                        <br>
                        <button type="submit" name="submitUpdateEstimatePrev">Enregistrer la modification</button>
                    </form>
                </div>
            </section>

        </div>
</section>
<!-- <?= var_dump($factureData); ?> -->
<!-- <?= var_dump($rawBillData); ?> -->

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>

<script src=".././asset/Js/bill.js"></script>
<script src=".././asset/Js/script.js"></script>
<script src=".././asset/Js/fonctions.js"></script>
</body>

</html>