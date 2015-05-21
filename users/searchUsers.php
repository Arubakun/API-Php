<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // idHasFriend missing
    if( false ) {  
        echo json_code(-1);
        return;
    }

    // User not connected
    if( ($user = isConnected()) == null ) { 
        echo json_code(0); 
        return;
    }
    
    require_once("..\DAO\FriendsDAO.php");
    // User doesn't have any friend
    if( ($hasFriends = FriendsDAO::getFriendsForUserByIdUser($_SESSION["token"])) == "") {
        echo json_code(2); 
        return;
    }

    $user = UserDAO::getUserIdByLoginID($_SESSION["token"]);
    $friends = array();
    foreach($hasFriends as $k => $v) {
        $id = $v["friend1"]==$user?$v["friend2"]:$v["friend1"];
        $friends[] = $id;
    }

    echo json_code(1, array("friends", $friends) );
?>