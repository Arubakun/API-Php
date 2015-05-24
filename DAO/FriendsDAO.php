<?php
    require_once("..\DTO\UserDTO.php");

    class FriendsDAO extends BaseDAO{
     
        public static function alreadyHasFriend($user, $friend) {
            $dao = new self();
            $params = array(":idUser" => $user->getIdUser(), ":idFriend" => $friend->getIdUser());
            $result = $dao->pdo->prepare("SELECT idHasFriend, status, friend1, friend2 FROM hasfriend WHERE (`friend1` = :idUser AND `friend2` = :idFriend) OR (`friend2` = :idUser AND `friend1` = :idFriend);");
            $result->execute($params);
            
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row;

        }
        
        public static function askFriend($user, $friend) {
            $dao = new self();
            $params = array(":idUser" => $user->getIdUser(), ":idFriend" => $friend->getIdUser());
            $result = $dao->pdo->prepare("INSERT INTO hasFriend (friend1, friend2, status) VALUES (:idUser, :idFriend, 'ASK');");
            $result->execute($params);
        }
        
        public static function updateHasFriend($id, $status, $friend1 = null, $friend2 = null) {
            $dao = new self();
            $params = array(":id" => $id, ":status" => $status);
            if($friend1 != null)    { $params[":friend1"] = $friend1; }
            if($friend2 != null)    { $params[":friend2"] = $friend2; }
            
            $request = "UPDATE hasFriend SET `status` = :status";
    
            if($friend1 != null || $friend2 != null) {
                $request = $request.",";
                if($friend1 != null)    {$request = $request." `friend1` = :friend1 ";} 
                if($friend1 != null && $friend2 != null)    {$request = $request.",";}
                if($friend2 != null)    {$request = $request." `friend2` = :friend2 ";}   
            }
            
            $request = $request." WHERE idHasFriend = :id;";
            $result = $dao->pdo->prepare($request);
            $result->execute($params);
        }
        
        public static function getHasFriendsForUserByIdUser($id, $status = null, $target = 0) {
            $dao = new self();
            $params = array(":idUser" => $id);
            
            $request = "SELECT * FROM hasFriend WHERE ";
            if(0 == $target) {
                $request = $request."(friend2 = :idUser OR friend1 = :idUser)";
            }
            else if(0 < $target){
                $request = $request."friend".$target." = :idUser";
            }
            
            if(null != $status) {
                $params[":status"] = $status;
                $request = $request." AND status = :status";
            }
            $request = $request.";";            
            $result = $dao->pdo->prepare($request);
            
            $asks = array();
            if($result && $result->execute($params)) {                
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $asks[$row["idHasFriend"]] = $row;
                }
            }
            
            if( count($asks) )
                return $asks;
            
            return "";
        }
        
        public static function getFriendsForUserByIdUser($id, $offset = 0, $limit = 30) {
            $dao = new self();
            
            $request = "SELECT DISTINCT u.idUser FROM user u 
                        INNER JOIN hasFriend hf ON ((hf.friend1 = :idUser AND hf.friend2 = u.idUser) OR (hf.friend1 = u.idUser AND hf.friend2 = :idUser))
                        WHERE hf.status = 'OK' LIMIT :limit OFFSET :offset;";  
            
            $result = $dao->pdo->prepare($request);
            $result->bindValue(':idUser', $id, PDO::PARAM_STR); 
            $result->bindValue(':offset', (int) $offset, PDO::PARAM_INT); 
            $result->bindValue(':limit', (int) $limit, PDO::PARAM_INT); 
            
            $asks = array();
            if($result && $result->execute()) {                
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $asks[] = $row["idUser"];
                }
            }
            
            if( count($asks) )
                return $asks;
            
            return "";
        }
                
        public function getPDO() {return $this->pdo;}
    }
?>