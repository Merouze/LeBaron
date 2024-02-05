<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<?php
$idEstimate = isset($_GET['idEstimate']) ? $_GET['idEstimate'] : null;
// Exécuter la requête de recherche dans la base de données
$sqlDisplay = $dtLb->prepare("SELECT * FROM devis_obs WHERE id_estimate = :id_estimate");

$sqlDisplay->execute(['id_estimate' => $idEstimate]); // Utilisez un tableau associatif pour lier les paramètres

// Récupérer les résultats après l'exécution de la requête
$resultats = $sqlDisplay->fetchAll(PDO::FETCH_ASSOC);
// var_dump($resultats);
// Afficher les résultats uniquement si l'ID est spécifié et si des résultats sont trouvés
if ($idEstimate && count($resultats) > 0) {
    $resultat = $resultats[0]; // Prenez le premier résultat, car il devrait y en avoir un seul avec l'ID unique
    $estimateTraite = ($resultat['traite'] == 1) ? 'Oui' : 'Non';
    $conditionsAccept = ($resultat['accept_conditions'] == 1) ? 'Oui' : 'Non';
    $obituaryOnLine = ($resultat['obituary_online'] == 1) ? 'Oui' : 'Non';
    $obituaryInPress = ($resultat['obituary_press'] == 1) ? 'Oui' : 'Non';

    // Créer un objet DateTime pour la date de la demande
    $dateDemande = new DateTime($resultat['date_demande']);
    $dateBorn = new DateTime($resultat['date_born']);
    $dateDeath = new DateTime($resultat['date_death']);
    // Formater la date en jours/mois/année
    $dateFormatee = $dateDemande->format('d/m/Y');
    $dateBornformatee = $dateBorn->format('d/m/Y');
    $dateDeathformatee = $dateDeath->format('d/m/Y');
}

?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<h1 class="tittle grey text-align">Devis au nom de <span class="bold blue"><?= $resultat['lastname'] . ' ' . $resultat['firstname'] ?>.</span></h1>
<section class="infos-estimate">
    <div class="infos">
        <div class="border-check">
            <h2>Infos Cérémonies</h2>
            <ul>
                <?= '<li><span class="bold grey">Type de demande:</span> ' . $resultat['type_demande'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Présentation du corps :</span> ' . $resultat['presentation_corps'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Soin de conservation du corps :</span> ' . $resultat['body_care'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Type d\'obsèques :</span> ' . $resultat['type_funeral'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Type de cérémonie :</span> ' . $resultat['type_ceremony'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Type de sépulture :</span> ' . $resultat['type_sepulture'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Ville et/ou code postal de la cérémonie :</span> ' . $resultat['city_ceremony'] . '</li>'; ?>
            </ul>
        </div>
        <div class="border-check">
            <h2>Infos Défunt</h2>
            <ul>
                <?= '<li><span class="bold grey">Prénom du défunt :</span> ' . $resultat['firstname_defunt'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Nom défunt :</span> ' . $resultat['lastname_defunt'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Date de naissance du défunt :</span> ' . $dateBornformatee . '</li>'; ?>
                <?= '<li><span class="bold grey">Lieu de naissance du défunt :</span> ' . $resultat['location_born'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Code postale du lieu de naissance :</span> ' . $resultat['cp_born'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Date du décès :</span> ' . $dateDeathformatee . '</li>'; ?>
                <?= '<li><span class="bold grey">Lieu du décès:</span> ' . $resultat['location_death'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Ville du décès :</span> ' . $resultat['city_death'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Code postal :</span> ' . $resultat['city_death_cp'] . '</li>'; ?>
                <!-- <?= var_dump($resultat); ?> -->
            </ul>
        </div>
        <div class="border-check">
            <h2>Infos Client</h2>
            <ul>
                <?= '<li><span class="bold grey">Prénom:</span> ' . $resultat['firstname'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Nom :</span> ' . $resultat['lastname'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Lien avec le défunt :</span> ' . $resultat['link_defunt'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Ville :</span> ' . $resultat['city'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Numéro de téléphone :</span> ' . $resultat['phone'] . '</li>'; ?>
                <?= '<li><span class="bold grey">E-mail :</span> ' . $resultat['mail'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Horaire préférentiel pour être contacté :</span> ' . $resultat['hour_contact'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Conditions acceptés:</span> ' . $conditionsAccept . '</li>'; ?>
                <?= '<li><span class="bold grey">Devis traité :</span> ' . $estimateTraite . '</li>'; ?>
                <?= '<li><span class="bold grey">Parution avis de décès en ligne :</span> ' . $obituaryOnLine . '</li>'; ?>
                <?= '<li><span class="bold grey">Parution avis de décès en presse :</span> ' . $obituaryInPress . '</li>'; ?>
                <?= '<li><span class="bold grey">Message :</span> ' . $resultat['message'] . '</li>'; ?>
            </ul>
        </div>
    </div>
    <div>
        <div>
            <form class="form-estimate" method="post" action="_treatment/_treatment-estimate-obs.php">
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
                                    <td><input type="text" name="designation[]"></td>
                                    <td><input type="text" name="frais_avances[]"></td>
                                    <td><input type="text" name="prix_ht_10[]"></td>
                                    <td><input type="text" name="prix_ht_20[]"></td>
                                    <td class="addRow"><img src="../asset/img/icons8-add-30.png" alt="logo-add"></td>
                                </tr>

                            </tbody>
                            <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>Total HT</td>
                            <td><input type="text" id="total_ht" name="total_ht"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>

                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>TVA à 10%</td>
                            <td><input type="text" id="tva_10" name="tva_10"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>TVA à 20%</td>
                            <td><input type="text" id="tva_20" name="tva_20"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>Frais avancés</td>
                            <td><input type="text" id="total_frais_avances" name="total_frais_avances"></td>
                            <td style="visibility: hidden;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td style="visibility: hidden;">&nbsp;</td>
                            <td>TTC</td>
                            <td><input type="text" id="ttc" name="ttc"></td>
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
                    <input type="hidden" name="mail" value="<?= $resultat['mail']; ?>" required>
                    <input type="hidden" name="idEstimate" value="<?= $idEstimate; ?>" required>
                    <input type="hidden" name="estimateTraite" value="<?= $estimateTraite; ?>" required>
                    <label class="form-check-label"><span class="bold">Demande traité :</span>
                    <input type="checkbox" class="check-input" name="traited" value="1" <?= $resultat['traite'] == 1 ? 'checked' : ''; ?>>
                    </label>
                </div>
                <button type="submit" name="submitUpdateObs">Valider</button>
            </form>
        </div>
</section>
<script>
     document.addEventListener('DOMContentLoaded', function () {
            // Ajouter un écouteur d'événement au bouton d'ajout initial
            document.querySelector('.addRow').addEventListener('click', function () {
                addRow();
            });

            function addRow() {
                // Créez un nouvel élément de ligne
                let newRow = document.createElement('tr');

                // Ajoutez des cellules avec des champs d'entrée uniques
                newRow.innerHTML = `
                    <td><input type="text" name="designation[]"></td>
                    <td><input type="text" name="frais_avances[]"></td>
                    <td><input type="text" name="prix_ht_10[]"></td>
                    <td><input type="text" name="prix_ht_20[]"></td>
                    <td class="addRow"><img src="../asset/img/icons8-add-30.png" alt="logo-add"></td>
                    <td class="removeRow"><img src="../asset/img/icons8-delete-30.png" alt="logo-delete"></td>
                `;

                // Ajoutez la nouvelle ligne à la fin du corps du tableau
                document.getElementById('devisBody').appendChild(newRow);

                // Ajoutez un écouteur d'événement au nouveau bouton d'ajout de la ligne actuelle
                newRow.querySelector('.addRow').addEventListener('click', function () {
                    addRow();
                });

                // Ajoutez un écouteur d'événement au nouveau bouton de suppression de la ligne actuelle
                newRow.querySelector('.removeRow').addEventListener('click', function () {
                    removeRow(newRow);
                });

                // Ajoutez des écouteurs d'événements aux champs d'entrée de la nouvelle ligne
                addEventListenersToDynamicFields();
            }

            function removeRow(row) {
                // Vérifiez s'il y a plus d'une ligne avant de supprimer
                if (document.querySelectorAll('#devisBody tr').length > 1) {
                    // Supprimez la ligne spécifiée
                    document.getElementById('devisBody').removeChild(row);
                } else {
                    alert("Vous ne pouvez pas supprimer la dernière ligne.");
                }
            }

            // Ajoutez des écouteurs d'événements aux champs d'entrée existants
            addEventListenersToDynamicFields();

            function addEventListenersToDynamicFields() {
                const dynamicFields = document.querySelectorAll('[name^="designation["], [name^="frais_avances["], [name^="prix_ht_10["], [name^="prix_ht_20["]');

                dynamicFields.forEach(function (field) {
                    field.addEventListener('input', updateTotals);
                });
            }

        function updateTotals() {
            // Récupérer tous les champs dynamiques à nouveau après modification
            const dynamicFieldsUpdated = document.querySelectorAll('[name^="designation["]');

            // Initialiser les totaux
            let totalHt = 0;
            let tva10 = 0;
            let tva20 = 0;
            let totalAdvance = 0;
            let ttc = 0;

            // Calculer les totaux en parcourant tous les champs dynamiques
            dynamicFieldsUpdated.forEach(function (field) {
                const row = field.closest('tr');
                const designation = row.querySelector('[name^="designation["]').value.trim();
                const fraisAvances = parseFloat(row.querySelector('[name^="frais_avances["]').value) || 0;
                const prixHT10 = parseFloat(row.querySelector('[name^="prix_ht_10["]').value) || 0;
                const prixHT20 = parseFloat(row.querySelector('[name^="prix_ht_20["]').value) || 0;

                console.log('Row:', row);
                console.log('Designation:', designation);
                console.log('Frais Avances:', fraisAvances);
                console.log('Prix HT 10:', prixHT10);
                console.log('Prix HT 20:', prixHT20);

                totalHt += isNaN(prixHT10) ? 0 : prixHT10;
                totalHt += isNaN(prixHT20) ? 0 : prixHT20;
                tva10 += isNaN(prixHT10) ? 0 : (prixHT10 * 0.1);
                tva20 += isNaN(prixHT20) ? 0 : (prixHT20 * 0.2);
                totalAdvance += isNaN(fraisAvances) ? 0 : fraisAvances;

                console.log('Total HT:', totalHt);
                console.log('TVA 10%:', tva10);
                console.log('TVA 20%:', tva20);
                console.log('Total Advance:', totalAdvance);
            });

            // Calculer le TTC une fois tous les totaux mis à jour
            ttc = totalHt + tva10 + tva20 + totalAdvance;

            console.log('TTC:', ttc);

            // Mettre à jour les champs totaux dans le tableau
            document.getElementById('total_ht').value = totalHt.toFixed(2);
            document.getElementById('tva_10').value = tva10.toFixed(2);
            document.getElementById('tva_20').value = tva20.toFixed(2);
            document.getElementById('total_frais_avances').value = totalAdvance.toFixed(2);
            document.getElementById('ttc').value = ttc.toFixed(2);
        }
    });
</script>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>