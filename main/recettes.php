<?php
    /*
    * On indique que les chemins des fichiers qu'on inclut
    * seront relatifs au répertoire src.
    */
    set_include_path("./src");

    /* Inclusion des classes utilisées dans ce fichier */
    require_once("model/RecetteStorageMySQL.php");
    require_once("Router.php");
    require_once('/users/21903735/private/mysql_config.php');


    /*
    * Cette page est simplement le point d'arrivée de l'internaute
    * sur notre site. On se contente de créer un routeur
    * et de lancer son main.
    */

    //CHANGER MPD DANS BD 
    
    $dbh = new PDO('mysql:host=' . $MYSQL_HOST . ';dbname=' . $MYSQL_DB . ';charset=utf8mb4',$MYSQL_USER,$MYSQL_PASSWORD);
    //$dbh = new PDO('mysql:host=mysql.info.unicaen.fr;dbname=21903735_bd;charset=utf8mb4','21903735','cah7puJeiPhei5Ou');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $recettes = new RecetteStorageMySQL($dbh);
    $recettes = new Router($recettes);
    $recettes->main();
    
?>