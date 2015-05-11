<?php
    $out = array();
    
    // If one of the field is empty 
    if( !isset($_POST["id"]) || (!isset($_POST["name"]) && !isset($_POST["firstname"]) && !isset($_POST["email"]) &&!isset($_POST["phone"])) ) { 
        $out["code"] = -1;
        echo json_encode($out);
        return; 
    }

    require_once("..\DAO\UserDAO.php");
    require_once("..\DAO\LoginDAO.php");

    if(LoginDAO::existLoginById($_POST["id"]) == "") {
        $out["code"] = 2;
        echo json_encode($out);
        return; 
    }   

    $modif = array();    
    $user = UserDAO::getUserByLoginID($_POST["id"]);
    
    if(isset($_POST["name"]) && $_POST["name"] != $user->getName())                 { $modif["name"] = $_POST["name"]; }
    if(isset($_POST["firstname"]) && $_POST["firstname"] != $user->getFirstname())  { $modif["firstname"] = $_POST["firstname"]; }
    if(isset($_POST["email"]) && $_POST["email"] != $user->getEmail())              { $modif["email"] = $_POST["email"]; }
    if(isset($_POST["phone"]) && $_POST["phone"] != $user->getPhone())                  { $modif["phone"] = $_POST["phone"]; }

    if(!count($modif)) {
        $out["code"] = 3;
        echo json_encode($out);
        return; 
    }
    UserDAO::updateUser($user, $modif);
        
    $out["code"] = 1;
    echo json_encode($out);
?>