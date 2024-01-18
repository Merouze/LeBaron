<?php
require "../../back-office/_includes/_dbCo.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['idDefunt'])) {
    $idDefunt = $_GET['idDefunt'];

    // Requête pour récupérer les messages de condoléances
    $sqlSelectCondolences = $dtLb->prepare("SELECT id_defunt, id_condolence, nom_expditeur, email_expditeur, message, date_envoi, is_published FROM condolences WHERE id_defunt = :id_defunt ORDER BY date_envoi DESC");
    $sqlSelectCondolences->execute(['id_defunt' => $idDefunt]);
    $condolences = $sqlSelectCondolences->fetchAll(PDO::FETCH_ASSOC);

    // Génération du contenu stylisé du PDF
    $html = '<style>
                .condolence {
                    margin-bottom: 20px;
                    padding: 10px;
                    border: 1px solid #039DB5;
                    border-radius: 5px;
                }
                .condolence p {
                    margin: 5px 0;
                }
                .blue {
                    color : #039DB5;
                }
                .align-right {
                    text-align : right;
                }
            </style>';


    $html .= '<div class="navbar">
             <div class="contact-info">
                    <p href="admin.php"><img class="logo" src="../../asset/img/logo-LB.png" alt="logo"></p>
            </div>
            <div class="align-right">
            <h2>Pompes Funèbres <span class="blue">Le Baron</span></h2>
            <p>02.31.26.91.75 7j/7 et 24h/24</p>
            <p>2 Rte de Maltot 14930 Vieux.</p>
            </div>
                    </div>';
    $html .= '<h1>Condoléance(s) <span class="blue">reçue(s) :</span></h1>';

    if (!empty($condolences)) {
        foreach ($condolences as $condolence) {
            $html .= '<div class="condolence" style="page-break-inside: avoid;">';
            $html .= '<p><strong>Nom :</strong> ' . $condolence['nom_expditeur'] . '</p>';
            $html .= '<p><strong>Email :</strong> ' . $condolence['email_expditeur'] . '</p>';
            $html .= '<p><strong>Message :</strong> ' . $condolence['message'] . '</p>';
            $html .= '</div>';
        }
    }

    // Instanciez mPDF
    $mpdf = new \Mpdf\Mpdf();

    // Ajoutez le HTML au document
    $mpdf->WriteHTML($html);

    // Affichez le PDF dans le navigateur avec la possibilité de télécharger
    $mpdf->Output('condolences.pdf', \Mpdf\Output\Destination::INLINE);
}
?>
<span></span>