<?php
    require_once("..\DTO\UserDTO.php");

    class TagDAO extends BaseDAO {
        protected $pdo; 
        private $dao;
        protected function __construct() {
            $this->pdo = new PDO("mysql:host=localhost;dbname=API-Php", "root", "toor");
        }
            
        public function getPDO() {return $this->pdo;}
    }
?>