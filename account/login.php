<?php
    // If one of the field is empty 
    if( !isset($_POST["nickname"]) || !isset($_POST["password"]) ) { return -1; }

    require_once("connexion.php");
    require_once("..\DAO\loginDAO.php");
 
    $idLog = LoginDAO::getIdLoginByNickname($_POST["nickname"]);

    if(null == $idLog) {return 0;}
        
    connect($idLog);
        
    echo "<br/>CONNECTED";
    return 1;
?>