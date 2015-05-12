<?php
    require_once("..\DTO\UserDTO.php");

    class FriendsDAO extends BaseDAO{
        
        public static function sendAskFriend($user, $friend) {
            $dao = new self();
            $params = array(":idUser" => $user->getIdUser(), ":idFriend" => $friends->getIdUser());
            $result = $dao->pdo->prepare("INSERT INTO hasFriends (user, friends, status) VALUES (:idUser, :idFriend, 'WAIT');");
            $result->execute($params);
        }
                
        public function getPDO() {return $this->pdo;}
    }
?>