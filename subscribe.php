<?php
    // If one of the field is empty 
    if( !isset($_POST["login"]) || !isset($_POST["password"]) ) { return -1; }

    $pdo = new PDO("mysql:host=localhost;dbname=API-Php", "root", "toor");
    $params = array(":login" => $_POST["login"], ":pwd" => $_POST["password"]);
    $result = $pdo->prepare("SELECT pseudo, password, idLogin FROM login WHERE pseudo = :login AND :pwd = password;");

    if($result && $result->execute($params)) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        
        session_unset();
        $_SESSION["idLogin"] = $row["idLogin"];
        
        echo "CONNECTED";
        return $row["idLogin"];
    }
?>