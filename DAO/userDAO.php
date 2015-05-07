<?php
    require_once("DTO\UserDTO.php");

    class UserDAO {
        private $pdo; 
        private function __construct() {
            $this->pdo = new PDO("mysql:host=localhost;dbname=API-Php", "root", "toor");
        }
        
        public static function getUserByLoginID($logId) {
            $dao = new self();
            $params = array(":logId" => $logId);
            $result = $dao->pdo->prepare("SELECT * FROM user;");
            
            if($result && $result->execute($params)) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $user = new User($row["idUser"], $row["name"], $row["firstname"], $row["email"], $row["phone"], $row["homePlace"], $row["friends"], $row["hasLiked"], $row["login"]);
                
                return $user;
            }
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>