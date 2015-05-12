<?php
    $out = array();

    // If one of the field is empty 
    if( !isset($_GET["nickname"]) || !isset($_GET["password"]) || !isset($_GET["name"]) || !isset($_GET["firstname"]) || !isset($_GET["email"]) ) {
        $out["code"] = -1;
        $out["token"] = null;
        echo json_encode($out);
        return; 
    }
    $phone = isset($_GET["phone"])?$_PUT["phone"]:"";

    require_once("..\session.php");
    require_once("..\DAO\UserDAO.php");
    require_once("..\DAO\LoginDAO.php");

    if(LoginDAO::getIdLoginByNickname($_GET["nickname"]) != "") {
        $out["code"] = 2;
        $out["token"] = null;
        echo json_encode($out);
        return;
    }    

    LoginDAO::createNewLogin($_GET["nickname"], $_GET["password"]);
    $id = LoginDAO::getIdLoginByNickname($_GET["nickname"]);
    
    $user = new User(null , $_GET["name"], $_GET["firstname"], $_GET["email"], $phone, null, null, null, $id);
    UserDAO::createNewUser($user);
    
    connect($id);
    $out["code"] = 1;
    $out["token"] = $id;
    echo json_encode($out);
?>