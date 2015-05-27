<?php
//TO DO : linker le delete user avec toutes les autres tables qui sont liées avec le login
	require_once("../json.php");
	$out = array();
	
	if(!isset($_GET["nickname"])) {
		echo json_code(-1, array("token", null)); 
        return;
	}

	// User not connected
    if( ($user = isConnected()) == null ) { 
        echo json_code(0); 
        return;
    }

	require_once("..\DAO\UserDAO.php");
	require_once("..\DAO\LoginDAO.php");
	require_once("..\DAO\TagDAO.php");
	require_once("..\DAO\CommentDAO.php");
	require_once("..\DAO\PostDAO.php");
	require_once("..\DAO\FriendsDAO.php");
	$login = LoginDAO::getIdLoginByNickname($_GET["nickname"]);

	if(null == $login) {
        echo json_code(0, array("token", null));
        return;
    }
	
    $tags=TagDAO::getTagsByIdUser($user->getIdUser());
    foreach ($tags as $tag)
    	TagDAO::deleteTagById($tag['idTag']);
    $comments=PostDAO::getPostsByIdUser($user->getIdUser());
    foreach ($comments as $comment)
    	PostDAO::deleteComment($comment['idComment']);
    $posts=PostDAO::getPostsByIdUser($user->getIdUser());
    foreach ($posts as $post)
    	PostDAO::deletePost($post['idPost']);
    $friends=FriendsDAO::getHasFriendsForUserByIdUser($user->getIdUser());
    foreach ($friends as $friend)
    	PostDAO::deleteHasFriendById($friend['idHasFriend']);

	//UserDAO::deleteUser($idLog);
	//LoginDAO::deleteLogin($idLog);
	

	echo json_code(1);
?>