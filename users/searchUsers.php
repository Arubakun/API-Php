<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // Params missing
    if( !isset($_POST["offset"]) && !isset($_POST["limit"]) ) {  
        echo json_code(-1);
        return;
    }

    // User not connected
    if( ($user = isConnected()) == null ) { 
        echo json_code(0); 
        return;
    }
    
    $filters = array();
    if( isset($_POST["name"]) )  $filters["name"] = $_POST["name"];
    if( isset($_POST["firstname"]) ) $filters["firstname"] = $_POST["firstname"];
    if( isset($_POST["nickname"]) )  $filters["nickname"] = $_POST["nickname"];

    require_once("..\DAO\FriendsDAO.php");
    // No results for the research
    if( ($results = UserDAO::getUsersByFilter($_SESSION["token"], $filters, $_POST["offset"], $_POST["limit"])) == "" ) {
        echo json_code(2); 
        return;
    }

    echo json_code(1, array("users", $results) );
?>