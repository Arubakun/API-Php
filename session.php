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
        
        if( !isset($_SESSION["token"]) )    {return null;}
        
        if( LoginDAO::existLoginById($_SESSION["token"]) == "" || ($user = UserDAO::getUserByLoginID($_SESSION["token"])) == "" )   {return null;}
        
        return $user;
    }
?>