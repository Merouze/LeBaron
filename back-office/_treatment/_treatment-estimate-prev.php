<?php
require "../../back-office/_includes/_dbCo.php";
session_start();
$idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;

// Exécutez la requête de recherche dans la base de données

$sqlDisplay = $dtLb->prepare("SELECT * FROM devis_prevoyance WHERE id_estimate = :id_estimate");
$sqlDisplay->execute(['id_estimate' => $idEstimate]);
$resultat = $sqlDisplay->fetch(PDO::FETCH_ASSOC);

$dateDemande = new DateTime($resultat['date_demande']);
$dateFormatee = $dateDemande->format('d/m/Y');

$dateDay = date('Y-m-d');
$dateDemande = new DateTime($dateDay);
$dateDayFormatee = $dateDemande->format('d/m/Y');

// var_dump($resultat);
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
.p-t-50 {
    padding-top: 50mm;
}
.p-b-50 {
    padding-bottom: 50mm;
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
</style>

<div>
    <img src="../../asset/img/logo-LB.png" alt="logo">
    <div class="align-right">
        <h2>Pompes Funèbres <span class="blue">Le Baron</span></h2>
        <p>02.31.26.91.75 7j/7 et 24h/24.</p>
        <p>2 Rte de Maltot 14930 Vieux.</p>
        <p>Le <span class="blue bold">' . $dateDayFormatee . ',</span></p>
        <p>Id. devis : <span class="blue bold">' . $idEstimate . '.</span></p>
    </div>
</div>

<h1>Demande <span class="blue">devis :</span></h1>
<div class="text-align">
    <p><span class="bold">' . $resultat['prenom'] . '</span> <span class="bold blue">' . $resultat['nom'] . '</span> ;</p>
    <p>Voici notre proposition suite à votre demande en date du <span class="bold blue">' . $dateFormatee . '.</span></p>
    <p>Le devis est valable 1 mois.</p>
</div>
';

// Vérifiez si le formulaire a été soumis
if (isset($_POST['submitPDF'])) {
    // Récupérez les données des champs statiques
    $designation = isset($_POST["designation"]) ? $_POST["designation"] : array();
    $advance = isset($_POST["frais_avances"]) ? $_POST["frais_avances"] : array();
    $htPrice = isset($_POST["prix_ht"]) ? $_POST["prix_ht"] : array();
    $totalHt = strip_tags($_POST["total_ht"]);
    $tva10 = strip_tags($_POST["tva_10"]);
    $tva20 = strip_tags($_POST["tva_20"]);
    $totalAdvance = strip_tags($_POST["total_frais_avances"]);
    $ttc = strip_tags($_POST["ttc"]);
    $commentaire = strip_tags($_POST["commentaire"]);
    $staticFields = [
        'designation' => strip_tags($_POST['designation']),
        'frais_avances' => strip_tags($_POST['frais_avances']),
        'prix_ht' => strip_tags($_POST['prix_ht']),
    ];

    // Récupérez les données des champs dynamiques
    $dynamicFields = isset($_POST["dynamicFields"]) ? $_POST["dynamicFields"] : array();

    // Ajoutez les champs statiques au tableau des champs dynamiques
    $dynamicFields[] = $staticFields;

    // Traitez maintenant $dynamicFields comme avant
    foreach ($dynamicFields as $key => $field) {
        $dynamicFields[$key] = [
            'designation' => strip_tags($field['designation']),
            'frais_avances' => strip_tags($field['frais_avances']),
            'prix_ht' => strip_tags($field['prix_ht']),
        ];
    }

    // var_dump($_POST);
    // exit;
    // Vérifiez le contenu final de $dynamicFields
    // var_dump($dynamicFields);


    // var_dump($_POST);
    // exit;
    // var_dump($dynamicFields);
    // exit;

    // Créez le HTML à convertir en PDF
    $htmlDevis = "
    <table class='border width'>
        <thead>
            <tr>
                <th class='align-left'>Désignation</th>
                <th class='align-left'>Frais avancés</th>
                <th class='align-left'>Prix H.T.</th>
            </tr>
            <tr>
               <td colspan='3'><hr></td>
            </tr>
        </thead>
        <tbody>";

foreach ($dynamicFields as $field) {
    $htmlDevis .= "
        <tr>
            <td>{$field['designation']}</td>
            <td>{$field['frais_avances']}</td>
            <td>{$field['prix_ht']}</td>
        </tr>
        <tr>
            <td colspan='3'><hr></td>
        </tr>";
}

$htmlDevis .= "
        </tbody>
        <tfoot>
            <tr class='border'>
                <td class='align-left'></td>
                <td class='align-left'>Total HT :</td>
                <td class='align-left'>$totalHt</td>
            </tr>
            <tr>
                <td colspan='1'></td>
                <td colspan='2'><hr></td>
            </tr>
            <tr>
                <td class='align-left'></td>
                <td class='align-left'>TVA à 10% :</td>
                <td class='align-left'>$tva10</td>
            </tr>
            <tr>
                <td colspan='1'></td>
                <td colspan='2'><hr></td>
            </tr>
            <tr class='border-cell'>
                <td class='align-left'></td>
                <td class='align-left'>TVA à 20% :</td>
                <td class='align-left'>$tva20</td>
            </tr>
            <tr>
                <td colspan='1'></td>
                <td colspan='2'><hr></td>
            </tr>
            <tr>
                <td class='align-left'></td>
                <td class='align-left'>Frais avancés global :</td>
                <td class='align-left'>$totalAdvance</td>
            </tr>
            <tr>
                <td colspan='1'></td>
                <td colspan='2'><hr></td>
            </tr>
            <tr>
                <td class='align-left'></td>
                <td class='align-left'>Prix TTC :</td>
                <td class='align-left'>$ttc</td>
            </tr>
            <tr>
                <td colspan='1'></td>
                <td colspan='2'><hr></td>
            </tr>
            <tr>
                <td>Commentaires : $commentaire</td>
            </tr>
        </tfoot>
    </table>";


    $htmlFooter = '<div class="footer">
            <img src="../../asset/img/logo-LB-footer.png" alt="logo">
            <h3>Pompes Funèbres <span class="blue">Le Baron.</span></h3>
            <p>2 Rte de Maltot 14930 Vieux, 02.31.26.91.75 7j/7 et 24h/24.</p>
            <p class="siret grey">N° Habilitation : 22 14 0043. Siret : 380 431 601 00018 - APE 9603Z.</p>
            </div>';
}
// Instanciez mPDF
$mpdf = new \Mpdf\Mpdf([
    'margin_top' => 10,
    'margin_bottom' => 10,
]);
$mpdf->WriteHTML($htmlCondolences . $htmlDevis . $htmlFooter);
$pdfPath = './devis-prevoyance-' . $idEstimate . '.pdf';
// En-têtes pour indiquer que le contenu est un fichier PDF
header('Content-Type: application/pdf');
// header('Content-Disposition: inline; filename="devis-prevoyance-' . $idEstimate . '.pdf"');
// Affichez le PDF dans le navigateur avec la possibilité de télécharger
$mpdf->Output($pdfPath, \Mpdf\Output\Destination::INLINE);
// Obtenez le contenu du PDF directement dans une variable
$pdfContentPrev = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
// Stockez le contenu dans une variable de session
$_SESSION['pdf_content_' . $idEstimate] = $pdfContentPrev;
