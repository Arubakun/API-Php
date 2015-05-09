<?php
    // If one of the field is empty 
    if( !isset($_GET["nickname"]) || !isset($_GET["password"]) || !isset($_GET["name"]) || !isset($_GET["firstname"]) || !isset($_GET["email"]) ) { return -1; }
    $phone = isset($_GET["phone"])?$_PUT["phone"]:"";

    require_once("connexion.php");
    require_once("..\DAO\UserDAO.php");
    require_once("..\DAO\LoginDAO.php");

    if(LoginDAO::getIdLoginByNickname($_GET["nickname"]) != "") {return 2;}    

    LoginDAO::createNewLogin($_GET["pseudo"], $_GET["password"]);
    $idLogin = LoginDAO::getIdLoginByNickname($_GET["nickname"]);
    
    $user = new User(null , $_GET["name"], $_GET["firstname"], $_GET["email"], $phone, null, null, null, $idLogin);
    UserDAO::createNewUser($user);
    echo "CREATED";
    
    connnect($idLogin);
    return 1;
?>