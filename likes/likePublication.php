<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // Params missing
    if( !isset($_GET["publication"]) ) {  
        echo json_code(-1);
        return;
    }

    // User not connected
    if( ($user = isConnected()) == null ) { 
        echo json_code(0); 
        return;
    }

    require_once("..\DAO\LikeDAO.php");
    if( ($hasLiked = LikeDAO::getLikeByPublicationAndIdUser($_GET["publication"], $user->getIdUser())) == "") {
        LikeDAO::createLike($user->getIdUser(), $_GET["publication"]);
    }
    else {
        LikeDAO::deleteLike($hasLiked["idHasLiked"]);
    }
   
    echo json_code(1);
?>