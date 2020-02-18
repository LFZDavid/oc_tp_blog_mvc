<?php

// On charge le fichier du modele
require('model/frontend.php');

function getIndexPage(){
	$nb_posts = getPostsCount();
	$index = ($nb_posts) / 5;
	return $index ;
	require('view/frontend/listPostView.php');
}

function listPosts($offset){
	$posts = getPosts($offset);
	require('view/frontend/listPostView.php');
}

function post(){
	// On récupère le post et ses comments
	$post = getPost($_GET['id']);
	$comments = getComments($_GET['id']);
	// On appelle la vue pour afficher les données
	require('view/frontend/postView.php');
}

function addComment($postId, $author, $content){

	//On test s'il y'a eu une erreur
	$affectedLines = postComment($postId, $author, $content);
	if ($affectedLines === false){
		 // Erreur gérée. Elle sera remontée jusqu'au bloc try du routeur !
        throw new Exception('Impossible d\'ajouter le commentaire !');
	}
	else{
		// si pas d'erreur, on retourne sur la page du post
		header('Location: index.php?action=post&id='.$postId);
	}
} 

function checkAndAddUser($name, $pwd, $pwd_verif, $mail){
	
	$Errorname = $Errormail = $Errorpwd_verif = $Errormail_preg = '';
	$Form_valide = 'true';
	
	// Vérif du name
	$isNameExist = isNameExist($name);
	if(!empty($isNameExist)){
		$Form_valide = false;
		$Errorname = 'Ce pseudo n\'est pas dispo !<br>';
	}
	// Vérif wpd
	if($pwd !== $pwd_verif){
		$Form_valide = false;
		$Errorpwd_verif = 'La vérification ne correspond pas au mot de passe !<br>';
	}
	// Vérif mail
	if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)<=0){
		$Form_valide = false;
		$Errormail = 'Ceci n\'est pas une adresse mail<br>';
	}
	else{
		$isMailExist = isMailExist($mail); // affiche false si vide...
		if(!empty($isMailExist)){
			$Form_valide = false;
			$Errormail_preg = 'Cette adresse mail n\'est pas dispo !<br>';
		}
	}	

	if ($Form_valide){
		$pwd_hashed = password_hash($pwd, PASSWORD_DEFAULT);
		insertNewUser($name, $pwd_hashed, $mail);
		echo'Vous êtes inscrit !<br>';
		sessionConnect($name, $pwd);
	}
	else{
		require('view/frontend/signup.php');
	}
	
}

function sessionConnect($name, $pwd){
	$name = htmlspecialchars($name);
	$member_infos = getMemberInfos($name);
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
