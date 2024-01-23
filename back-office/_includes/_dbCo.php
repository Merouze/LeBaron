<?php

//  require ".././vendor/autoload.php";
 require "/wamp64/www/LeBaron/vendor/autoload.php";
 

 try {
    // Get environnement configuration
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Connect to the database
    $dtLb = new PDO(
        $_ENV['DB_HOST'],
        $_ENV['DB_USER'],
        $_ENV['DB_PWD']
    );
    $dtLb->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );
} catch (Exception $e) {
    die('Unable to connect to the database.
    ' . $e->getMessage());
}

?>