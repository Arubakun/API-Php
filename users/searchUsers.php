<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // idHasFriend missing
    if( false ) {  
        echo json_code(-1);
        return;
    }

    // User not connected
    if( ($user = isConnected()) == null ) { 
        echo json_code(0); 
        return;
    }
    
    $filters = array();
    if($_POST["name"])  $filters["name"] = $_POST["name"];
    if($_POST["firstname"])  $filters["firstname"] = $_POST["firstname"];
    if($_POST["nickname"])  $filters["nickname"] = $_POST["nickname"];

    require_once("..\DAO\FriendsDAO.php");
    // No results for the research
    if( ($results = UserDAO::getUsersByFilter($_SESSION["token"]), $filters) == "" ) {
        echo json_code(2); 
        return;
    }

    echo json_code(1, array("friends", $results) );
?>