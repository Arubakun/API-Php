<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // Params missing
    if( !isset($_POST["post"]) ) {  
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
    if( ($post = PostDAO::getPosttByIdPost($_POST["post"])) == null ) {
        echo json_code(2); 
        return;
    }


    
    PostDAO::deletePost($_POST["post"]);
    PubliDAO::deletePublication($post->getPublication());

    echo json_code(1);
?>