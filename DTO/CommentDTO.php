<?php
    class Comment {
        private $idComment;
        private $content;
        private $publication;
        private $post;
        
        public function __construct($idComment, $content, $publication, $post) {
            $this->setIdComment($idComment);
            $this->setContent($content);
            $this->setPublication($publication);
            $this->setPost($post);
        }
        
        public function setIdComment($id) { $this->idComment = $id; }
        public function setContent($content)  { $this->content = $content; }
        public function setPublication($publication) { $this->publication = $publication; }
        public function setPost($post) { $this->post = $post; }
        
        public function getIdComment() { return $this->idUser; }
        public function getContent() { return $this->content; }
        public function getPublication() { return $this->publication; }
        public function getPost() { return $this->post; }
    }
?>