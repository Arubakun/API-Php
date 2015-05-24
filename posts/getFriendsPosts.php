<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // Params missing
    if( !isset($_GET["offset"]) || !isset($_GET["limit"]) ) {  
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
    if( ( $friends = FriendsDAO::getFriendsForUserByIdUser($_SESSION["token"])) == "") {
        echo json_code(2); 
        return;
    }

    require_once("..\DAO\PubliDAO.php");
    require_once("..\DAO\PostDAO.php");
    
    $posts = PostDAO::getTimelineByIdUser($user->getIdUser(), $_GET["offset"], $_GET["limit"]);

    echo json_code(1, array("posts", $posts));
?>