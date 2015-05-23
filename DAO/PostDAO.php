<?php
    require_once("..\DTO\PostDTO.php");
    require_once("BaseDAO.php");

    class PostDAO extends BaseDAO{
            
        public static function createNewPost($title, $content, $publi) {
            $dao = new self();
            $params = array(":title" => $title, ":content" => $content, ":publication" => $publi);
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`post` (`idPost` ,`title` ,`content`, `publication`) VALUES (NULL , :title, :content, :publication);");
            $result->execute($params);
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>