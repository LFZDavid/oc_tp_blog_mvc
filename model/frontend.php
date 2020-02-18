<?php

session_start();

function dbconnect(){
		$bdd = new PDO('mysql:host=localhost;dbname=oc_tp_blog;charset=utf8','root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		return $bdd;
}

function getPosts($offset){
	$bdd = dbconnect();

	// Affichage des articles sans pagination
	$req = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation,\'%d/%m%Y à %Hh%imin%ss\') AS date_creation_fr 
		FROM billets ORDER BY date_creation 
		DESC LIMIT :offset, 5');
	$req->bindParam(':offset', $offset, PDO::PARAM_INT);
	$req->execute();

	return $req;
	$req->closeCursor();
}

// Récupération d'un post
function getPost($postId) {
	$bdd = dbconnect();

	$req = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation,\'%d/%m%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets WHERE id = ?');
	$req->execute(array($postId));
	$post = $req->fetch();

	return $post;
	$req->closeCursor();
}

// Récupération des commentaires d'un post
function getComments($postId){
	$bdd = dbconnect();

	// Affichage des commentaires d'un post
	$comments = $bdd->prepare('SELECT id_billet, auteur, commentaire, DATE_FORMAT(date_commentaire,\'%d/%m%Y à %Hh%imin%ss\') AS date_comments FROM commentaires WHERE id_billet = ? ORDER BY date_comments DESC');
	$comments->execute(array($postId));

	return $comments;
	$comments->closeCursor();
}

function postComment($postId, $author, $content){
	$bdd = dbconnect();

	$new_comment = $bdd->prepare('INSERT INTO commentaires(id_billet, auteur, commentaire)
		VALUES(:id_billet, :auteur, :commentaire)');
	$affectedLines = $new_comment->execute(array('id_billet'=>$postId,
		'auteur'=>$author,
		'commentaire'=>$content));

	return $affectedLines;
	$new_comment->closeCursor();
}

function getPostsCount(){
	$bdd = dbconnect();

	$nb_posts = $bdd->query('SELECT COUNT(*) AS nb_posts FROM billets');
	$nb_posts = $nb_posts->fetch();

	 return $nb_posts['nb_posts'];
}

function insertNewUser($name, $pwd, $mail){
	$bdd = dbconnect();

	$new_membre = $bdd->prepare('INSERT INTO membre(name, pwd, mail, date_inscription) VALUES(:pseudo, :pwd, :mail, CURDATE())');
	$new_membre->execute(array(
		'pseudo'=>$name,
		'pwd'=>$pwd,
		'mail'=>$mail));
	$new_membre->closeCursor();
}

function isNameExist($name_to_test){
	$bdd = dbconnect();

	$req = $bdd->prepare('SELECT * FROM membre WHERE name = ?');
	$req->execute(array($name_to_test));
	$result = $req->fetch();

	return $result;
	$req->closeCursor();
}

function isMailExist($mail_to_test){
	$bdd = dbconnect(); 

	$req = $bdd->prepare('SELECT * FROM membre WHERE mail = ?');
	$req->execute(array($mail_to_test));
	$result = $req->fetch();
	
	return $result;
	$req->closeCursor();
}

function getMemberInfos ($name){
	$bdd = dbconnect();

	$req = $bdd->prepare('SELECT * FROM membre WHERE name = ?');
	$req->execute(array($name));
	$member_infos = $req->fetch();

	return $member_infos;
	$req->closeCursor();
}
