<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // idHasFriend missing
    if( !isset($_GET["hasFriend"]) ) {  
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
    if( ($friends = FriendsDAO::getHasFriendsForUserByIdUser($_SESSION["token"], "OK")) == null) {
        echo json_code(2); 
        return;
    }
    
    // There is no hasFriend with the idHasFriend 
    if( !isset($friends[$_GET["hasFriend"]]) ) {
        echo json_code(3); 
        return;
    }
   
    FriendsDAO::updateHasFriend($_GET["hasFriend"], "NO");
    echo json_code(1);
?>