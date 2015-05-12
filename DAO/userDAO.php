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
                $user = new User($row["idUser"], $row["name"], $row["firstname"], $row["email"], $row["phone"], $row["homePlace"], $row["friends"], $row["hasLiked"], $row["login"]);
                
                return $user;
            }
        }

        public static function createNewUser($user) {
            $dao = new self();
            $params = array(":name" => $user->getName(), ":firstname" => $user->getFirstname(), ":email" => $user->getEmail(), ":phone" => $user->getPhone(), ":login" => $user->getLogin());
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`user` (`idUser`, `name`, `firstname`, `email`, `phone`, `homePlace`, `friends`, `hasLiked`, `login`) 
            VALUES (NULL, :name, :firstname, :email, :phone, NULL, NULL, NULL, :login);");        
            
            $result->execute($params);
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
            
            echo $request;
            $result= $dao->pdo->prepare($request);
            $result->execute();
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>