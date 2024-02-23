<?php
require "../../back-office/_includes/_dbCo.php";
session_start();

//****************************** Treatment create pdf for billing

// Vérifiez si le formulaire a été soumis
if (isset($_POST['submitPDF']) && isset($_POST['token'])) {
    $token = strip_tags($_POST['token']);

    if ($token === $_SESSION['myToken']) {

        $designations = isset($_POST["designation"]) ? $_POST["designation"] : [];
        $advances = isset($_POST["frais_avances"]) ? $_POST["frais_avances"] : [];
        $htPrices10 = isset($_POST["prix_ht_10"]) ? $_POST["prix_ht_10"] : [];
        $htPrices20 = isset($_POST["prix_ht_20"]) ? $_POST["prix_ht_20"] : [];
        $totalHt = strip_tags($_POST["total_ht"]);
        $tva10 = strip_tags($_POST["tva_10"]);
        $tva20 = strip_tags($_POST["tva_20"]);
        $totalAdvance = strip_tags($_POST["total_frais_avances"]);
        $ttc = strip_tags($_POST["ttc"]);
        $commentaire = strip_tags($_POST["commentaire"]);
        $idEstimate = strip_tags($_POST["idEstimate"]);
        $firstname = strip_tags($_POST["firstname"]);
        $lastname = strip_tags($_POST["lastname"]);
        $adress = strip_tags($_POST["adress"]);
        $city = strip_tags($_POST["city"]);

        // Récupérez les données des champs dynamiques
        $dynamicFields = [];

        // Obtenez le nombre total de champs (peu importe le type)
        $numFields = count($_POST['designation']);

        // Itérez sur chaque champ en utilisant son indice
        for ($i = 0; $i < $numFields; $i++) {
            $dynamicFields[] = [
                'designation' => isset($_POST["designation"][$i]) ? strip_tags($_POST["designation"][$i]) : '',
                'frais_avances' => isset($_POST["frais_avances"][$i]) ? strip_tags($_POST["frais_avances"][$i]) : '',
                'prix_ht_10' => isset($_POST["prix_ht_10"][$i]) ? strip_tags($_POST["prix_ht_10"][$i]) : '',
                'prix_ht_20' => isset($_POST["prix_ht_20"][$i]) ? strip_tags($_POST["prix_ht_20"][$i]) : '',
            ];
        }

        // Traitez maintenant $dynamicFields comme avant
        foreach ($dynamicFields as $key => $field) {
            $dynamicFields[$key] = [
                'designation' => strip_tags($field['designation']),
                'frais_avances' => strip_tags($field['frais_avances']),
                'prix_ht_10' => strip_tags($field['prix_ht_10']),
                'prix_ht_20' => strip_tags($field['prix_ht_20']),
            ];
        }

        setlocale(LC_TIME, 'fr_FR.utf8');
        $currentDate = new DateTime();
        $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $formattedDate = $dateFormatter->format($currentDate->getTimestamp());
        // var_dump($_POST);
        // exit;

        // Instanciez mPDF
        $mpdf = new \Mpdf\Mpdf([
            'margin_top' => 0,
            'margin_bottom' => 0,
            'default_font_size' => 10,
        ]);

        // Génération du contenu stylisé du PDF pour les condoléances
        $htmlCondolences = '
<style>
.blue {
    color: #039DB5;
}
.grey {
    color: #353031;
}
.bold {
    font-weight: bold;
}
.align-right {
    text-align: right;
    margin-right: 10mm;
}
.align-left {
    text-align: left;
}
.align-center {
    text-align: center;
}
.siret {
    font-size: 10px;
}
.footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    text-align: center;
}
.width {
    width: 100%;
}
.hidden {
    display: none;
}
.border {
    border: 2px solid #039DB5;
}
.border-in {
    border: 1px solid #333;
}
</style>

<div>
<img src="../../asset/img/logo-LB.png" alt="logo">
<div class="align-right">
        <p class="bold">' . $firstname . ' ' . $lastname . '</p>
        <p>' . $adress . '</p>
        <p>' . $city . '</p>
    </div>
</div>
<div class="text-align">
<p>Devis n° ... à Vieux le ' . $formattedDate . '.</p>
</div>
';

        // Créez le HTML à convertir en PDF
        $htmlDevis = "
    <table class='border width'>
        <thead>
            <tr>
                <th class=' align-left'>Désignation</th>
                <th class=' align-right'>Frais avancés</th>
                <th class=' align-right'>Prix H.T. à 10%</th>
                <th class=' align-lerightft'>Prix H.T. à 20%</th>
            </tr>
            <tr>
                <td colspan='4'><hr></td>
            </tr>
            <tr>
               <td colspan='4'></td>
            </tr>
        </thead>
        <tbody>";

        foreach ($dynamicFields as $field) {
            $htmlDevis .= "
                    <tr>
                        <td>{$field['designation']}</td>
                        <td class='align-right'>" . ($field['frais_avances'] != '' ? $field['frais_avances'] : 0) . "</td>
                        <td class='align-right'>" . ($field['prix_ht_10'] != '' ? $field['prix_ht_10'] : 0) . "</td>
                        <td class='align-right'>" . ($field['prix_ht_20'] != '' ? $field['prix_ht_20'] : 0) . "</td>
                    </tr>";
        }

        $htmlDevis .= "
        </tbody>
        <tfoot>
        <tr>
            <td colspan='4'><hr></td>
        </tr>
            <tr class='border'>
                <td colspan='2'></td>
                <td class='align-left'>Total HT :</td>
                <td class='align-right'>$totalHt</td>
            </tr>
            <tr>
                <td colspan='2'></td>
                <td class='align-left'>TVA à 10% :</td>
                <td class='align-right'>$tva10</td>
            </tr>
            <tr>
                <td colspan='2'></td>
                <td class='align-left'>TVA à 20% :</td>
                <td class='align-right'>$tva20</td>
            </tr>
            <tr>
                <td colspan='2'></td>
                <td class='align-left'>Frais avancés global :</td>
                <td class='align-right'>$totalAdvance</td>
            </tr>
        
            <tr>
                <td colspan='2'></td>
                <td class='align-left'>Prix TTC :</td>
                <td class='align-right'>$ttc</td>
            </tr>
            <tr>
                <td colspan='4'><hr></td>
            </tr>
            <tr>
                <td>$commentaire</td>
            </tr>
        </tfoot>
    </table><div><p>Merci de votre confiance et n'hésitez pas à revenir
    vers nous.</p>
    </div>";

        $htmlFooter = '<div class="footer">
    
            <h2>Pompes Funèbres <span class="blue">Le Baron.</span></h2>
            <p>TOUS TRAVAUX FUNERAIRES - CAVEAUX - MONUMENTS</p>
            <p>GRAVURE - ENTRETIEN DES SEPULTURES - ARTICLES FUNERAIRES</p>
            <p>2 Rte de Maltot 14930 Vieux, 02.31.26.91.75 7j/7 et 24h/24.</p>
            <p class="siret grey">N° Habilitation : 22 14 0043. Siret : 380 431 601 00018 - APE 9603Z.</p>
            </div>';

        // Ajoutez le contenu du PDF
        $mpdf->WriteHTML($htmlCondolences . $htmlDevis . $htmlFooter);

        // Nom du fichier PDF de sortie
        $pdfPath = './facture.pdf';

        // Affichez le PDF dans le navigateur avec la possibilité de télécharger
        $mpdf->Output($pdfPath, \Mpdf\Output\Destination::INLINE);

        // Fin du script pour éviter tout autre rendu indésirable
        exit;
    }
};

//****************************** Treatment add billing

if (isset($_POST['submitAddBill']) && isset($_POST['token'])) {
    $token = strip_tags($_POST['token']);
    // var_dump($_POST);
    // exit;
    if ($token === $_SESSION['myToken']) {

        $designations = isset($_POST["designation"]) ? $_POST["designation"] : [];
        $advances = isset($_POST["frais_avances"]) ? $_POST["frais_avances"] : [];
        $htPrices10 = isset($_POST["prix_ht_10"]) ? $_POST["prix_ht_10"] : [];
        $htPrices20 = isset($_POST["prix_ht_20"]) ? $_POST["prix_ht_20"] : [];
        $firstname = strip_tags($_POST["firstname"]);
        $lastname = strip_tags($_POST["lastname"]);
        $adress = strip_tags($_POST["adress"]);
        $city = strip_tags($_POST["city"]);
        $email = strip_tags($_POST["mail"]);
        $totalHt = strip_tags($_POST["total_ht"]);
        $tva10 = strip_tags($_POST["tva_10"]);
        $tva20 = strip_tags($_POST["tva_20"]);
        $totalAdvance = strip_tags($_POST["total_frais_avances"]);
        $ttc = strip_tags($_POST["ttc"]);
        $message = strip_tags($_POST["commentaire"]);
        $idEstimate = strip_tags($_POST["idEstimate"]);
        $traite = 1;
// var_dump($_POST);
// exit;
        // Requête SQL pour mettre à jour les données générales
        $sqlUpdate = $dtLb->prepare(
            "UPDATE devis_obs SET 
        traite = :traite
        WHERE id_estimate = :id_estimate"
        );

        // Exécution de la requête pour les données générales
        $sqlUpdate->execute([
            'traite' => $traite,
            'id_estimate' => $idEstimate,
        ]);

        // Requête SQL pour les données générales
        $sqlGeneral = $dtLb->prepare("INSERT INTO estimate_obs (name, lastname, adress, city, email, total_ht, tva_10, tva_20, total_frais_avances, ttc, message, id_estimate) VALUES (:name, :lastname, :adress, :city, :email, :total_ht, :tva_10, :tva_20, :total_frais_avances, :ttc, :message, :id_estimate)");

        // Exécution de la requête pour les données générales
        $sqlGeneral->execute([
            'name' => $firstname,
            'lastname' => $lastname,
            'adress' => $adress,
            'city' => $city,
            'email' => $email,
            'total_ht' => $totalHt,
            'tva_10' => $tva10,
            'tva_20' => $tva20,
            'total_frais_avances' => $totalAdvance,
            'ttc' => $ttc,
            'message' => $message,
            'id_estimate' => $idEstimate,
        ]);

        // Récupération de l'id_bill généré
        $idEstimateObs = $dtLb->lastInsertId();

        // Requête SQL pour les lignes spécifiques
        $sqlSpecific = $dtLb->prepare("INSERT INTO raw_estimate (id_estimate_obs, designation, frais_avances, prix_ht_10, prix_ht_20) VALUES (:id_estimate_obs, :designation, :frais_avances, :prix_ht_10, :prix_ht_20)");

        // ...
        // var_dump($id_bill);
        // exit;

        foreach ($designations as $key => $designation) {
            // Exécution de la requête pour chaque ligne
            $sqlSpecific->execute([
                'id_estimate_obs' => $idEstimateObs,
                'designation' => $designation,
                'frais_avances' => $advances[$key],
                'prix_ht_10' => $htPrices10[$key],
                'prix_ht_20' => $htPrices20[$key],
            ]);
            // Ajouter une notification de succès
            $_SESSION['notif'] = [
                'type' => 'success', // ou tout autre style CSS que vous utilisez pour les notifications de succès
                'message' => 'Le devis a été enregistrer avec succès!',
            ];
        }
    }
}
//   Redirection avec un code de statut approprié
header('Location: /LeBaron/back-office/list-devis-obs.php');
exit;

