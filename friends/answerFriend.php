<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // idHasFriend missing
    if( !isset($_GET["hasFriend"]) || !isset($_GET["response"])) {  
        echo json_code(-1);
        return;
    }

    // User not connected
    if( ($user = isConnected()) == null ) { 
        echo json_code(0); 
        return;
    }
    
    require_once("..\DAO\FriendsDAO.php");
    // User doesn't have any ask
    if( ($asks = FriendsDAO::getHasFriendsForUserByIdUser($_SESSION["token"], "ASK  ", 2)) == "") {
        echo json_code(2); 
        return;
    }
    
    // There is no ask with the idHasFriend 
    if( !isset($asks[$_GET["hasFriend"]]) ) {
        echo json_code(3); 
        return;
    }
   
    if($_GET["response"] == "OK" || $_GET["response"] == "NO") {
        FriendsDAO::updateHasFriend($_GET["hasFriend"], $_GET["response"]);
        echo json_code(1);
    }
    
    echo json_code(4);
?>