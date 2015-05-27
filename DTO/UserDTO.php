<?php
    class User {
        private $idUser;
        private $name;
        private $firstname;
        private $email;
        private $phone;
        private $homePlace;
        private $login;
        
        public function __construct($id, $name, $firstname, $email, $phone, $homePlace = null, $login) {
            $this->setIdUser($id);
            $this->setName($name);
            $this->setFirstname($firstname);
            $this->setEmail($email);
            $this->setPhone($phone);
            $this->setHomePlace($homePlace);
            $this->setLogin($login);
        }
        
        public function setIdUser($id) { $this->idUser = $id; }
        public function setName($name) { $this->name = $name; }
        public function setFirstname($fname) { $this->firstname = $fname; }
        public function setEmail($email) { $this->email = $email; }
        public function setPhone($phone) { $this->phone = $phone; }
        public function setHomePlace($home) { $this->homePlace = $home; }
        public function setLogin($login) { $this->login = $login; }
        
        public function getIdUser() { return $this->idUser; }
        public function getName() { return $this->name; }
        public function getFirstname() { return $this->firstname; }
        public function getEmail() { return $this->email; }
        public function getPhone() { return $this->phone==""?null:$this->phone;  }
        public function getHomePlace() { return $this->phone==""?null:$this->homePlace; }
        public function getLogin() { return $this->login; }
        
        public function __toString() { return $this->name; }
    }
?>