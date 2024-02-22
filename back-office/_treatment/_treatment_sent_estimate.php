<?php


require "../../back-office/_includes/_dbCo.php";
session_start();

use \Mailjet\Resources;
// var_dump($_GET);
// exit;
//****************************** Treatment pdf for billing

if (isset($_GET['idEstimate'])) {
    // Récupération de l'id_bill généré
    $id_estimate = $_GET['idEstimate'];
    // var_dump($id_bill);
    // exit;
    // Utilisez directement $id_bill pour récupérer les données de la facture principale
    $sqlRetrieveFacture = $dtLb->prepare("SELECT * FROM estimate_obs WHERE id_estimate = :id_estimate");
    $sqlRetrieveFacture->execute(['id_estimate' => $id_estimate]);
    $factureData = $sqlRetrieveFacture->fetch(PDO::FETCH_ASSOC);

    /// Utilisez également $id_bill pour récupérer les données spécifiques de la table raw_bill
    $sqlRetrieveRawBill = $dtLb->prepare("SELECT * FROM raw_estimate WHERE id_estimate = :id_estimate");
    $sqlRetrieveRawBill->execute(['id_estimate' => $id_estimate]);
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
    $existingIdBill = $factureData['id_estimate'];
    // var_dump($existingIdBill);
    // exit;
    // Récupération des données des champs statiques
    $designation = $reformattedRawBillData[0]['designation'] ?? array();
    $advance = $reformattedRawBillData[0]['frais_avances'] ?? array();
    $htPrice10 = $reformattedRawBillData[0]['prix_ht_10'] ?? array();
    $htPrice20 = $reformattedRawBillData[0]['prix_ht_20'] ?? array();
    // Utilisation des valeurs récupérées pour remplir les champs statiques
    $idEstimate = $factureData['id_estimate'] ?? '';
    $name = $factureData['name'] ?? '';
    $lastname = $factureData['lastname'] ?? '';
    $email = $factureData['email'] ?? '';
    $adress = $factureData['adress'] ?? '';
    $cP = $factureData['cP'] ?? '';
    $adress = $factureData['adress'] ?? '';
    $city = $factureData['city'] ?? '';
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

    // var_dump($factureData);
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
    <p>' . $cP . ' ' . $city . '</p>
</div>
</div>
<div class="text-align">
<p>Devis n° ' . $id_estimate . ' à Vieux le ' . $formattedDate . '.</p>
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

    //  var_dump($factureData);
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
            <td><p>$commentaire</p></td>
        </tr>
    </tfoot>
</table><div><p>Merci de votre confiance et n'hésitez pas à revenir
vers nous pour plus d'informations.</p>
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
$mpdf->WriteHTML($htmlCondolences . $htmlDevis . $htmlFooter);
// Capturer le contenu PDF dans une variable
$pdfContent = $mpdf->Output('', 'S');
// En-têtes pour indiquer que le contenu est un fichier PDF
// header('Content-Type: application/pdf');


//****************************** Treatment udpdate and send pdf for billing
// Vérifiez si le formulaire a été soumis
if (isset($id_estimate) && $id_estimate == $idEstimate) {
    // Obtenez le contenu du PDF depuis la session
    $pdfPath = $_SESSION['pdf_content_' . $id_estimate];
    // var_dump($_POST);
    // exit;
    // Envoie le PDF par e-mail avec Mailjet
    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);

// Assurez-vous que $emailDestinataire et $pdfPath sont correctement définis

$body = [
    'Messages' => [
        [
            'From' => [
                'Email' => 'aurelienmerouze@gmail.com',
                'Name' => 'P.F. Le Baron.'
            ],
            'To' => [
                [
                    'Email' => $email,
                    'Name' => $name
                ]
            ],
            'Subject' => 'Devis',
            'TextPart' => 'pdf.',
            'HTMLPart' => 'Bonjour veuillez trouver ci-joint votre devis en pdf.',
            'Attachments' => [
                [
                    'ContentType' => 'application/pdf',
                    'Filename' => 'Devis-n°' . $id_estimate . '.pdf',
                    'Base64Content' => base64_encode($pdfContent)
                ]
            ]
        ]
    ]
];
// var_dump($email);
// exit;

$response = $mj->post(Resources::$Email, ['body' => $body]);


    //   Gestion des erreurs lors de l'envoi d'e-mails
    if ($response->success()) {
        $_SESSION['notif'] = ['type' => 'success', 'message' => 'Devis envoyé avec succès !'];
    } else {
        $_SESSION['notif'] = ['type' => 'error', 'message' => 'Erreur lors de l\'envoi du devis : ' . $response->getStatus() . ' - ' . json_encode($response->getData())];
    }

    // //   Requête SQL pour mettre à jour le devis
    $sqlEstimate = $dtLb->prepare("UPDATE estimate_obs SET is_sent = 1 WHERE id_estimate = :id_estimate");
    $sqlEstimate->execute(['id_estimate' => $id_estimate]);

    // //   Redirection avec un code de statut approprié
    header('Location: /LeBaron/back-office/list-devis-obs.php');
    exit;
}
}