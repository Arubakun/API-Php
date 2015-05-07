<?php
    require_once("DAO/userDTO.php");

    class UserDAO {
        private $pdo; 
        private function __construct() {
            $this->pdo = = new PDO("mysql:host=localhost;dbname:API-Php", "root", toor);
        }
        
        public static function getUserByLoginID($logId) {
            $params = array(":logId" => $logId);
            $result = $pdo->prepare("SELECT * FROM user WHERE loginId = :logId;");

            if($result && $result->execute($params)) {
         
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $user = new UserDTO($row["id"], $row["name"], $row["firstname"], $row["email"], $row["phone"], $row["homePlace"], $row["friends"], $row["hasLiked"], $row["login"]);
                
                return $user;
            }
        }
    }
?>