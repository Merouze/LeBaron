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

//************************************** Request for count condolences with is_published = 0
$sqlTotalCountCondolences = $dtLb->prepare("SELECT COUNT(id_condolence) AS nb_condolences FROM condolences WHERE is_published = 0");
$sqlTotalCountCondolences->execute();
$row = $sqlTotalCountCondolences->fetch(PDO::FETCH_ASSOC);
$totalCondolences = $row['nb_condolences'];

?>