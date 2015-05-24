<?php
    require_once("..\DTO\UserDTO.php");
    require_once("BaseDAO.php");

    class UserDAO extends BaseDAO{
    
        public static function getUserByLoginID($logId) {
            $dao = new self();
            $params = array(":logId" => $logId);
            $result = $dao->pdo->prepare("SELECT * FROM user WHERE login = :logId;");
            
            if($result && $result->execute($params)) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $user = new User($row["idUser"], $row["name"], $row["firstname"], $row["email"], $row["phone"], $row["homePlace"], $row["login"]);
                
                return $user;
            }
        }
        
        public static function getUserByUserID($id) {
            $dao = new self();
            $params = array(":id" => $id);
            $result = $dao->pdo->prepare("SELECT * FROM user WHERE idUser = :id;");
            
            if($result && $result->execute($params)) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                
                $user = new User($row["idUser"], $row["name"], $row["firstname"], $row["email"], $row["phone"], $row["homePlace"], $row["login"]);
                return $user;
            }
            
            return null;
        }
        
        public static function getUserIdByLoginID($logId) {
            $dao = new self();
            $params = array(":logId" => $logId);
            $result = $dao->pdo->prepare("SELECT idUser FROM user WHERE login = :logId;");
            
            if($result && $result->execute($params)) {
                $row = $result->fetch(PDO::FETCH_ASSOC);                
                return $row["idUser"];
            }
        }

        public static function createNewUser($user) {
            $dao = new self();
            $params = array(":name" => $user->getName(), ":firstname" => $user->getFirstname(), ":email" => $user->getEmail(), ":phone" => $user->getPhone(), ":login" => $user->getLogin());
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`user` (`idUser`, `name`, `firstname`, `email`, `phone`, `homePlace`, `friends`, `hasLiked`, `login`) 
            VALUES (NULL, :name, :firstname, :email, :phone, NULL, NULL, NULL, :login);");        
            
            $result->execute($params);
            return $dao->pdo->lastInsertId();
        }
        
        public static function updateUser($user, $modif) {
            $dao = new self();
            
            $request = "UPDATE user SET";
            
            $size = count($modif) - 1;
            foreach($modif as $k => $v) {
                $request = $request." ".$k." = '".$v."'";
                if($size--) { $request = $request.","; }
            }
            
            $request = $request." WHERE idUser = ".$user->getIdUser().";"; 

            $result= $dao->pdo->prepare($request);
            $result->execute();
        }
        
        public static function getUsersByFilter($id, $filters = null, $offset = 0, $limit = 0) {
            $dao = new self();
            $request = "SELECT u.`idUser`, hf.idHasFriend is not null as isFriend FROM `user` u LEFT JOIN hasFriend hf ON (hf.friend1 = :idUser AND hf.friend2 = u.idUser OR hf.friend2 = :idUser AND hf.friend1 = u.idUser) WHERE u.`idUser` <> :idUser";
            
            if( count($filters) ) {
                foreach($filters as $k => $v) {
                    $request = $request." AND ".$k." LIKE '%".$v."%'";
                }
            }
            
            $request = $request." LIMIT :limit OFFSET :offset ;";
            
            $result = $dao->pdo->prepare($request);
            $result->bindValue(':idUser', $id, PDO::PARAM_STR); 
            $result->bindValue(':offset', (int) $offset, PDO::PARAM_INT); 
            $result->bindValue(':limit', (int) $limit, PDO::PARAM_INT);             
            
            $users = array();
            if($result && $result->execute()) {
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {    
                    $users[$row["idUser"]] = $row["isFriend"];
                }
            }
            
            if(count($users))
                return $users;
                
            return null;
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>