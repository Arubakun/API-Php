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
        
        public static function getHashtagByValueAndPublication($value, $publication, $type = "HASHTAG") {
            $dao = new self();
            $params = array(":value" => $value, ":publication" => $publication);
            $result = $dao->pdo->prepare("SELECT * FROM tag WHERE value = :value AND publication = :publication AND type = 'HASHTAG';");
            
            if($result && $result->execute($params)) {
                return $result->fetch(PDO::FETCH_ASSOC);
            }
        }
        
        public static function createTagsWithIdLIst($ids, $publication, $type = "USER") {
            foreach($ids as $id) {
                echo $id;
                if(TagDAO::getTagByIdUserAndPublication($id, $publication) == "" ) {
                    TagDAO::createNewTag($id, $publication, $type); 
                }
            }
        }
        
        public static function createHashtagsWithIdLIst($values, $publication, $type = "HASHTAG") {
            foreach($values as $value) {
                echo $value;
                if(TagDAO::getHashtagByValueAndPublication($value, $publication) == "") {
                    TagDAO::createNewHashtag($value, $publication, $type);  
                } 
            }
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>