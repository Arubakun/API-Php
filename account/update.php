<?php
    require_once("../json.php");
    require_once("../session.php");
    $out = array();
    
    // If one of the field is empty 
    if( !isset($_POST["name"]) && !isset($_POST["firstname"]) && !isset($_POST["email"]) &&!isset($_POST["phone"]) ) { 
        echo json_code(-1);
        return; 
    }

    // User not connected
    if( ($user = isConnected()) == null ) { 
        echo json_code(0); 
        return;
    }

    require_once("..\DAO\UserDAO.php");
    require_once("..\DAO\LoginDAO.php");

    if(LoginDAO::existLoginById($user->getIdUser()) == "") {
        echo json_code(2);
        return; 
    }   

    $modif = array();    
    $user = UserDAO::getUserByLoginID($_SESSION["token"]);
    
    if(isset($_POST["name"]) && $_POST["name"] != "" && $_POST["name"] != $user->getName())                 { $modif["name"] = $_POST["name"]; }
    if(isset($_POST["firstname"]) && $_POST["firstname"] != "" && $_POST["firstname"] != $user->getFirstname())  { $modif["firstname"] = $_POST["firstname"]; }
    if(isset($_POST["email"]) && $_POST["email"] != "" && $_POST["email"] != $user->getEmail())              { $modif["email"] = $_POST["email"]; }
    if(isset($_POST["phone"]) && $_POST["phone"] != "" && $_POST["phone"] != $user->getPhone())              { $modif["phone"] = $_POST["phone"]; }

    if(!count($modif)) {
        echo json_code(3);
        return; 
    }
    UserDAO::updateUser($user, $modif);
        
    echo json_code(1);
?>