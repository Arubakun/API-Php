<?php
    require_once("..\json.php");
    $out = array();

    // If one of the field is empty 
    if( (!isset($_GET["nickname"]) || $_GET["nickname"] == "") || (!isset($_GET["password"]) || $_GET["password"]) || (!isset($_GET["name"]) || $_GET["name"] ) || 
       (!isset($_GET["firstname"]) || $_GET["firstname"]) || (!isset($_GET["email"]) || $_GET["email"]) ) {
        echo json_code(-1, array("token", null));
        return; 
    }
    $phone = isset($_GET["phone"])?$_PUT["phone"]:"";

    require_once("..\session.php");
    require_once("..\DAO\UserDAO.php");
    require_once("..\DAO\LoginDAO.php");

    if(LoginDAO::getLoginByNickname($_GET["nickname"]) != "") {
        echo json_code(2, array("token", null));
        return;
    }    

    if(($login = LoginDAO::createNewLogin($_GET["nickname"], $_GET["password"])) == "") {
        echo json_code(-2, array("token", null));
        return;
    }        
    
    $user = new User(null , $_GET["name"], $_GET["firstname"], $_GET["email"], $phone, null, null, null, $login);
    UserDAO::createNewUser($user);
    
    connect($login);
    echo json_code(1, array("token", $login));
?>