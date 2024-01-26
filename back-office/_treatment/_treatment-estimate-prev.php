<?php
require "../../back-office/_includes/_dbCo.php";
session_start();
$idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;
// var_dump($_POST);
// exit;

// Exécutez la requête de recherche dans la base de données
$sqlDisplay = $dtLb->prepare("SELECT * FROM devis_prevoyance WHERE id_estimate = :id_estimate");
$sqlDisplay->execute(['id_estimate' => $idEstimate]);
$resultat = $sqlDisplay->fetch(PDO::FETCH_ASSOC);

$dateDemande = new DateTime($resultat['date_demande']);
$dateFormatee = $dateDemande->format('d/m/Y');

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
    .align-center {
        text-align: center;
    }
    .mt-50 {
        margin-top: 150px;
    }
</style>
<div>
    <img src="../../asset/img/logo-LB.png" alt="logo">
    <div class="align-right">
        <h2>Pompes Funèbres <span class="blue">Le Baron</span></h2>
        <p>02.31.26.91.75 7j/7 et 24h/24</p>
        <p>2 Rte de Maltot 14930 Vieux.</p>
    </div>
</div>
<h1>Demande <span class="blue">devis :</span></h1>
<div class="text-align">
    <p><span class="bold">' . $resultat['prenom'] . '</span> <span class="bold blue">' . $resultat['nom'] . '</span> ;</p>
    <p>Voici notre proposition suite à votre demande en date du <span class="bold blue">' . $dateFormatee . '.</span></p>
    <p>N\'hésitez pas à revenir vers nous pour plus d\'information.</p>
</div>
';

// Vérifiez si le formulaire a été soumis
if (isset($_POST['submitPDF'])) {
    // Récupérez les données du formulaire
    $commentaire = strip_tags($_POST["commentaire"]);

    // Créez le HTML à convertir en PDF
    $htmlDevis = "<p><span class='bold'>Proposition : </span>$commentaire</p>";
    $htmlDevis .= '
    <div class="mt-50 text-align">
        <div class="align-center">
            <img src="../../asset/img/logo-LB-footer.png" alt="logo">
            <h3>Pompes Funèbres <span class="blue">Le Baron.</span></h3>
            2 Rte de Maltot 14930 Vieux, 02.31.26.91.75 7j/7 et 24h/24.
        </div>
    </div>
    ';
}
// Instanciez mPDF
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($htmlCondolences . $htmlDevis);
$pdfPath = './devis-prevoyance-' . $idEstimate . '.pdf';
// En-têtes pour indiquer que le contenu est un fichier PDF
header('Content-Type: application/pdf');
// header('Content-Disposition: inline; filename="devis-prevoyance-' . $idEstimate . '.pdf"');
// Affichez le PDF dans le navigateur avec la possibilité de télécharger
$mpdf->Output($pdfPath, \Mpdf\Output\Destination::INLINE);
// Enregistrez le PDF sur le serveur
// $mpdf->Output($pdfPath, \Mpdf\Output\Destination::FILE);
// Obtenez le contenu du PDF directement dans une variable
$pdfContentPrev = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
// Stockez le contenu dans une variable de session
$_SESSION['pdf_content_' . $idEstimate] = $pdfContentPrev;
?>

