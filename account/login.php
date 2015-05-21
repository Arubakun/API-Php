<?php
    require_once("../json.php");
    $out = array();

    if( !isset($_POST["nickname"]) || !isset($_POST["password"]) ) { 
        echo json_code(-1, array("token", null)); 
        return;
    }

    require_once("..\session.php");
    require_once("..\DAO\loginDAO.php");
 
    $login = LoginDAO::getLoginByNickname($_POST["nickname"]);

    if(null == $login) {
        echo json_code(0, array("token", null));
        return;
    }
    
    if($_POST["password"] != $login["password"]) {
        
        echo json_code(2, array("token", null));
        return;   
    }    
        
    connect($login["idLogin"]);    
    echo json_code(1, array("token", $login["idLogin"]));
?>