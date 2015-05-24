<?php
    class Post {
        private $idPost;
        private $title;
        private $content;
        private $publication;
        
        public function __construct($idPost, $title, $content, $publication) {
            $this->setIdPost($idPost);
            $this->setTitle($title);
            $this->setContent($content);
            $this->setPublication($publication);
        }
        
        public function setIdPost($id) { $this->idPost = $id; }
        public function setTitle($title)  { $this->title = $title; }
        public function setContent($content) { $this->content = $content; }
        public function setPublication($publication) { $this->publication = $publication; }
        
        public function getIdPost() { return $this->idUser; }
        public function getTitle() { return $this->title; }
        public function getContent() { return $this->content; }
        public function getPublication() { return $this->publication; }
    }
?>