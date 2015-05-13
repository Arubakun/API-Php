<?php
    require_once("..\DTO\UserDTO.php");

    class FriendsDAO extends BaseDAO{
        
        public static function alreadyHasFriend($user, $friend) {
            $dao = new self();
            $params = array(":idUser" => $user->getIdUser(), ":idFriend" => $friend->getIdUser());
            $result = $dao->pdo->prepare("SELECT idHasFriend FROM hasfriend WHERE `friend1` = :idUser AND `friend2` = :idFriend;");
            $result->execute($params);
            
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row["idHasFriend"];

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
            $result = $dao->pdo->prepare("UPDATE hasFriend SET `status` = :status WHERE idHasFriend = :id;");
            $result->execute($params);
        }
                
        public function getPDO() {return $this->pdo;}
    }
?>