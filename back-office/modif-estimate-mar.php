<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<?php
$idEstimate = isset($_GET['idEstimate']) ? $_GET['idEstimate'] : null;
// Exécuter la requête de recherche dans la base de données
$sqlDisplay = $dtLb->prepare("SELECT * FROM devis_mar WHERE id_estimate = :id_estimate");
$sqlDisplay->execute(['id_estimate' => $idEstimate]);
$resultats = $sqlDisplay->fetchAll(PDO::FETCH_ASSOC);
// var_dump($resultats);

// Afficher les résultats uniquement si l'ID est spécifié et si des résultats sont trouvés
if ($idEstimate && count($resultats) > 0) {
    $resultat = $resultats[0];
    $estimateTraite = ($resultat['traite'] == 1) ? 'Oui' : 'Non';
    $conditionsAccept = ($resultat['accept_conditions'] == 1) ? 'Oui' : 'Non';
    // Créer un objet DateTime pour la date de la demande
    $dateDemande = new DateTime($resultat['date_demande']);
    // Formater la date en jours/mois/année
    $dateFormatee = $dateDemande->format('d/m/Y');
}
?>

<?php
// Récupérer les résultats du devis traité

if (isset($_GET['idEstimate']) && $_GET['token']) {
    // Récupération de l'id_bill généré
    $idEstimate = $_GET['idEstimate'];

    // var_dump($_GET);
    // exit;
    $sqlRetrieveFacture = $dtLb->prepare("SELECT * FROM estimate_mar WHERE id_estimate = :id_estimate");
    $sqlRetrieveFacture->execute(['id_estimate' => $idEstimate]);
    $factureData = $sqlRetrieveFacture->fetch(PDO::FETCH_ASSOC);
    
    $id_estimate_mar = $factureData['id_estimate_mar'];
    // var_dump($factureData);
    // exit;
    /// Utilisez également $id_bill pour récupérer les données spécifiques de la table raw_bill
    $sqlRetrieveRawBill = $dtLb->prepare("SELECT * FROM raw_estimate WHERE id_estimate_mar = :id_estimate_mar");
    $sqlRetrieveRawBill->execute(['id_estimate_mar' => $id_estimate_mar]);
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
    // var_dump($reformattedRawBillData);
    // exit;
    // Récupération des données des champs statiques
    $designation = $reformattedRawBillData[0]['designation'] ?? array();
    $advance = $reformattedRawBillData[0]['frais_avances'] ?? array();
    $htPrice10 = $reformattedRawBillData[0]['prix_ht_10'] ?? array();
    $htPrice20 = $reformattedRawBillData[0]['prix_ht_20'] ?? array();
    // Utilisation des valeurs récupérées pour remplir les champs statiques
    $idEstimate = $factureData['id_estimate'] ?? '';
    $idEstimateObs = $factureData['id_estimate_obs'] ?? '';
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
<h1 class="tittle grey text-align">Modifier le devis au nom de <span class="bold blue"><?= $resultat['lastname'] . ' ' . $resultat['firstname'] ?>.</span></h1>
<section class="infos-estimate">
    <div class="infos">
    <div class="border-check">
            <h2>Infos Travaux</h2>
            <ul>
                <?= '<li ><span class="bold grey">Date de demande :</span> ' . $dateFormatee . '</li>'; ?>
                <?= '<li><span class="bold grey">Nature des travaux :</span> ' . $resultat['type_works'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Type de travaux :</span> ' . $resultat['type_monument'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Demande Entretien :</span> ' . $resultat['type_entretien'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Demande Fleurissement :</span> ' . $resultat['flowering'] . '</li>'; ?>
                <?= '<li><span class="bold grey"> Emplacement et n° de concession:</span> ' . $resultat['location_fall'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Nom du cimetière :</span> ' . $resultat['cimetary_name'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Ville et/ou code postal du cimetière :</span> ' . $resultat['location_cimetary'] . '</li>'; ?>
            </ul>
        </div>
        <div class="border-check">
            <h2>Infos Client</h2>
            <ul>
                <?= '<li><span class="bold grey">Prénom :</span> ' . $resultat['firstname'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Nom :</span> ' . $resultat['lastname'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Adress, :</span> ' . $resultat['adress'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Ville :</span> ' . $resultat['city'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Mail :</span> ' . $resultat['mail'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Message :</span> ' . $resultat['message_marble'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Horaire de contact :</span> ' . $resultat['hour_contact'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Conditions acceptés:</span> ' . $conditionsAccept . '</li>'; ?>
                <?= '<li><span class="bold grey">Devis traité:</span> ' . $estimateTraite . '</li>'; ?>
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
                        <input type="hidden" name="idEstimateMar" value="<?= $id_estimate_mar; ?>" required>
                        <input type="hidden" name="mail" value="<?= $resultat['mail']; ?>" required>
                        <input type="hidden" name="firstname" value="<?= $resultat['firstname']; ?>" required>
                        <input type="hidden" name="lastname" value="<?= $resultat['lastname']; ?>" required>
                        <input type="hidden" name="mail" value="<?= $resultat['mail']; ?>" required>
                        <input type="hidden" name="adress" value="<?= $resultat['adress']; ?>" required>
                        <input type="hidden" name="city" value="<?= $resultat['city']; ?>" required>
                        <button type="submit" formtarget="_blank" name="submitPDF">Visualiser PDF</button>
                        <br>
                        <button type="submit" name="submitUpdateEstimateMar">Enregistrer la modification</button>
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