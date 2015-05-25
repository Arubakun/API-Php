<?php
    require_once("..\DTO\PubliDTO.php");
    require_once("BaseDAO.php");

    class PubliDAO extends BaseDAO{            
        public static function createNewPubli($author) {
            $dao = new self();
            $params = array(":author" => $author->getIdUser());
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`publication` (`author`, `created`, `update`) VALUES (:author, NOW(), NOW());");
            $result->execute($params);
            
            return $dao->pdo->lastInsertId();
        }
        
        public static function updatePublication($idPubli) {
            $dao = new self();
            
            $request = "UPDATE `publication` SET `update` = NOW() WHERE idPublication = ".$idPubli.";";

            $result= $dao->pdo->prepare($request);
            $result->execute();
        }
        
        public static function getPublicationsForLikes($idUser, $offset = 0, $limit = 30) {
            $dao = new self();
            
            $request = "SELECT pub.*, count(hl.`idHasLiked`) as nbLikes

            FROM `publication` pub
            LEFT JOIN `hasLiked` hl ON hl.`publication` = pub.`idPublication`

            WHERE pub.`author` = :idUser
            GROUP BY `idPublication`
            ORDER BY nbLikes DESC
            LIMIT :limit
            OFFSET :offset;";

            $result= $dao->pdo->prepare($request);
            $result->bindValue(':idUser', (int)$idUser, PDO::PARAM_INT);
            $result->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $result->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            
            $publications = array();
            if($result && $result->execute()) {
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $publications[] = $row; 
                }
            }
            
            if(count($publications))
                return $publications;
            
            return null;
        }
        
        public static function getUsersForPublications($offset = 0, $limit = 30) {
            $dao = new self();
            
            $request = "SELECT u.*, count(pub.`idPublication`) as nbPublications

            FROM `user` u
            LEFT JOIN `publication` pub ON pub.`author` = u.`idUser`

            GROUP BY `idUser`
            ORDER BY nbPublications DESC
            LIMIT :limit
            OFFSET :offset;";

            $result= $dao->pdo->prepare($request);
            $result->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $result->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            
            $users = array();
            if($result && $result->execute()) {
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $users[] = $row; 
                }
            }
            
            if(count($users))
                return $users;
            
            return null;
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>