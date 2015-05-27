<?php
    require_once("..\DTO\CommentDTO.php");
    require_once("BaseDAO.php");

    class CommentDAO extends BaseDAO{
            
        public static function createNewComment($content, $publication, $post) {
            $dao = new self();
            
            $result = $dao->pdo->prepare("INSERT INTO `api-php`.`comment` (`content`, `publication`, `post`) VALUES (:content, :publication, :post);");
            $result->bindValue(':content', $content, PDO::PARAM_STR); 
            $result->bindValue(':publication', (int) $publication, PDO::PARAM_INT);      
            $result->bindValue(':post', (int) $post, PDO::PARAM_INT);      
            $result->execute();
            
            return $dao->pdo->lastInsertId();
        }
        
        public static function updateComment($idComment, $modifs, $tags = null) {
            $dao = new self();
            
            $request = "UPDATE `comment` SET";
            
            $size = count($modifs) - 1;
            foreach($modifs as $k => $v) {
                $request = $request." `".$k."` = '".$v."'";
                if($size--) { $request = $request.","; }
            }
            
            $request = $request." WHERE `idComment` = ".$idComment.";"; 
            echo $request;

            $result= $dao->pdo->prepare($request);
            $result->execute();
        }
        
        public static function getCommentByIdComment($idComment) {
            $dao = new self();
            
            $params = array(":idComment" => $idComment);
            $result= $dao->pdo->prepare("SELECT * FROM `comment` WHERE `idComment` = :idComment;");
            $result && $result->execute($params);
            
            if($row = $result->fetch(PDO::FETCH_ASSOC)) { 
                return new Comment($row["idComment"], $row["content"], $row["publication"], $row["post"]);
            }
            
            return null;
        }

        public static function deleteComment($idComment){
            $dao = new self();
            $params = array(":idComment" => $idComment);
            $result = $dao->pdo->prepare("DELETE FROM `api-php`.`comment`
                    WHERE `idComment` = :idComment;");
            
            $result->execute($params);
        }

        public static function deleteCommentByPost($idPost){
            $dao=new self();
            $params = array(":post" => $idPost);
            $result = $dao->pdo->prepare("DELETE FROM `api-php`.`comment`
                    WHERE `post` = :post;");
            
            $result->execute($params);

        }
        
        public function getPDO() {return $this->pdo;}
    }
?>