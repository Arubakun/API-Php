<?php
    require_once("..\DTO\UserDTO.php");

    class UserDAO {
        private $pdo; 
        private $dao;
        private function __construct() {
            $this->pdo = new PDO("mysql:host=localhost;dbname=API-Php", "root", "toor");
        }
        
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
        
        public static function updateUser($user) {
            $dao = new self();
            $params = array(":idUser" => $user->getIdUser(), ":name" => $user->getName(), ":firstname" => $user->getFirstname(), ":email" => $user->getEmail(), ":phone" => $user->getPhone(), ":login" => $user->getLogin());
            $result = $dao->pdo->prepare("UPDATE 'api-php'.'user' SET `name` = :name, `firstname` = :firstname, `email` = :email, `phone` = :phone, `homePlace` = :homePlace, `friends` = :friends, `hasLiked` = :hasLiked 
            WHERE idUser = :idUser;");
            
            $result->execute($params);
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>