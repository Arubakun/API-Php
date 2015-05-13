<?php
    require_once("..\session.php");
    $out = array();
    
    if( !isset($_GET["friend"]) ) {  
        $out["code"] = -1;
        echo json_encode($out); 
        return;
    }

    if( ($user = isConnected()) == null ) { 
        echo "friend => ".$user;
        $out["code"] = 0;
        echo json_encode($out); 
        return;
    }
    
    require_once("..\DAO\UserDAO.php");
    if( ($friend = UserDAO::getUserByLoginID($_GET["friend"])) == null) {
        $out["code"] = 2;
        echo json_encode($out); 
        return;
    }

    require_once("..\DAO\FriendsDAO.php");
    if( FriendsDAO::alreadyHasFriend($user, $friend) ) {
        $out["code"] = 3;
        echo json_encode($out); 
        return;
    }

    if( $ask = FriendsDAO::alreadyHasFriend($friend, $user) ) {
        
        FriendsDAO::updateHasFriendStatus($ask, "OK");
        $out["code"] = 4;
        echo json_encode($out); 
        return;
    }

    FriendsDAO::askFriend($user, $friend);        
    $out["code"] = 1;
        
    echo json_encode($out);
?>