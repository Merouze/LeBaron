<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>

<?php
$idEstimate = isset($_GET['idEstimate']) ? $_GET['idEstimate'] : null;
// var_dump($idEstimate);
// Exécuter la requête de recherche dans la base de données
$sqlDisplay = $dtLb->prepare("SELECT * FROM devis_prevoyance WHERE id_estimate = :id_estimate");

$sqlDisplay->execute(['id_estimate' => $idEstimate]); // Utilisez un tableau associatif pour lier les paramètres

// Récupérer les résultats après l'exécution de la requête
$resultats = $sqlDisplay->fetchAll(PDO::FETCH_ASSOC);

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
    $dateBornFormatee = $dateBorn->format('d/m/Y');
}
?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- section header title -->

<section class="infos-estimate">
    <div class="border-check">
        <ul class="border-check">
            <h3>Infos client</h3>
            <?= '<li><span class="bold">Nom :</span> ' . $resultat['prenom'] . ' ' . $resultat['nom'] . '</li>'; ?>
            <?= '<li><span class="bold">Situation familiale :</span> ' . $resultat['situation_familiale'] . '</li>'; ?>
            <?= '<li><span class="bold">Date de naissance :</span> ' . $dateBornFormatee . '</li>'; ?>
            <?= '<li><span class="bold">Profession :</span> ' . $resultat['profession'] . '</li>'; ?>
            <?= '<li><span class="bold">Ville :</span> ' . $resultat['ville'] . '</li>'; ?>
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
    <div>
        <form class="form-estimate" method="post" action="_treatment/_treatment-estimate-prev.php">
            <div>
                <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
                <input type="hidden" name="idEstimate" value="<?= $idEstimate; ?>" required>
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
                            <tr id="row1">
                                <td><input type="text" name="designation"></td>
                                <td><input type="text" name="frais_avances"></td>
                                <td><input type="text" name="prix_ht_10"></td>
                                <td><input type="text" name="prix_ht_20"></td>
                                <td class="addRow"><img src="../asset/img/icons8-add-30.png" alt="logo-add"></td>
                            </tr>

                        </tbody>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>Total HT</td>
                            <td><input type="text" name="total_ht"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>TVA à 10%</td>
                            <td><input type="text" name="tva_10"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>TVA à 20%</td>
                            <td><input type="text" name="tva_20"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>Frais avancés</td>
                            <td><input type="text" name="total_frais_avances"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>TTC</td>
                            <td><input type="text" name="ttc"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                    </table>
                </div>
                <br>
                <br>
                <label class="bold" for="commentaire">Commentaire :</label>
                <textarea rows="6" id="commentaire" name="commentaire"></textarea>
            </div>
            <button type="submit" formtarget="_blank" name="submitPDF">Voir la version PDF</button>
        </form>
        <form class="form-estimate" method="post" action="_treatment/_treatment-check-estimate.php">
            <div>
                <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
                <input type="hidden" name="idEstimate" value="<?= $idEstimate; ?>" required>
                <input type="hidden" name="estimateTraite" value="<?= $estimateTraite; ?>" required>
                <input type="hidden" name="email" value="<?= $resultat['email']; ?>" required>
                <input type="hidden" name="name" value="<?= $resultat['nom']; ?>" required>
                <label class="form-check-label"><span class="bold">
                        Demande traité :</span>
                    <input type="checkbox" class="check-input" name="traited" value="1" <?= $resultat['traite'] == 1 ? 'checked' : ''; ?>>
                </label>
            </div>
            <button type="submit" name="submitUpdatePrev">Valider</button>
        </form>
    </div>
</section>

<script>
    // *************************************
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.addRow').addEventListener('click', function() {
            addRow();
        });

        function addRow() {
            // Créez un nouvel élément de ligne
            let newRow = document.createElement('tr');

            // Obtenez le nombre actuel de lignes
            let rowCount = document.querySelectorAll('#devisBody tr').length;

            // Ajoutez des cellules avec des champs d'entrée uniques
            newRow.innerHTML = '<td><input type="text" name="dynamicFields[' + rowCount + '][designation]"></td>' +
                '<td><input type="text" name="dynamicFields[' + rowCount + '][frais_avances]"></td>' +
                '<td><input type="text" name="dynamicFields[' + rowCount + '][prix_ht_10]"></td>' +
                '<td><input type="text" name="dynamicFields[' + rowCount + '][prix_ht_20]"></td>' +
                '<td class="addRow"><img src="../asset/img/icons8-add-30.png" alt="logo-add"></td>';

            // Ajoutez la nouvelle ligne à la fin du corps du tableau
            document.getElementById('devisBody').appendChild(newRow);

            // Ajoutez un écouteur d'événement au nouveau bouton
            newRow.querySelector('.addRow').addEventListener('click', function() {
                addRow();
            });
        }
    });


    // document.addEventListener('DOMContentLoaded', function() {
    //     document.querySelector('.addRow').addEventListener('click', function() {
    //         addRow();
    //     });

    //     function addRow() {
    //         // Obtenez le nombre actuel de lignes
    //         let rowCount = document.getElementById('devisBody').rows.length;

    //         // Créez un nouvel élément de ligne
    //         let newRow = document.createElement('tr');

    //         // Ajoutez des cellules avec des champs d'entrée uniques
    //         newRow.innerHTML = '<td><input type="text" name="designation' + rowCount + '"></td>' +
    //             '<td><input type="text" name="frais_avances' + rowCount + '"></td>' +
    //             '<td><input type="text" name="prix_ht' + rowCount + '"></td>' +
    //             '<td class="addRow"><img src="../asset/img/icons8-add-30.png" alt="logo-add"></td>';

    //         // Ajoutez la nouvelle ligne à la fin du corps du tableau
    //         document.getElementById('devisBody').appendChild(newRow);

    //         // Ajoutez un écouteur d'événement au nouveau bouton
    //         newRow.querySelector('.addRow').addEventListener('click', function() {
    //             addRow();
    //         });
    //     }
    // });
</script>
<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>