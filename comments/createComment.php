<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // Params missing
    if( !isset($_POST["post"]) || !isset($_POST["content"]) ) {  
        echo json_code(-1);
        return;
    }

    // User not connected
    if( ($user = isConnected()) == null ) { 
        echo json_code(0); 
        return;
    }
    
    $tags = array();
    if(isset($_POST["tags"])) {
        $tags = explode(",", $_POST["tags"]);
    }

    $hashtags = array();
    if(isset($_POST["hashtags"])) {
        $hashtags = explode(",", $_POST["hashtags"]);
    }

    require_once("..\DAO\TagDAO.php");
    require_once("..\DAO\PubliDAO.php");
    require_once("..\DAO\CommentDAO.php");
    require_once("..\DAO\NotificationDAO.php");
    
    $publi = PubliDAO::createNewPubli($user);
    CommentDAO::createNewComment($_POST["content"], $publi, $_POST["post"]);
   
    TagDAO::createTagsWithIdLIst($tags, $publi);
    TagDAO::createHashtagsWithIdLIst($hashtags, $publi);
    if( count($tags) )    NotificationDAO::createNotificationsWithIdList($tags, "TAG COMMENT ".$publi, $publi);
   
    $author = PubliDAO::getIdAuthorForPost($_POST["post"]);
    NotificationDAO::createNewNotification($author, "RESPONSE ".$_POST["post"], $publi);

    if(($tags = TagDAO::getTagsForPublication($_POST["post"]))!= "") {
        NotificationDAO::createNotificationsWithIdList($tags, "RESPONSE COMMENT ".$_POST["post"], $publi);
    }

    echo json_code(1);
?>