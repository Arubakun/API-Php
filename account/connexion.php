<?php
    require_once("..\DAO\UserDAO.php");
    
    function connect($idLogin) {
        $user = UserDAO::getUserByLoginID($idLogin);

        session_start();
        session_unset();
        
        $_SESSION["idUser"] = $user->getIdUser();
         echo $user;
    }
?>