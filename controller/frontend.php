<?php

require('model/frontend.php');


// POST
function getIndexPage(){
	$postManager = new postManager();
	$nb_posts = $postManager->getPostsCount();

	$index = ($nb_posts) / 5;
	return $index ;
	require('view/frontend/listPostView.php');
}

function listPosts($offset){

	$postManager = new postManager();
	$posts = $postManager->getPosts($offset);

	require('view/frontend/listPostView.php');
}

function post(){

	$postManager = new postManager();
	$commentManager = new commentManager();

	$post = $postManager->getPost($_GET['id']);
	$comments = $commentManager->getComments($_GET['id']);

	require('view/frontend/postView.php');
}


// COMMENTS
function addComment($postId, $author, $content){

	$postId = htmlspecialchars($postId);
	$author = htmlspecialchars($author);
	$content = htmlspecialchars($content);

	$commentManager = new commentManager();
	$commentManager->postComment($postId, $author, $content);

	if ($commentManager === false){
        throw new Exception('Impossible d\'ajouter le commentaire !');
	}
	else{
		header('Location: index.php?action=post&id='.$postId);
	}
} 

function comment(){
	$commentManager = new commentManager();
	$comment = $commentManager->getComment($_GET['id_comment']);

	require ('view/frontend/commentView.php');
}

function updateComment($postId, $id_comment, $new_comment){
	
	$id_comment = htmlspecialchars($id_comment);
	$new_comment = htmlspecialchars($new_comment);
	$commentManager = new commentManager();
	$updatedComment = $commentManager->updateComment($id_comment, $new_comment);
	header('Location: index.php?action=post&id='.$postId);
}


// USER
function checkAndAddUser($name, $pwd, $pwd_verif, $mail){
	
	$Errorname = $Errormail = $Errorpwd_verif = $Errormail_preg = '';
	$Form_valide = 'true';
	
	$userManager = new userManager();
	$isNameExist = $userManager->isNameExist($name);
	
	if(!empty($isNameExist)){
		$Form_valide = false;
		$Errorname = 'Ce pseudo n\'est pas dispo !<br>';
	}
	if($pwd !== $pwd_verif){
		$Form_valide = false;
		$Errorpwd_verif = 'La vérification ne correspond pas au mot de passe !<br>';
	}
	if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)<=0){
		$Form_valide = false;
		$Errormail = 'Ceci n\'est pas une adresse mail<br>';
	}
	else{

		$userManager = new userManager();
		$isMailExist = $userManager->isMailExist($mail); 
		if(!empty($isMailExist)){
			$Form_valide = false;
			$Errormail_preg = 'Cette adresse mail n\'est pas dispo !<br>';
		}
	}	

	if ($Form_valide){
		$pwd_hashed = password_hash($pwd, PASSWORD_DEFAULT);
		$userManager = new userManager();
		$userManager->insertNewUser($name, $pwd_hashed, $mail);
		echo'Vous êtes inscrit !<br>';
		sessionConnect($name, $pwd);
	}
	else{
		require('view/frontend/signup.php');
	}
	
}

// SESSION
function sessionConnect($name, $pwd){
	$name = htmlspecialchars($name);
	$userManager = new userManager();
	$member_infos = $userManager->getMemberInfos($name);
	if (!empty($member_infos)){
		$is_password_correct = password_verify($pwd, $member_infos['pwd']);
		if ($is_password_correct){
			$_SESSION['name'] = $name;
			$_SESSION['pwd'] = $pwd;
			echo 'Vous êtes connecté !';
			require ('view/frontend/profile.php');
		}
		else{
		echo 'le login ou mot de passe incorrect !';
		require 'view/frontend/login.php';
		}
	}
	else{
		echo 'le login ou mot de passe incorrect !';
		require 'view/frontend/login.php';
	}
}
