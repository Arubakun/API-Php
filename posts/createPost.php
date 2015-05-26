<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // Params missing
    if( !isset($_POST["title"]) || !isset($_POST["content"]) ) {  
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

    require_once("..\DAO\PubliDAO.php");
    require_once("..\DAO\PostDAO.php");
    require_once("..\DAO\TagDAO.php");
    require_once("..\DAO\NotificationDAO.php");
    
    $publi = PubliDAO::createNewPubli($user);
    PostDAO::createNewPost($_POST["title"], $_POST["content"], $publi, $tags);
    
    TagDAO::createTagsWithIdLIst($tags, $publi);
    TagDAO::createHashtagsWithIdLIst($hashtags, $publi);
    if( count($tags) )    NotificationDAO::createNotificationsWithIdList($tags, "POST", $publi);
   
    echo json_code(1);
?>