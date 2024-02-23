<?php
require "../../back-office/_includes/_dbCo.php";
session_start();

//****************************** Treatment create pdf for billing
// var_dump($_GET);
// exit;
// Vérifiez si le formulaire a été soumis
if (isset($_GET['idEstimate']) && isset($_GET['token'])) {
    $token = strip_tags($_GET['token']);
    $idEstimate = strip_tags($_GET['idEstimate']);

    if ($token === $_SESSION['myToken']) {

        $sqlRetrieveEstimate = $dtLb->prepare("SELECT * FROM estimate_mar WHERE id_estimate = :id_estimate");
        $sqlRetrieveEstimate->execute(['id_estimate' => $idEstimate]);
        $estimateData = $sqlRetrieveEstimate->fetch(PDO::FETCH_ASSOC);
        $idEstimateMar = $estimateData['id_estimate_mar'] ?? '';
        // var_dump($idEstimateMar);
        // exit;


        /// Utilisez également $id_bill pour récupérer les données spécifiques de la table raw_bill
        $sqlRetrieveRawBill = $dtLb->prepare("SELECT * FROM raw_estimate WHERE id_estimate_mar = :id_estimate_mar");
        $sqlRetrieveRawBill->execute(['id_estimate_mar' => $idEstimateMar]);
        $rawBillData = $sqlRetrieveRawBill->fetchAll(PDO::FETCH_ASSOC);

        // var_dump($estimateData);
        // exit;
        // var_dump($rawBillData);
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

        // Récupération des données des champs statiques
        $designation = $reformattedRawBillData[0]['designation'] ?? array();
        $advance = $reformattedRawBillData[0]['frais_avances'] ?? array();
        $htPrice10 = $reformattedRawBillData[0]['prix_ht_10'] ?? array();
        $htPrice20 = $reformattedRawBillData[0]['prix_ht_20'] ?? array();
        // Utilisation des valeurs récupérées pour remplir les champs statiques
        $idEstimateMar = $estimateData['id_estimate_mar'] ?? '';
        $name = $estimateData['name'] ?? '';
        $lastname = $estimateData['lastname'] ?? '';
        $email = $estimateData['email'] ?? '';
        $adress = $estimateData['adress'] ?? '';
        $cP = $estimateData['cP'] ?? '';
        $city = $estimateData['city'] ?? '';
        $totalHt = $estimateData['total_ht'] ?? '';
        $tva10 = $estimateData['tva_10'] ?? '';
        $tva20 = $estimateData['tva_20'] ?? '';
        $totalAdvance = $estimateData['total_frais_avances'] ?? '';
        $ttc = $estimateData['ttc'] ?? '';
        $commentaire = $estimateData['message'] ?? '';
        $is_Sent = $estimateData['is_sent'] ?? '';
        setlocale(LC_TIME, 'fr_FR.utf8');
        $currentDate = new DateTime();
        $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $formattedDate = $dateFormatter->format($currentDate->getTimestamp());

        // var_dump($rawBillData);
        // exit;

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
        <p class="bold">' . $name . ' ' . $lastname . '</p>
        <p>' . $adress . '</p>
        <p>' . $city . '</p>
    </div>
    </div>
    <div class="text-align">
    <p>Devis n° ' . $idEstimateMar . ' à Vieux le ' . $formattedDate . '.</p>
    </div>
    ';

        // var_dump($dynamicFields);
        // exit;

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

        // Maintenant vous pouvez utiliser $reformattedRawBillData dans la boucle foreach
        foreach ($reformattedRawBillData as $value) {
            $htmlDevis .= "
    <tr>
        <td>{$value['designation']}</td>
        <td class='align-right'>{$value['frais_avances']}</td>
        <td class='align-right'>{$value['prix_ht_10']}</td>
        <td class='align-right'>{$value['prix_ht_20']}</td>
    </tr>";
        }

        //  var_dump($estimateData);
        // var_dump($reformattedRawBillData);
        // exit;


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

        // Instanciez mPDF
        $mpdf = new \Mpdf\Mpdf([
            'margin_top' => 0,
            'margin_bottom' => 0,
            'default_font_size' => 10,

        ]);
        // Ajoutez le contenu du PDF
        $mpdf->WriteHTML($htmlCondolences . $htmlDevis . $htmlFooter);

        // Capturer le contenu PDF dans une variable
        $pdfContent = $mpdf->Output('', 'S');

        // En-têtes pour indiquer que le contenu est un fichier PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="facture.pdf"');

        // Affichez le contenu PDF dans le navigateur
        echo $pdfContent;

        // Fin du script pour éviter tout autre rendu indésirable
        exit;
    }
}
