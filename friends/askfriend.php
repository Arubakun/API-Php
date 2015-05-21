<?php
    require_once("..\json.php");
    require_once("..\session.php");
    $out = array();
    
    // idUser of friend missing
    if( !isset($_GET["friend"]) ) {  
        echo json_code(-1);
        return;
    }

    // User not connected
    if( ($user = isConnected()) == null ) { 
        echo json_code(0); 
        return;
    }

    // Same id as the logged user
    if( $_GET["friend"] == $_SESSION["token"] ) {  
        echo json_code(-2);
        return;
    }
    
    require_once("..\DAO\UserDAO.php");
    // Friend doesn't exist
    if( ($friend = UserDAO::getUserByUserID($_GET["friend"])) == null) {
        echo json_code(2); 
        return;
    }
    
    require_once("..\DAO\FriendsDAO.php");
    // There is already a hasFriend with this friend
    if( $ask = FriendsDAO::alreadyHasFriend($user, $friend) ) {
        
        // Status ASK
        if($ask["status"] == "ASK") {
            if($ask["friend2"] == $user->getIdUser()) {
                FriendsDAO::updateHasFriend($ask, "OK");
                echo json_code(5); 
                return;
            }
            
            echo json_code(3); 
            return;
        }
        
        // Status OK
        if($ask["status"] == "OK") {
            echo json_code(4); 
            return;
        }
        
        if($ask["status"] == "NO") {
            FriendsDAO::updateHasFriend($ask["idHasFriend"], "ASK", $user->getIdUser(), $friend->getIdUser());
            echo json_code(1);
            return;
        }
    }
    
    FriendsDAO::askFriend($user, $friend);                
    echo json_code(1);
?>