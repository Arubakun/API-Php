<?php
    require_once("..\DTO\UserDTO.php");

    class FriendsDAO extends BaseDAO{
        
        public static function alreadyHasFriend($user, $friend) {
            $dao = new self();
            $params = array(":idUser" => $user->getIdUser(), ":idFriend" => $friend->getIdUser());
            $result = $dao->pdo->prepare("SELECT idHasFriend FROM hasFriend WHERE (friend1 = :idUser AND friend2 = :idFriend) OR (friend2 = :idUser AND friend1 = :idFriend);");
            $result->execute($params);
        }
        
        public static function askFriend($user, $friend) {
            $dao = new self();
            $params = array(":idUser" => $user->getIdUser(), ":idFriend" => $friend->getIdUser());
            $result = $dao->pdo->prepare("INSERT INTO hasFriend (friend1, friend2, status) VALUES (:idUser, :idFriend, 'ASK');");
            $result->execute($params);
        }
        
        public static function updateHasFriendStatus($id, $status) {
            $dao = new self();
            $params = array(":id" => $id, ":status" => $status);
            $result = $dao->pdo->prepare("UPDATE hasFriend SET (status = :status) WHERE idHasFriend = :id");
            $result->execute($params);
        }
                
        public function getPDO() {return $this->pdo;}
    }
?>