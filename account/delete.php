<?php
//TO DO : linker le delete user avec toutes les autres tables qui sont li�es avec le login
	require_once("../json.php");
	require_once("../session.php");
	$out = array();

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
	require_once("..\DAO\PubliDAO.php");
	require_once("..\DAO\NotificationDAO.php");
	
    $tags=TagDAO::getTagsByIdUser($user->getIdUser());
    if(count($tags)) {
        foreach ($tags as $tag)
    	   TagDAO::deleteTagById($tag['idTag']);
    }

    $comments=CommentDAO::getCommentsByIdUser($user->getIdUser());

    if(count($comments)) {
    foreach ($comments as $comment)
    	CommentDAO::deleteComment($comment[0]);
    }

    $posts=PostDAO::getPostsByIdUser($user->getIdUser());
    if(count($posts)) {
        foreach ($posts as $post)
            PostDAO::deletePost($post[0]);
    }

    $friends=FriendsDAO::getHasFriendsForUserByIdUser($user->getIdUser());
    if(count($friends) ) {
    foreach ($friends as $friend)
    	FriendsDAO::deleteHasFriendById($friend['idHasFriend']);   
    }

    $notifications=NotificationDAO::getNotifsByIdUser($user->getIdUser());
    if(count($notifications) ) {
    foreach ($notifications as $notification)
    	NotificationDAO::deleteNotification($notification);   
    }

    $publications = PubliDAO::getPublicationsByUser($user->getIdUser());
    if(count($publications) ) {   
    foreach ($publications as $publi) 
    	PubliDAO::deletePublication($publi);   
    }

    LikeDAO::deleteLikesByIdUser($user->getIdUser());
	UserDAO::deleteUser($_SESSION["token"]);
	UserDAO::deleteLogin($_SESSION["token"]);
	

	echo json_code(1);
?>