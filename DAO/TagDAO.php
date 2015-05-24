<?php
    require_once("..\DTO\UserDTO.php");

    class TagDAO extends BaseDAO {
            
        public function getPDO() {return $this->pdo;}
    }
?>