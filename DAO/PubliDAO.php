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
        
        public static function getIdAuthorForPost($idPubli) {
            $dao = new self();
            
            $request = "SELECT `author` FROM `publication` INNER JOIN `post` ON idPublication = publication WHERE `idPost` = :id;";

            $result= $dao->pdo->prepare($request);
            $result->bindValue(':id', (int)$idPubli, PDO::PARAM_INT);
            
            if($result && $result->execute()) {
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    return $row["author"]; 
                }
            }
            
            
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
        
        public static function getFriendPublicationsForHashtag($idUser, $hashtag, $offset = 0, $limit = 30) {
            $dao = new self();
            $request = "SELECT pub.* FROM publication pub 

            INNER JOIN tag ON tag.publication = pub.idPublication

            WHERE pub.author IN
            (
                SELECT DISTINCT u.idUser
                FROM user u
                INNER JOIN hasFriend hf ON 
                (hf.friend1 = :idUser OR hf.friend2 = :idUser) 
                AND (u.idUser = hf.friend1 OR u.idUser = hf.friend2) 

                WHERE hf.status = 'OK'
            )
            AND tag.value = :hashtag
            
            LIMIT :limit 
            OFFSET :offset;";
            
            $result = $dao->pdo->prepare($request);
            $result->bindValue(':idUser', $idUser, PDO::PARAM_STR); 
            $result->bindValue(':hashtag', $hashtag, PDO::PARAM_STR); 
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
        
        public function getPDO() {return $this->pdo;}
    }
?>