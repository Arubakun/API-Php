<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // Params missing
    if( !isset($_POST["idPost"]) && (!isset($_POST["title"]) || !isset($_POST["content"]) || !isset($_POST["tags"]) || !isset($_POST["hashtags"])) ) {  
        echo json_code(-1);
        return;
    }

    // User not connected
    if( ($user = isConnected()) == null ) { 
        echo json_code(0); 
        return;
    }

    require_once("..\DAO\PostDAO.php");
    require_once("..\DAO\PubliDAO.php");
    // No Post with the specified id
    if( ($post = PostDAO::getPostByIdPost($_POST["idPost"])) == "" ) {
        echo json_code(2); 
        return;
    }

    if(PubliDAO::getIdAuthorForPost($post->getIdPost())!=$user->getIdUser()){
        echo json_code(4); 
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
    if( isset($_POST["title"]) && $post->getTitle() != $_POST["title"] )  $modifs["title"] = $_POST["title"];
    if( isset($_POST["content"]) && $post->getContent() != $post["content"]) $modifs["content"] = $_POST["content"];

    if(count($modifs) < 1) {
        echo json_code(3); 
        return;
    }

    PostDAO::updatePost($_POST["idPost"], $modifs);
    PubliDAO::updatePublication($post->getPublication());

    TagDAO::createTagsWithIdLIst($tags, $publi);
    TagDAO::createHashtagsWithIdLIst($hashtags, $publi);
    echo json_code(1);
?>