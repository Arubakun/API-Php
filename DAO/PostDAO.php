<?php
    require_once("..\DTO\PostDTO.php");
    require_once("BaseDAO.php");

    class PostDAO extends BaseDAO{
            
        public static function createNewPost($title, $content, $publi, $tags) {
            $dao = new self();
            
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`post` (`idPost` ,`title` ,`content`, `publication`) VALUES (NULL , :title, :content, :publication);");
            $result->bindValue(':title', $title, PDO::PARAM_STR); 
            $result->bindValue(':content', $content, PDO::PARAM_STR); 
            $result->bindValue(':publication', (int) $publication, PDO::PARAM_INT);      
            $result->execute();
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>