<?php
    $out = array();

    if( !isset($_POST["nickname"]) || !isset($_POST["password"]) ) { 
        $out["token"] = null;
        $out["code"] = -1;
        echo json_encode($out); 
        return;
    }

    require_once("..\session.php");
    require_once("..\DAO\loginDAO.php");
 
    $id = LoginDAO::getIdLoginByNickname($_POST["nickname"]);

    if(null == $id) {
        $out["token"] = null;
        $out["code"] = 0;
        echo json_encode($out); 
        return;
    }
        
    connect($id);
    $out["code"] = 1;
    $out["token"] = $id;
        
    echo json_encode($out);
?>