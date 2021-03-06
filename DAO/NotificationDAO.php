<?php
    require_once("..\DTO\CommentDTO.php");
    require_once("BaseDAO.php");

    class NotificationDAO extends BaseDAO{
            
        public static function createNewNotification($user, $type, $publication = null) {
            $dao = new self();
            
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`notification` (`user`, `type`, `created`, `publication`) VALUES (:user, :type, NOW(), :publication);");
            $result->bindValue(':user', (int)$user, PDO::PARAM_INT); 
            $result->bindValue(':publication', $publication, PDO::PARAM_STR);      
            $result->bindValue(':type', $type, PDO::PARAM_STR);      
            $result->execute();
            
            return $dao->pdo->lastInsertId();
        }
        
        public static function getNotifByIdUserAndIdPublication($user, $publication) {
            $dao = new self();
            
            $params = array(":user" => $user, ":publication" => $publication);
            $result= $dao->pdo->prepare("SELECT * FROM `notification` WHERE `user` = :user AND `publication` = :publication;");
            $result && $result->execute($params);
            
            if($row = $result->fetch(PDO::FETCH_ASSOC)) { 
                return $row;
            }
            
            return null;
        }
        
        public static function getNotifByIdUserAndType($user, $type) {
            $dao = new self();
            
            $params = array(":user" => $user, ":type" => $type);
            $result= $dao->pdo->prepare("SELECT * FROM `notification` WHERE `user` = :user AND `type` = :type;");
            $result && $result->execute($params);
            
            if($row = $result->fetch(PDO::FETCH_ASSOC)) { 
                return $row;
            }
            
            return null;
        }
        
        public static function createNotificationsWithIdList($ids, $type, $publication) {
            foreach($ids as $id) {
                self::createNewNotification($id, $type, $publication);
            }
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>