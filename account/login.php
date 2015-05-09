<?php
    // If one of the field is empty 
    if( !isset($_POST["login"]) || !isset($_POST["password"]) ) { return -1; }
    require_once("..\DAO\LoginDAO.php");

    $idLog = LoginDAO::getLoginByNickname($_POST["login"]);
    echo "idLog : ".$idLog."<br/>";

    if(null == $idLog) {return 0;}
        
    require_once("../DAO/UserDAO.php");
        
    session_start();
    session_unset();
    $user = UserDAO::getUserByLoginId($idLog);
    echo $user;
        
    echo "<br/>CONNECTED";
    return 1;
?>