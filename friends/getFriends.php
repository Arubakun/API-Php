<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // idHasFriend missing
    if( !isset($_GET["offset"]) || !isset($_GET["limit"])) {  
        echo json_code(-1);
        return;
    }

    // User not connected
    if( ($user = isConnected()) == null ) { 
        echo json_code(0); 
        return;
    }
    
    require_once("..\DAO\FriendsDAO.php");
    // User doesn't have any friend
    if( ($friends = FriendsDAO::getFriendsForUserByIdUser($_SESSION["token"])) == "") {
        echo json_code(2); 
        return;
    }

    echo json_code(1, array("friends", $friends) );
?>