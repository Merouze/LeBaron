<?php
//************************************** */ Request for count devis prev with traite = 0
$sqlCountPrev = $dtLb->prepare("SELECT COUNT(*) AS totalDevisPrev
    FROM devis_prevoyance
    WHERE traite = 0");
$sqlCountPrev->execute();
$totalDevisPrev = $sqlCountPrev->fetch(PDO::FETCH_ASSOC)['totalDevisPrev'];
// var_dump($totalDevis);

//************************************** Request for count devis obs with traite = 0
$sqlCountObs = $dtLb->prepare("SELECT COUNT(*) AS totalDevisObs
    FROM devis_obs
    WHERE traite = 0");
$sqlCountObs->execute();
$totalDevisObs = $sqlCountObs->fetch(PDO::FETCH_ASSOC)['totalDevisObs'];

//************************************** Request for count devis mar with traite = 0
$sqlCountMar = $dtLb->prepare("SELECT COUNT(*) AS totalDevisMar
    FROM devis_mar
    WHERE traite = 0");
$sqlCountMar->execute();
$totalDevisMar = $sqlCountMar->fetch(PDO::FETCH_ASSOC)['totalDevisMar'];
?>
<div class="navbar">
    <div class="contact-info">
        <div class="d-logo">
            <img class="logo" src=".././asset\img\Logo-LB.png" alt="">
        </div>
        <div class="nav-info">
            <p class="info-nav">Permanence téléphonique 7j/7 et 24h/24</p>
        </div>
        <div class="contact-info-cta">
            <!-- <a class="icon-user" href="back-office/login-family.php"><img src=".././asset\img\icon-user.png" alt="icon user"></a> -->
            <p><a href="tel:+33231269175">📞 02 31 26 91 75</a></p>
            <p class="cta"><a href="tel:+33231269175">Nous contacter</a></p>
        </div>
    </div>
    <div class="nav-links">
        <ul>
            <li><a href="./admin.php">Admin</a></li>
            <li><a href="./see-accounts.php">Comptes Familles</a></li>
            <ul class="dropdown">
                <li><a href="#">Facturation ▼</a></li>
                <div class="dropdown-content">
                    <li><a href="./billing.php">Créer une Facture</a></li>
                    <li><a href="./see-list-bills.php">Afficher les Factures</a></li>
                </div>
            </ul>
            <ul class="dropdown">
                <li><a href="#">Avis de Décès ▼</a></li>
                <div class="dropdown-content">
                    <li><a href="add-avis.php">Ajouter un Avis</a></li>
                    <li><a href="list-avis.php">Afficher les Avis</a></li>
                </div>
            </ul>
            <ul class="dropdown">
                <li><a href="#">Devis Reçu(s) ▼</a></li>
                <div class="dropdown-content">
                    <li><a href="list-devis-obs.php">Devis Obsèques (<?=$totalDevisObs;?>)</a></li>
                    <li><a href="list-devis-mar.php">Devis Marbrerie (<?=$totalDevisMar;?>)</a></li>
                    <li><a href="list-devis-prev.php">Devis Prévoyance (<?=$totalDevisPrev;?>)</a></li>
                </div>
            </ul>
            <li><a href=".././back-office/_treatment/_logout.php">Se Déconnecter</a></li>
        </ul>
    </div>
    <div class="burger-menu" id="burger-icon">&#9776;</div>
</div>