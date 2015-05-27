<?php
    require_once("..\DTO\UserDTO.php");


    class TagDAO extends BaseDAO {
            
        public static function createNewTag($idUser, $publication) {
            $dao = new self();
            $params = array(":idUser" => $idUser, ":publication" => $publication, ":type" => "USER");
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`tag` (`user` ,`publication`, `type`) VALUES (:idUser, :publication, :type);");
            $result->execute($params);
            
            return $dao->pdo->lastInsertId();
        }
        
        public static function createNewHashtag($value, $publication) {
            $dao = new self();
            $params = array(":value" => $value, ":publication" => $publication, ":type" => "HASHTAG");
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`tag` (`value` ,`publication`, `type`) VALUES (:value, :publication, :type);");
            $result->execute($params);
            
            return $dao->pdo->lastInsertId();
        }
        
        public static function getTagByIdUserAndPublication($idUser, $publication, $type = "USER") {
            $dao = new self();
            $params = array(":idUser" => $idUser, ":publication" => $publication);
            $result = $dao->pdo->prepare("SELECT * FROM tag WHERE user = :idUser AND publication = :publication AND type = 'USER';");
            
            if($result && $result->execute($params)) {
                return $result->fetch(PDO::FETCH_ASSOC);
            }
        }

        public static function getTagsByIdUser($idUser, $type = "USER") {
            $dao = new self();
            $params = array(":idUser" => $idUser);
            $result = $dao->pdo->prepare("SELECT * FROM tag WHERE user = :idUser AND type = 'USER';");
            
            if($result && $result->execute($params)) {
                return $result->fetchAll();
            }
        }
        
        public static function getHashtagByValueAndPublication($value, $publication, $type = "HASHTAG") {
            $dao = new self();
            $params = array(":value" => $value, ":publication" => $publication);
            $result = $dao->pdo->prepare("SELECT * FROM tag WHERE value = :value AND publication = :publication AND type = 'HASHTAG';");
            
            if($result && $result->execute($params)) {
                return $result->fetch(PDO::FETCH_ASSOC);
            }
        }
        
        public static function getTagsForPublication($idPubli, $type = "USER") {
            $dao = new self();
            $request = "SELECT tag.user FROM tag 

            INNER JOIN publication pub ON tag.publication = pub.idPublication
            
            WHERE type = :type AND idPublication = :id;";
            
            $result = $dao->pdo->prepare($request);
            $result->bindValue(':id', $idPubli, PDO::PARAM_STR); 
            $result->bindValue(':type', $type, PDO::PARAM_STR);     
                
            $tags = array();
            if($result && $result->execute()) { 
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $tags[] = $row;
                }
            }
            
            if(count($tags))
                return $tags;
            
            return null;    
        }
        
        
        public static function createTagsWithIdLIst($ids, $publication, $type = "USER") {
            foreach($ids as $id) {
                if(TagDAO::getTagByIdUserAndPublication($id, $publication) == "" ) {
                    self::createNewTag($id, $publication, $type); 
                }
            }
        }
        
        public static function createHashtagsWithIdLIst($values, $publication, $type = "HASHTAG") {
            foreach($values as $value) {
                if(TagDAO::getHashtagByValueAndPublication($value, $publication) == "") {
                    self::createNewHashtag($value, $publication, $type);  
                } 
            }
        }
        public static function deleteTagsByPublication($idPub){
            $dao = new self();
            $params = array(":publication" => $idPub);
            $result = $dao->pdo->prepare("DELETE FROM `api-php`.`tag`
                    WHERE `publication` = :publication;");
            
            $result->execute($params);
            
        }

        public static function deleteTagById($idTag){
            $dao = new self();
            $params = array(":idTag" => $idTag);
            $result = $dao->pdo->prepare("DELETE FROM `api-php`.`tag`
                    WHERE `idTag` = :idTag;");
            
            $result->execute($params);
            
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>