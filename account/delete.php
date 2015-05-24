<?php
// If one of the field is empty
if(!isset($_GET["login"])) {echo "Echec"; return -1; }
require_once("..\DAO\UserDAO.php");
require_once("..\DAO\LoginDAO.php");

$idLog = LoginDAO::getIdLoginByNickname($_GET["login"]);

UserDAO::deleteUser($idLog);

echo "Delete User\n";

UserDAO::deleteLogin($idLog);

echo "Delete login\n";

return 1;
?>