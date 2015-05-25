<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // Params missing
    if( !isset($_POST["comment"]) && (!isset($_POST["tags"]) || !isset($_POST["content"])) ) {  
        echo json_code(-1);
        return;
    }

    // User not connected
    if( ($user = isConnected()) == null ) { 
        echo json_code(0); 
        return;
    }

    require_once("..\DAO\CommentDAO.php");
    require_once("..\DAO\PubliDAO.php");
    // No Post with the specified id
    if( ($comment = CommentDAO::getCommentByIdComment($_POST["comment"])) == null ) {
        echo json_code(2); 
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

       
    $modifs = array();
    if( isset($_POST["tags"]) && $comment->getTitle() != $_POST["tags"] )  $modifs["tags"] = $_POST["tags"];
    if( isset($_POST["content"]) && $comment->getContent() != $_POST["content"]) $modifs["content"] = $_POST["content"];

    if(count($modifs) < 1) {
        echo json_code(3); 
        return;
    }

    CommentDAO::updateComment($_POST["comment"], $modifs);
    PubliDAO::updatePublication($comment->getPublication());

    TagDAO::createTagsWithIdLIst($tags, $publi);
    TagDAO::createHashtagsWithIdLIst($hashtags, $publi);
    echo json_code(1);
?>