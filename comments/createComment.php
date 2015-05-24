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

    require_once("..\DAO\PubliDAO.php");
    require_once("..\DAO\CommentDAO.php");
    
    $publi = PubliDAO::createNewPubli($user);
    CommentDAO::createNewComment($_POST["content"], $publi, $_POST["post"]);
   
    echo json_code(1);
?>