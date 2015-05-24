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
    if( (LikeDAO::getLikeByPublicationAndIdUser($publication, $user->getUser())) == "") {
        LikeDAO::createLike($user->getUser(), $GET["publication"]);
    }
    else {
        LikeDAO::deleteLike()
    }
    
    $publi = PubliDAO::createNewPubli($user);
    CommentDAO::createNewComment($_POST["content"], $publi, $_POST["post"]);
   
    echo json_code(1);
?>