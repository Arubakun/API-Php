<?php
    function loadUser($pdo, $id) {
        require_once("DTO/user.php");
        
        $params = array(":login" => $id);
        $result = $pdo->prepare("SELECT * FROM user WHERE login = :login;");
        
        if($result && $result->execute($params)) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $user = new User((int)$row["idUser"], $row["name"], $row["firstname"], $row["email"], $row["phone"], (int)$row["homePlace"], (int)$row["friends"], (int)$row["hasLiked"], (int)$row["login"]);

            echo $user;
            $_SESSION["userInfo"] = serialize($user);
        }
    }

    // If one of the field is empty 
    if( !isset($_POST["login"]) || !isset($_POST["password"]) ) { return -1; }

    $pdo = new PDO("mysql:host=localhost;dbname=API-Php", "root", "toor");
    $params = array(":login" => $_POST["login"], ":pwd" => $_POST["password"]);
    $result = $pdo->prepare("SELECT pseudo, password, idLogin FROM login WHERE pseudo = :login AND :pwd = password;");

    if($result && $result->execute($params)) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        
        session_start();
        session_unset();
        $_SESSION["userInfo"] = loadUser($pdo, $row["idLogin"]);
        
        
        echo "CONNECTED";
        return 1;
    }
?>