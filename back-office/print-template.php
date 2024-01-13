<!-- // ----- # HEAD # ----- // -->
<?php include '../back-office/_includes/_head.php' ?>
<?php include '../back-office/_treatment/_treatment-display-ad.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<?php
$idDefunt = isset($_GET['idDefunt']) ? $_GET['idDefunt'] : null;
// Requête pour récupérer les messages de condoléances
$sqlSelectCondolences = $dtLb->prepare("SELECT id_defunt, id_condolence, nom_expditeur, email_expditeur, message, date_envoi, is_published FROM condolences WHERE id_defunt = :id_defunt ORDER BY date_envoi DESC");
$sqlSelectCondolences->execute(['id_defunt' => $idDefunt]);
$condolences = $sqlSelectCondolences->fetchAll(PDO::FETCH_ASSOC);

// Fonction pour générer le PDF
function generatePDF($condolences)
{
    // Créer un objet mPDF
    $mpdf = new \Mpdf\Mpdf();

    // Votre style CSS
    $css = '
        .border-check {
            border: 1px solid #039DB5;
            margin: 10px;
            padding: 10px;
        }
        a {
            color: red;
        }
        .print {
            font-weight: bold;
        }
    ';

    // Votre contenu HTML à convertir en PDF
    $html = '<style>' . $css . '</style>';
    $html .= '<img src="../asset/img/logo-LB.webp" alt="">';
    $html .= '<h1>Condoléances</h1>';
    $html .= '<ul class="align-content">';

    // Ajouter le contenu à mPDF
    foreach ($condolences as $condolence) {
        $html .= '<div class="border-check">';
        $html .= '<li class="border-check">';
        $html .= '<strong class="print">Nom :</strong> ' . $condolence['nom_expditeur'] . '<br>';
        $html .= '<strong class="print">Email :</strong> ' . $condolence['email_expditeur'] . '<br>';
        $html .= '<strong class="print">Message :</strong> ' . $condolence['message'] . '<br>';
        $html .= '</li>';
        $html .= '</div>';
    }

    // Fermer la liste ul
    $html .= '</ul>';

    // Ajouter le contenu à mPDF
    $mpdf->WriteHTML($html);

    // Enregistrez le PDF sur le serveur ou renvoyez-le au navigateur
    $mpdf->Output('output.pdf', 'F'); // Enregistrez le PDF sur le serveur

    // Ou renvoyez-le au navigateur
    // $mpdf->Output();

    // Lire le fichier PDF et le renvoyer au navigateur
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="output.pdf"');
    readfile('output.pdf');
    exit();
}
?>
