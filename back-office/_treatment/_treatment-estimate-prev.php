<?php
require "../../back-office/_includes/_dbCo.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $prix = $_POST["prix"];
    $commentaire = $_POST["commentaire"];

    // Créez le HTML à convertir en PDF
    $html = "<p>Prix: $prix</p><p>Commentaire: $commentaire</p>";

    // Instanciez mPDF
    $mpdf = new \Mpdf\Mpdf();

    // Ajoutez le HTML au document
    $mpdf->WriteHTML($html);

    // Affichez le PDF dans le navigateur avec la possibilité de télécharger
    $mpdf->Output('devis.pdf', \Mpdf\Output\Destination::INLINE);

    // Le reste du code peut être exécuté après Output(), si nécessaire
    // ...

    // Assurez-vous de gérer les erreurs et les succès de manière appropriée dans votre application
}
?>
