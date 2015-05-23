<?php
    class Publication {
        private $idPublication;
        private $author;
        private $place;
        private $created;
        private $update;
        
        public function __construct($author, $place = null) {
            $this->setAuthor($author);
            $this->setPlace($place);
        }
        
        public function setIdPublication($id) { $this->idPublication = $id; }
        public function setAuthor($author)  { $this->author = $author; }
        public function setPlace($place) { $this->place = $place; }
        public function setCreated($created) { $this->created = $created; }
        public function setUpdate($update) { $this->update = $update; }
        
        public function getIdPublication() { return $this->idUser; }
        public function getAuthor() { return $this->author; }
        public function getPlace() { return $this->place; }
        public function getCreated() { return $this->created; }
        public function getUpdate() { return $this->update; }
    }
?>