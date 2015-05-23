<?php
    require_once("..\DTO\PubliDTO.php");
    require_once("BaseDAO.php");

    class PubliDAO extends BaseDAO{            
        public static function createNewPubli($author) {
            $dao = new self();
            $params = array(":author" => $author->getIdUser());
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`publication` (`idPublication` ,`author`, `created`, `update`) VALUES (NULL , :author, NOW(), NOW());");
            $result->execute($params);
            
            return $dao->pdo->lastInsertId();
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>