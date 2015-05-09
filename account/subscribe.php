<?php
    // If one of the field is empty 
    if( !isset($_POST["pseudo"]) || !isset($_POST["password"]) || !isset($_POST["name"]) || !isset($_POST["firstname"]) || !isset($_POST["email"]) ) { return -1; }
    $phone = isset($_POST["phone"])?$_POST["phone"]:"";
    require_once("..\DAO\UserDAO.php");
    require_once("..\DAO\LoginDAO.php");

    if(LoginDAO::getIdLoginByNickname($_POST["pseudo"]) != "") {return 2;}    

    LoginDAO::createNewLogin($_POST["pseudo"], $_POST["password"]);
    $idLogin = LoginDAO::getIdLoginByNickname($_POST["pseudo"]);
    
    $user = new User(null , $_POST["name"], $_POST["firstname"], $_POST["email"], $phone, null, null, null, $idLogin);
    UserDAO::createNewUser($user);
        
    echo "CREATED";
    return 1;
?>