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
        
        public static function getIdLoginByNickname($nickname) {
            $dao = new self();
            $params = array(":nickname" => $nickname);
            $result = $dao->pdo->prepare("SELECT idLogin FROM login WHERE nickname = :nickname;");
            
            if($result && $result->execute($params)) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                
                return $row["idLogin"];
            }
        }
            
        public static function createNewLogin($nickname, $password) {
            $dao = new self();
            $params = array(":nickname" => $nickname, ":password" => $password);
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`login` (`idLogin` ,`nickname` ,`password`) VALUES (NULL , :nickname, :password);");
            $result->execute($params);
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>