<?php
    require_once("..\DTO\CommentDTO.php");
    require_once("BaseDAO.php");

    class LikeDAO extends BaseDAO{
            
        public static function createLike($userId, $publication) {
            $dao = new self();
            
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`hasLiked` (`publication`, `user`) VALUES (:publication, :user);");
            $result->bindValue(':publication', (int) $publication, PDO::PARAM_INT);      
            $result->bindValue(':user', (int) $userId, PDO::PARAM_INT);      
            $result->execute();
            
            return $dao->pdo->lastInsertId();
        }
        
        public static function deleteLike($hasLiked) {
            $dao = new self();
            
            $result = $dao->pdo->prepare("DELETE FROM `api-php`.`hasLiked` WHERE idHasLiked = :hasLiked;");
            $result->bindValue(':hasLiked', (int) $hasLiked, PDO::PARAM_INT);           
            $result->execute();
        }
        
        public static function getLikeByIdLike($idLike) {
            $dao = new self();
            
            $result = $dao->pdo->prepare("SELECT * FROM `hasLiked` WHERE `idHasLiked` = :idHasLiked;");
            $result->bindValue(':publication', (int) $idLike, PDO::PARAM_INT);          
            $result->execute();
            
            if($result && $result->execute()) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                
                return $row;
            }
        }
        
        public static function getLikeByPublicationAndIdUser($publication, $idUser) {
            $dao = new self();
            
            $result = $dao->pdo->prepare("SELECT * FROM `hasLiked` WHERE `publication` = :publication AND `user` = :user;");
            $result->bindValue(':publication', (int) $publication, PDO::PARAM_INT);    
            $result->bindValue(':user', (int) $idUser, PDO::PARAM_INT);   
            $result->execute();
            
            if($result && $result->execute()) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                
                return $row;
            }
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>