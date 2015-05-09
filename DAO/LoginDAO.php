<?php
    require_once("..\DTO\UserDTO.php");

    class LoginDAO {
        private $pdo; 
        private $dao;
        private function __construct() {
            $this->pdo = new PDO("mysql:host=localhost;dbname=API-Php", "root", "toor");
        }
        
        public static function getIdLoginByNickname($nickname) {
            $dao = new self();
            $params = array(":nickname" => $nickname);
            $result = $dao->pdo->prepare("SELECT idLogin FROM login WHERE nickname = :nickname;");
            
            if($result && $result->execute($params)) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                
                return $row["idLogin"];
            }
        }
        
        public static function createNewLogin($login, $password) {
            $dao = new self();
            $params = array(":nickname" => $nickname, ":password" => $password);
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`login` (`idLogin` ,`pseudo` ,`password`) VALUES (NULL , :nickname, :password);");
            $result->execute($params);
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>