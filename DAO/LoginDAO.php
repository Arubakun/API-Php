<?php
    require_once("..\DTO\UserDTO.php");
    require_once("BaseDAO.php");

    class LoginDAO extends BaseDAO{
        
        public static function existLoginById($id) {
            $dao = new self();
            $params = array(":id" => $id);
            $result = $dao->pdo->prepare("SELECT idLogin FROM login WHERE idLogin = :id;");
            
            if($result && $result->execute($params)) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                
                return $row["idLogin"];
            }
        }
        
        public static function getLoginByNickname($nickname) {
            $dao = new self();
            $params = array(":nickname" => $nickname);
            $result = $dao->pdo->prepare("SELECT idLogin, password FROM login WHERE nickname = :nickname;");
            
            if($result && $result->execute($params)) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                
                return $row;
            }
        }
            
        public static function createNewLogin($nickname, $password) {
            $dao = new self();
            $params = array(":nickname" => $nickname, ":password" => $password);
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`login` (`nickname` ,`password`) VALUES (:nickname, :password);");
            $result->execute($params);
            
            return $dao->pdo->lastInsertId();
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>