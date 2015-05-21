<?php
    require_once("..\json.php");
    $out = array();

    // If one of the field is empty 
    if( !isset($_GET["nickname"]) || !isset($_GET["password"]) || !isset($_GET["name"]) || !isset($_GET["firstname"]) || !isset($_GET["email"]) ) {
        echo json_code(-1, array("token", null));
        return; 
    }
    $phone = isset($_GET["phone"])?$_PUT["phone"]:"";

    require_once("..\session.php");
    require_once("..\DAO\UserDAO.php");
    require_once("..\DAO\LoginDAO.php");

    if(LoginDAO::getLoginByNickname($_GET["nickname"]) != "") {
        echo json_code(-1, array("token", null));
        return;
    }    

    LoginDAO::createNewLogin($_GET["nickname"], $_GET["password"]);
    $login = LoginDAO::getLoginByNickname($_GET["nickname"]);
    
    $user = new User(null , $_GET["name"], $_GET["firstname"], $_GET["email"], $phone, null, null, null, $login["idLogin"]);
    UserDAO::createNewUser($user);
    
    connect($id);
    echo json_code(1, array("token", $login["idLogin"]));
?>