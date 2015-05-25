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
    
    require_once("..\DAO\PubliDAO.php");
    // User doesn't have any publications
    if( ($users = PubliDAO::getUsersForPublications($_GET["offset"], $_GET["limit"])) == "") {
        echo json_code(2); 
        return;
    }

    echo json_code( 1, array("users", $users) );
?>