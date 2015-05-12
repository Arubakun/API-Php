<?php
    require_once("DAO\UserDAO.php");
    require_once("DAO\LoginDAO.php");
    
    function connect($idLogin) {
        session_start();
        session_unset();
        
        $_SESSION["token"] = $idLogin;
        return true;
    }

    function isConnected() {
        session_start();
        
        if( !isset($_SESSION["token"]) )    {return 0;}
        if( LoginDAO::existLoginById($_SESSION["token"]) || UserDAO::getUserByLoginID($_SESSION["token"]) == "" )   {return -1;}
        
        return 1;
    }
?>