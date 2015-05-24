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
        
        public static function updatePublication($idPubli) {
            $dao = new self();
            
            $request = "UPDATE `publication` SET `update` = NOW() WHERE idPublication = ".$idPubli.";";

            $result= $dao->pdo->prepare($request);
            $result->execute();
        }
        
        public static function getPostByIdPost($idPost) {
            $dao = new self();
            
            $request = "UPDATE post SET";
            $params = array("idPost" => $idPost);
            $result= $dao->pdo->prepare("SELECT * FROM post WHERE idPost = :idPost;");
            $result->execute($params);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            
            return new Post($row["idPost"], $row["title"], $row["content"], $row["publication"]);
            
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>