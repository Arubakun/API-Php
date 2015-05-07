<?php
    class User {
        private $idUser;
        private $name;
        private $firstname;
        private $email;
        private $phone;
        private $homePlace;
        private $friends;
        private $hasLiked;
        private $login;
        
        public function __construct($id, $name, $firstname, $email, $phone, $homePlace = null, $friends = null, $hasLiked = null, $login) {
            $this->setIdUser($id);
            $this->setName($name);
            $this->setFirstname($firstname);
            $this->setEmail($email);
            $this->setPhone($phone);
            $this->setHomePlace($homePlace);
            $this->setFriends($friends);
            $this->setHasLiked($hasLiked);
            $this->setLogin($login);
        }
        
        public function setIdUser($id) { $this->idUser = $id; }
        public function setName($name) { $this->name = $name; }
        public function setFirstname($fname) { $this->firstname = $fname; }
        public function setEmail($email) { $this->email = $email; }
        public function setPhone($phone) { $this->phone = $phone; }
        public function setHomePlace($home) { $this->homePlace = $home; }
        public function setFriends($friends) { $this->friends = $friends; }
        public function setHasLiked($hasLiked) { $this->hasLiked = $hasLiked; }
        public function setLogin($login) { $this->login = $login; }
        public function __toString() { return $this->name; }
    }
?>