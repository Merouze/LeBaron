<?php
require "../../back-office/_includes/_dbCo.php";
session_start();
$idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;

// Exécuter la requête de recherche dans la base de données
$sqlDisplay = $dtLb->prepare("SELECT * FROM devis_obs WHERE id_estimate = :id_estimate");
$sqlDisplay->execute(['id_estimate' => $idEstimate]);
$resultat = $sqlDisplay->fetch(PDO::FETCH_ASSOC);

$dateDemande = new DateTime($resultat['date_demande']);
$dateFormatee = $dateDemande->format('d/m/Y');

$dateDay = date('Y-m-d');
$dateDemande = new DateTime($dateDay);
$dateDayFormatee = $dateDemande->format('d/m/Y');
// var_dump($_POST);
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
        <h2>Pompes Funèbres <span class="blue">Le Baron</span></h2>
        <p>02.31.26.91.75 7j/7 et 24h/24.</p>
        <p>2 Rte de Maltot 14930 Vieux.</p>
        <p>Le <span class="blue bold">' . $dateDayFormatee . ',</span></p>
        <p>Id. devis : <span class="blue bold">' . $idEstimate . '.</span></p>
    </div>
</div>

<div class="text-align">
    <p><span class="bold">' . $resultat['firstname'] . '</span> <span class="bold blue">' . $resultat['lastname'] . '</span> ;</p>
    <p>Voici notre proposition suite à votre demande en date du <span class="bold blue">' . $dateFormatee . '.</span></p>
</div>
';

// Vérifiez si le formulaire a été soumis
if (isset($_POST['submitPDF']) && isset($_POST['token'])) {
    $token = strip_tags($_POST['token']);
    if ($token === $_SESSION['myToken']) {

        // Récupérez les données des champs statiques
        $designation = isset($_POST["designation"]) ? $_POST["designation"] : array();
        $advance = isset($_POST["frais_avances"]) ? $_POST["frais_avances"] : array();
        $htPrice10 = isset($_POST["prix_ht_10"]) ? $_POST["prix_ht_10"] : array();
        $htPrice20 = isset($_POST["prix_ht_20"]) ? $_POST["prix_ht_20"] : array();
        $totalHt = strip_tags($_POST["total_ht"]);
        $tva10 = strip_tags($_POST["tva_10"]);
        $tva20 = strip_tags($_POST["tva_20"]);
        $totalAdvance = strip_tags($_POST["total_frais_avances"]);
        $ttc = strip_tags($_POST["ttc"]);
        $commentaire = strip_tags($_POST["commentaire"]);
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
        // var_dump($_POST);
        // exit;
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

        foreach ($dynamicFields as $field) {
            $htmlDevis .= "
            <tr>
                <td>{$field['designation']}</td>
                <td class='align-right'>{$field['frais_avances']}</td>
                <td class='align-right'>{$field['prix_ht_10']}</td>
                <td class='align-right'>{$field['prix_ht_20']}</td>
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
    </table>
    <p>Le devis est valable 1 mois.</p>
    <p>Bon pour accord :</p>";


        $htmlFooter = '<div class="footer">
            <h3>Pompes Funèbres <span class="blue">Le Baron.</span></h3>
            <p>2 Rte de Maltot 14930 Vieux, 02.31.26.91.75 7j/7 et 24h/24.</p>
            <p class="siret grey">N° Habilitation : 22 14 0043. Siret : 380 431 601 00018 - APE 9603Z.</p>
            </div>';
    }
    // Instanciez mPDF
    $mpdf = new \Mpdf\Mpdf([
        'margin_top' => 0,
        'margin_bottom' => 0,
        'default_font_size' => 10,

    ]);
    $mpdf->WriteHTML($htmlCondolences . $htmlDevis . $htmlFooter);
    $pdfPath = './devis-obsèques-' . $idEstimate . '.pdf';
    // En-têtes pour indiquer que le contenu est un fichier PDF
    header('Content-Type: application/pdf');
    // Affichez le PDF dans le navigateur avec la possibilité de télécharger
    $mpdf->Output($pdfPath, \Mpdf\Output\Destination::INLINE);
    // Enregistrez le PDF sur le serveur
    // $mpdf->Output($pdfPath, \Mpdf\Output\Destination::FILE);
    // Obtenez le contenu du PDF directement dans une variable
    $pdfContent = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
    // Stockez le contenu dans une variable de session
    $_SESSION['pdf_content_' . $idEstimate] = $pdfContent;
}
