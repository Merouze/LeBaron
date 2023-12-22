
<?php   require_once '.././back-office/_includes/_dbCo.php';
        require_once './_includes/_functions.php';
        require_once './_includes/_pages.php';
        session_start();
        $currentPage = getCurrentPageData($pages);
        generateToken ();
        ?>

<!DOCTYPE html>
<html lang="<?php $currentPage['language']?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="asset\img\Logo-LB.png">
    <?=generateHtmlLinkCss($currentPage['linkCss'])?>
    <head>
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6Ld0QjIpAAAAAIw6sXmFG_6x86GTgGd6eXbx8mM1"></script>
</head>
    <title><?php $currentPage['title']?></title>
</head>
<body data-token="<?=$_SESSION['myToken']?>">






