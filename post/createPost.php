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
    
    require_once("..\DAO\PubliDAO.php");
    require_once("..\DAO\PostDAO.php");
    
    $publi = PubliDAO::createNewPubli($user);
    $asks = PostDAO::createNewPost($_POST["title"], $_POST["content"], $publi);
   
    echo json_code(1);
?>