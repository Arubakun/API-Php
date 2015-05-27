<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // Params missing
    if( !isset($_POST["comment"]) ) {  
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

    if(PubliDAO::getIdAuthorForComment($comment->getIdComment())!=$user->getIdUser()){
        echo json_code(3); 
        return;
    }

    CommentDAO::deleteComment($_POST["comment"]);
    PubliDAO::deletePublication($comment->getPublication());

    echo json_code(1);
?>