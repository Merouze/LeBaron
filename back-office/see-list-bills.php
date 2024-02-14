<!-- // ----- # HEAD # ----- // -->
<?php include './_includes/_head.php' ?>
<!-- // ----- # check-login # ----- // -->
<?php include './_includes/_check-login.php' ?>
<?php
$dtLb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
require ".././back-office/_includes/_dbCo.php";
?>
<!-- // ----- # NAV # ----- // -->
<?php include './_includes/_nav-admin.php' ?>
<!-- section header title -->
<?php
// Display notifs
if (isset($_SESSION["notif"]) && is_array($_SESSION["notif"])) {
    $notifType = $_SESSION["notif"]["type"];
    $notifMessage = $_SESSION["notif"]["message"];
    echo '<div class="notification ' . $notifType . '">' . $notifMessage . '</div>';
    unset($_SESSION['notif']);
}
?>
<!-- <?= var_dump($_POST); ?> -->
<?php
// Initialisation des variables pour éviter les avertissements
$stmt = null;
$results = [];
// Vérifiez si le formulaire de recherche a été soumis
if (isset($_POST['search-bills'])) {
    $search = isset($_POST['search']) ? strip_tags($_POST['search']) : '';
    // Préparez la requête SQL
    $sql = "SELECT id_bill, name, ttc, date
            FROM factures
            WHERE name LIKE :search
            ORDER BY date DESC";
    $stmt = $dtLb->prepare($sql);
    $stmt->execute(['search' => "%$search%"]);
    // Vérifiez si la recherche à donné des résultats
    if ($stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['notif'] = [
            'type' => 'success',
            'message' => 'Recherche effectuée avec succès.'
        ];
    } else {
        // Aucun résultat trouvé, ajoutez une notification d'erreur
        $_SESSION['notif'] = [
            'type' => 'error',
            'message' => 'Aucun résultat trouvé.'
        ];
    }
}
?>
<?php
if (isset($results) && !empty($results)) : ?>
    <section>
        <h2 class="text-align">Résultats de la <span class="blue">recherche</span></h2>
        <ul class="resultats-recherche">
            <?php foreach ($results as $result) :
                $idBill = $result['id_bill'];
                // Créer un objet DateTime pour la date de la facture
                $dateFacture = new DateTime($result['date']);
                // Formater la date en jours/mois/année
                $dateFormatee = $dateFacture->format('d/m/Y');
            ?>
                <li>
                    <ul>
                        <div class="display-mtb20 display_list-ad display-search-admin">
                            <div class="display-li-ad">
                                <li class="bold grey"><?= $result['name'] ?></li>
                                <li class="bold blue"><?= $dateFormatee ?></li>
                                <li class="bold">Prix T.T.C. : <span class="bold blue"><?= $result['ttc'] ?> €</span></li>
                            </div>
                            <div class="display-btn-list-ad">
                                <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" target="_blank" href="see-bill.php?idBill=<?= urlencode($result['id_bill']) ?>">Consulter</a></p>
                                <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="modif-bill.php?idBill=<?= urlencode($result['id_bill']) ?>">Modifier</a></p>
                                <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="_treatment/_treatment_sent_bill.php?idBill=<?= urlencode($result['id_bill']) ?>">Envoyer</a></p>
                                <p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="javascript:void(0);" onclick="confirmDeleteBill(<?= $idBill ?>);">Supprimer</a></p>
                            </div>
                            <!-- <?php var_dump($idBill); ?> -->
                        </div>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    </section>

    <!-- <?php var_dump($_SESSION); ?> -->
    <!-- section obituary -->
    <section>
        <form method="post">
            <h3>Rechercher Nom/Prénom ou identifiant factures :</h3>
            <input name="search" type="text">
            <input type="hidden" id="tokenField" name="token" value="<?= $_SESSION['myToken'] ?>">
            <button name="search-bills" type="submit">Rechercher</button>
        </form>
    </section>
    <!-- Afficher les derniers factures émises -->
    <section class="resultats-recherche">
        <h3 class="mb50 text-align grey">Nos dernières factures <span class="blue">émises</span></h3>

        <?php
        $sqlGetLastBill = $dtLb->query("SELECT id_bill, name, ttc, date
    FROM factures
    ORDER BY date DESC
    LIMIT 4");


        $lastBills = $sqlGetLastBill->fetchAll(PDO::FETCH_ASSOC);

        // Boucle pour générer le code HTML 
        echo '<ul>';
        foreach ($lastBills as $bill) {

            $idBill = $bill['id_bill'];
            // var_dump($idBill);

            // Créer un objet DateTime pour la date de la cérémonie
            $dateCeremonie = new DateTime($bill['date']);

            // Formater la date en jours/mois/année
            $dateFormatee = $dateCeremonie->format('d/m/Y');
            echo '<li>';
            echo '<ul>';
            echo '<div class="display-mtb20 display_list-ad">';
            echo '<div class="display-li-ad">';
            echo '<li class="bold grey">' . $bill['name'] . '</li>';
            echo '<li class="bold blue">' . $dateFormatee . '</li>';
            echo '<li class="bold">Prix ttc : ' . $bill['ttc'] . ' €</li>';
            echo '</div>';
            echo '<div class="display-btn-list-ad">';
            echo '<p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" target="_blank" href="see-bill.php?idBill=' . urlencode($bill['id_bill']) . '">Consulter</a></p>';
            echo '<p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="modif-bill.php?idBill=' . urlencode($bill['id_bill']) . '">Modifier</a></p>';
            echo '<p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="_treatment/_treatment_sent_bill?idBill=' . urlencode($bill['id_bill']) . '">Envoyer</a></p>';
            echo '<p class="obituary-cta"><a class="cta-btn-list-ad cta-obituary" href="javascript:void(0);" onclick="confirmDeleteBill(' . $idBill . ');">Supprimer</a></p>';
            echo '</div>';
            echo '</div>';
            echo '</ul>';
            echo '</li>';
        }
        echo '</ul>';
        ?>
        <!-- <?php var_dump($lastBills); ?> -->

    </section>

    <!-- // ----- # FOOTER # ----- // -->
    <?php include './_includes/_footer.php' ?>

    <script src=".././asset/Js/script.js"></script>
    <script src=".././asset/Js/fonctions.js"></script>
    </body>

    </html>