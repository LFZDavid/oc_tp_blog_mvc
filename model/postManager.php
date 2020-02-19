<?php

require_once("model/manager.php");

class PostManager extends manager{

	public function getPosts($offset){
		$bdd = $this->dbConnect();
		$req = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation,\'%d/%m%Y à %Hh%imin%ss\') AS date_creation_fr 
		FROM billets ORDER BY date_creation 
		DESC LIMIT :offset, 5');
		$req->bindParam(':offset', $offset, PDO::PARAM_INT);
		$req->execute();

	return $req;
	$req->closeCursor();
	}


	public function getPost($postId) {
		$bdd = $this->dbConnect();
		$req = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation,\'%d/%m%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets WHERE id = ?');
		$req->execute(array($postId));
		$post = $req->fetch();

		return $post;
		$req->closeCursor();
	}

	public function getPostsCount(){
		$bdd = $this->dbConnect();

		$nb_posts = $bdd->query('SELECT COUNT(*) AS nb_posts FROM billets');
		$nb_posts = $nb_posts->fetch();

	 	return $nb_posts['nb_posts'];

	}
}