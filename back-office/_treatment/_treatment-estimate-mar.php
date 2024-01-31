<?php
require "../../back-office/_includes/_dbCo.php";
session_start();
$idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;

// Exécuter la requête de recherche dans la base de données
$sqlDisplay = $dtLb->prepare("SELECT * FROM devis_mar WHERE id_estimate = :id_estimate");
$sqlDisplay->execute(['id_estimate' => $idEstimate]);
$resultat = $sqlDisplay->fetch(PDO::FETCH_ASSOC);

$dateDemande = new DateTime($resultat['date_demande']);
$dateFormatee = $dateDemande->format('d/m/Y');
// var_dump($_POST);
// exit
// Génération du contenu stylisé du PDF pour les condoléances
$htmlCondolences = '<style>
    
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
    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        text-align: center;
    }
</style>';
$htmlCondolences .= '<div>
                        <img src="../../asset/img/logo-LB.png" alt="logo">
                            <div class="align-right">
                                <h2>Pompes Funèbres <span class="blue">Le Baron</span></h2>
                                    <p>02.31.26.91.75 7j/7 et 24h/24</p>
                                    <p>2 Rte de Maltot 14930 Vieux.</p>
                            </div>
                    </div>';
$htmlCondolences .= '<h1>Demande <span class="blue">devis :</span></h1>';
$htmlCondolences .= '<div class="text-align">
    <p><span class="bold">' . $resultat['firstname'] . '</span> <span class="bold blue">' . $resultat['lastname'] . '</span> ;</p>
    <p>Voici notre proposition suite à votre demande en date du <span class="bold blue">' . $dateFormatee . '.</span></p>
    <p>N\'hésitez pas à revenir vers nous pour plus d\'information.</p>
</div>';


if (isset($_POST['submitTraitement'])) {
    // Récupérez les données du formulaire
    $commentaire = strip_tags($_POST["commentaire"]);

    // Créez le HTML à convertir en PDF
    $htmlDevis = "<p><span class='bold'>Proposition : </span>$commentaire</p>";
    // Ajoutez un style pour ajuster la marge inférieure du contenu du devis

    $htmlFooter = '<div class="footer">
    <img src="../../asset/img/logo-LB-footer.png" alt="logo">
        <h3>Pompes Funèbres <span class="blue">Le Baron.</span></h3>
           2 Rte de Maltot 14930 Vieux, 02.31.26.91.75 7j/7 et 24h/24.
           </div>';
 

    // Instanciez mPDF
    // $mpdf = new \Mpdf\Mpdf();
    $mpdf = new \Mpdf\Mpdf([
        'margin_top' => 10,
        'margin_bottom' => 10,
    ]);
    $mpdf->WriteHTML($htmlCondolences . $htmlDevis . $htmlFooter);
    $pdfPath = './devis-marbrerie-' . $idEstimate . '.pdf';
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
