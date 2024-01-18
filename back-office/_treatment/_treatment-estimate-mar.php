
<?php

require "../../back-office/_includes/_dbCo.php";

$idEstimate = isset($_POST['idEstimate']) ? $_POST['idEstimate'] : null;

// Exécuter la requête de recherche dans la base de données
$sqlDisplay = $dtLb->prepare("SELECT * FROM devis_mar WHERE id_estimate = :id_estimate");
$sqlDisplay->execute(['id_estimate' => $idEstimate]);

// Récupérer les résultats après l'exécution de la requête
$resultat = $sqlDisplay->fetch(PDO::FETCH_ASSOC);
$dateDemande = new DateTime($resultat['date_demande']);
$dateFormatee = $dateDemande->format('d/m/Y');

// ...

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
</style>';
$htmlCondolences .= '<div>
                        <img src="../../asset/img/logo-LB.png" alt="logo">
                            <div class="align-right">
                                <h2>Pompes Funèbres <span class="blue">Le Baron</span></h2>
                                    <p>02.31.26.91.75 7j/7 et 24h/24</p>
                                    <p>2 Rte de Maltot 14930 Vieux.</p>
                            </div>
                    </div>';
$htmlCondolences .= '<h1>Proposition <span class="blue">devis :</span></h1>';
$htmlCondolences .= '<div class="text-align">
    <p><span class="bold">' . $resultat['firstname'] . '</span> <span class="bold blue">' . $resultat['lastname'] . '</span> ;</p>
    <p>Voici notre proposition de service et de prix suite à votre demande en date du <span class="blue">' . $dateFormatee . '.</span> N\'hésitez pas à revenir vers nous pour plus d\'information.</p>
</div>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $prix = $_POST["prix"];
    $commentaire = $_POST["commentaire"];

    // Créez le HTML à convertir en PDF
    $htmlDevis = "<p>Prix: $prix</p><p>Commentaire: $commentaire</p>";

    // Instanciez mPDF
    $mpdf = new \Mpdf\Mpdf();

    // Ajoutez le HTML au document
    $mpdf->WriteHTML($htmlCondolences . $htmlDevis);

    // Affichez le PDF dans le navigateur avec la possibilité de télécharger
    $mpdf->Output('devis.pdf', \Mpdf\Output\Destination::INLINE);

    // Le reste du code peut être exécuté après Output(), si nécessaire
    // ...

    // Assurez-vous de gérer les erreurs et les succès de manière appropriée dans votre application
}
?>