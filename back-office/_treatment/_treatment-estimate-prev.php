<?php
require "../../back-office/_includes/_dbCo.php";

$idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;

// Vérifiez si l'ID du devis est présent
if (!$idEstimate) {
    // Gérer l'erreur ou rediriger l'utilisateur
    // Vous pouvez rediriger l'utilisateur vers une page d'erreur, par exemple
    header("Location: erreur.php");
    exit();
}

// Exécutez la requête de recherche dans la base de données
$sqlDisplay = $dtLb->prepare("SELECT * FROM devis_prevoyance WHERE id_estimate = :id_estimate");
$sqlDisplay->execute(['id_estimate' => $idEstimate]);

// Récupérez les résultats après l'exécution de la requête
$resultat = $sqlDisplay->fetch(PDO::FETCH_ASSOC);

// Vérifiez si des résultats ont été trouvés
if (!$resultat) {
    // Gérer l'erreur ou rediriger l'utilisateur
    header("Location: erreur.php");
    exit();
}

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
    <p>Voici notre proposition suite à votre demande en date du <span class="bold blue">' . $resultat['date_demande'] . '.</span></p>
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

    // Instanciez mPDF
    $mpdf = new \Mpdf\Mpdf();

    // Ajoutez le HTML au document
    $mpdf->WriteHTML($htmlCondolences . $htmlDevis);
    
// Définissez le chemin où vous souhaitez enregistrer le PDF
// $pdfPath = './devis-prevoyance.pdf';
$pdfPath = './devis-prevoyance-' . $idEstimate . '.pdf';

// var_dump($pdfPath);
// exit;
// Affichez le PDF dans le navigateur avec la possibilité de télécharger
$mpdf->Output($pdfPath, \Mpdf\Output\Destination::INLINE);

// Enregistrez le PDF sur le serveur
$mpdf->Output($pdfPath, \Mpdf\Output\Destination::FILE);

}

// // Définissez le chemin où vous souhaitez enregistrer le PDF
// $pdfPath = 'devis-prevoyance.pdf';

// // Affichez le PDF dans le navigateur avec la possibilité de télécharger
// $mpdf->Output('devis-prevoyance.pdf', \Mpdf\Output\Destination::INLINE);

// // Enregistrez le PDF sur le serveur
// $mpdf->Output($pdfPath, \Mpdf\Output\Destination::FILE);