<?php
//TO DO : linker le delete user avec toutes les autres tables qui sont liées avec le login
	require_once("../json.php");
	$out = array();
	
	if(!isset($_GET["nickname"])) {
		echo json_code(-1, array("token", null)); 
        return;
	}
	require_once("..\DAO\UserDAO.php");
	require_once("..\DAO\LoginDAO.php");

	$login = LoginDAO::getIdLoginByNickname($_GET["nickname"]);

	if(null == $login) {
        echo json_code(0, array("token", null));
        return;
    }
	
	UserDAO::deleteUser($idLog);
	UserDAO::deleteLogin($idLog);
	

	echo json_code(1);
?>