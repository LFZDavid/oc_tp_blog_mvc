<?php

require_once("model/manager.php");

class commentManager extends manager{

	public function getComments($postId){
	$bdd = dbconnect();

	// Affichage des commentaires d'un post
	$comments = $bdd->prepare('SELECT id_billet, auteur, commentaire, DATE_FORMAT(date_commentaire,\'%d/%m%Y à %Hh%imin%ss\') AS date_comments FROM commentaires WHERE id_billet = ? ORDER BY date_comments DESC');
	$comments->execute(array($postId));

	return $comments;
	$comments->closeCursor();
	}


	public function postComment($postId, $author, $content){
	$bdd = dbconnect();

	$new_comment = $bdd->prepare('INSERT INTO commentaires(id_billet, auteur, commentaire)
		VALUES(:id_billet, :auteur, :commentaire)');
	$affectedLines = $new_comment->execute(array('id_billet'=>$postId,
		'auteur'=>$author,
		'commentaire'=>$content));

	return $affectedLines;
	$new_comment->closeCursor();
	}

}