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
            $this->setFirstname($fname);
            $this->setEmail($email);
            $this->setPhone($phone);
            $this->setHomePlace($home);
            $this->setFriends($friends);
            $this->setHasLiked($hasLiked);
            $this->setLogin($login);
        }
        
        public setIdUser($id) { $this->idUser = $id }
        public setName($name) { $this->name = $name }
        public setFirstname($fname) { $this->firstname = $fname }
        public setEmail($email) { $this->email = $email }
        public setPhone($phone) { $this->phone = $phone }
        public setHomePlace($home) { $this->homePlace = $home }
        public setFriends($friends) { $this->friends = $friends }
        public setHasLiked($hasLiked) { $this->hasLiked = $hasLiked }
        public setLogin($login) { $this->login = $login }
    }
?>