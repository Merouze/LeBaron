<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<?php

$idEstimate = isset($_GET['idEstimate']) ? $_GET['idEstimate'] : null;
// var_dump($idEstimate);

// Exécuter la requête de recherche dans la base de données
$sqlDisplay = $dtLb->prepare("SELECT * FROM devis_mar WHERE id_estimate = :id_estimate");
$sqlDisplay->execute(['id_estimate' => $idEstimate]);
$resultats = $sqlDisplay->fetchAll(PDO::FETCH_ASSOC);
// Afficher les résultats uniquement si l'ID est spécifié et si des résultats sont trouvés
if ($idEstimate && count($resultats) > 0) {
    $resultat = $resultats[0]; // Prenez le premier résultat, car il devrait y en avoir un seul avec l'ID unique
    $estimateTraite = ($resultat['traite'] == 1) ? 'Oui' : 'Non';
    $conditionsAccept = ($resultat['accept_conditions'] == 1) ? 'Oui' : 'Non';
    // Créer un objet DateTime pour la date de la demande
    $dateDemande = new DateTime($resultat['date_demande']);
    // Formater la date en jours/mois/année
    $dateFormatee = $dateDemande->format('d/m/Y');
}
?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<h1 class="tittle grey text-align">Devis au nom de <span class="bold blue"><?= $resultat['lastname'] . ' ' . $resultat['firstname']?>.</span></h1>
<section class="infos-estimate">
    <div class="infos">
        <div class="border-check">
            <h2>Infos Travaux</h2>
            <ul>
                <?= '<li ><span class="bold grey">Date de demande :</span> ' . $dateFormatee . '</li>'; ?>
                <?= '<li><span class="bold grey">Nature des travaux :</span> ' . $resultat['type_works'] . '</li>'; ?>
                <?= '<li><span class="bold grey">Type de monument :</span> ' . $resultat['type_monument'] . '</li>'; ?>
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
        <form class="form-estimate" method="post" action="_treatment/_treatment-estimate-mar.php">
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
                                <td>
                                    <ul class="icon-estimate">
                                        <li>
                                            <img class="addRow" src="../asset/img/icons8-add-30.png" alt="logo-add">
                                        </li>
                                    </ul>
                                </td>
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
            <button type="submit" formtarget="_blank" name="submitPDF">Générer le pdf</button>
        </form>
        <form class="form-estimate" method="post" action="_treatment/_treatment-check-estimate.php">
            <div>
                <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
                <input type="hidden" name="idEstimate" value="<?= $idEstimate; ?>" required>
                <input type="hidden" name="estimateTraite" value="<?= $resultat['traite']; ?>" required>
                <input type="hidden" name="email" value="<?= $resultat['mail']; ?>" required>
                <input type="hidden" name="name" value="<?= $resultat['lastname']; ?>" required>
                
            </div>
            <button type="submit" name="submitUpdateMar">Valider et envoyer par mail</button>
        </form>
        <form class="form-estimate" method="post" action="_treatment/_treatment-check-estimate.php">
            <div>
                <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
                <input type="hidden" name="idEstimate" value="<?= $idEstimate; ?>" required>
                <input type="hidden" name="estimateTraite" value="<?= $estimateTraite; ?>" required>
            </div>
            <button type="submit" name="submitTraiteMar">Valider sans envoyer par mail</button>
        </form>
    </div>
</section>

<!-- // ----- # FOOTER # ----- // -->
<?php include './_includes/_footer.php' ?>

<script src=".././asset/Js/script.js"></script>
<script src=".././asset/Js/fonctions.js"></script>
</body>
</html>