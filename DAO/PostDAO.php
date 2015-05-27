<?php
    require_once("..\DTO\PostDTO.php");
    require_once("BaseDAO.php");
    require_once("CommentDAO.php");

    class PostDAO extends BaseDAO{
            
        public static function createNewPost($title, $content, $publication, $tags) {
            $dao = new self();
            
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`post` (`title` ,`content`, `publication`) VALUES (:title , :content, :publication);");
            $result->bindValue(':title', $title, PDO::PARAM_STR); 
            $result->bindValue(':content', $content, PDO::PARAM_STR); 
            $result->bindValue(':publication', (int) $publication, PDO::PARAM_INT);      
            $result->execute();
            
            return $dao->pdo->lastInsertId();
        }
        
        public static function updatePost($idPost, $modifs) {
            $dao = new self();
            
            $request = "UPDATE `post` SET";
            
            $size = count($modifs) - 1;
            foreach($modifs as $k => $v) {
                $request = $request." `".$k."`s = '".$v;
                if($size--) { $request = $request.","; }
            }
            
            $request = $request." WHERE idPost = ".$idPost.";"; 

            $result= $dao->pdo->prepare($request);
            $result->execute();
        }
        
        public static function getPostByIdPost($idPost) {
            $dao = new self();
            
            $params = array("idPost" => $idPost);
            $result= $dao->pdo->prepare("SELECT * FROM post WHERE idPost = :idPost;");
            $result->execute($params);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            
            if($row)
                return new Post($row["idPost"], $row["title"], $row["content"], $row["publication"]);
            
            return null;            
        }
        
        public static function getPostsByIdUser($idUser) {
            $dao = new self();
            
            $params = array(":idUser" => $idUser);
            $result= $dao->pdo->prepare("SELECT `post`.*, `publication`.`created` FROM `post` INNER JOIN `publication` ON `publication`.`idPublication` = `post`.`publication` WHERE `publication`.`author` = :idUser ORDER BY `publication`.`created`;");
            
            $posts = array();
            if($result && $result->execute($params)) {                
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $posts[] = array($row["idPost"], $row["title"], $row["content"], $row["publication"], $row["created"]);
                }
            }
            
            if(count($posts))
                return $posts;
            
            return null;    
        }
        
        public static function getTimelineByIdUser($idUser, $offset = 0, $limit = 30) {
            $dao = new self();
            
            $result= $dao->pdo->prepare("SELECT post.*, pub.created 
            FROM post 

            INNER JOIN `publication` pub ON pub.idPublication = post.publication

            WHERE pub.author IN
            (
                SELECT DISTINCT idUser 
                FROM user u
                INNER JOIN hasFriend hf ON 
                (hf.friend1 = :idUser OR hf.friend2 = :idUser) 
                AND (u.idUser = hf.friend1 OR u.idUser = hf.friend2) 

                WHERE hf.status = 'OK'
            )

            ORDER BY pub.created
            LIMIT :limit OFFSET :offset;");
            $result->bindValue(':idUser', (int) $idUser, PDO::PARAM_INT); 
            $result->bindValue(':offset', (int) $offset, PDO::PARAM_INT); 
            $result->bindValue(':limit', (int) $limit, PDO::PARAM_INT);              
            
            $posts = array();
            if($result && $result->execute()) {                
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $posts[] = array($row["idPost"], $row["title"], $row["content"], $row["publication"], $row["created"]);
                }
            }
            
            if(count($posts))
                return $posts;
            
            return null;    
        }

        public static function deletePost($idPost){
            $dao = new self();
            CommentDAO::deleteCommentByPost($idPost);
            $params = array(":idPost" => $idPost);
            $result = $dao->pdo->prepare("DELETE FROM `api-php`.`post`
                    WHERE `idPost` = :idPost;");
            
            $result->execute($params);
            
        }
        
        public function getPDO() {return $this->pdo;}
    }
?>