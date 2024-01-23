<?php
require ".././back-office/_includes/_dbCo.php";

use \Mailjet\Resources;

session_start();
$_SESSION['myToken'] = md5(uniqid(mt_rand(), true));
// var_dump($_POST);

if (isset($_POST['name']) && isset($_POST['email'])) {
    $mj = new \Mailjet\Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);
    $idDefunt = isset($_POST['idDefunt']) ? intval($_POST['idDefunt']) : null;

    // Requête pour récupérer les infos de condoléances
    // Requête pour récupérer les infos de condoléances
    $sqlSelectCondolences = $dtLb->prepare("SELECT id_defunt, id_condolence, nom_prenom_defunt
FROM defunt 
JOIN condolences USING (id_defunt)
WHERE id_defunt = :id_defunt");

    $sqlSelectCondolences->execute(['id_defunt' => $idDefunt]);
    $condolence = $sqlSelectCondolences->fetch(PDO::FETCH_ASSOC);
    // var_dump($condolence);

    $name = "Nom et Prénom : " . $_POST['name'];
    $email = $_POST['email'];
    $message = "Message : " . $_POST['message'];
    $defuntName = "Nom et Prénom : " . $condolence['nom_prenom_defunt'];

    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "p.lim61@hotmail.fr",
                ],
                'To' => [
                    [
                        'Email' => "p.lim61@hotmail.fr",
                        'Name' => "Aurélien"
                    ]
                ],
                'Subject' => "Nouveau Message de condoléances.",
                'TextPart' => "Un nouveau message venant de Devis Marbrerie.",
                'HTMLPart' => "<h1>Nouveau Message de condoléances à valider</h1><h2>A l'intention de </h2>$defuntName<p><h2>De la part de </h2></p><p>$name</p><p>$message</p><p>$email</p>",
            ]
        ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);
}

?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $name = strip_tags($_POST['name']);
    $email = strip_tags($_POST['email']);
    $message = strip_tags($_POST['message']);
    $token = strip_tags($_POST['token']); 
    $idDefunt = isset($_POST['idDefunt']) ? intval($_POST['idDefunt']) : null;

    // var_dump($_POST);
    // exit;

    // Valider les données (ajoutez des validations supplémentaires au besoin)
    if (empty($name) || empty($email) || empty($message)) {
        // Gérer les erreurs de validation
        $_SESSION['notif'] = array('type' => 'error', 'message' => 'Veuillez remplir tous les champs.');
        header('Location: .././recherche-avis.php');
        exit();
    }
    // Requête d'Insertion dans la table condolences
    $sqlInsert = $dtLb->prepare("INSERT INTO condolences (id_defunt, nom_expditeur, email_expditeur, message) VALUES (:id_defunt, :nom_expditeur, :email_expditeur, :message)");
    $sqlInsert->execute([
        'id_defunt' => $idDefunt,
        'nom_expditeur' => $name,
        'email_expditeur' => $email,
        'message' => $message,
    ]);

    $_SESSION['notif'] = ['type' => 'success', 'message' => 'Condoléances envoyées avec succès.'];

    header('Location: .././recherche-avis.php');
    exit();
}
?>