<?php

require_once("model/manager.php");

class commentManager extends manager{

	public function getComments($postId){
	$bdd = $this->dbconnect();

	$comments = $bdd->prepare('SELECT id AS id_comment, id_billet, auteur, commentaire, DATE_FORMAT(date_commentaire,\'%d/%m%Y à %Hh%imin%ss\') AS date_comments FROM commentaires WHERE id_billet = ? ORDER BY date_comments DESC');
	$comments->execute(array($postId));

	return $comments;
	$comments->closeCursor();
	}

	public function getComment($id_comment){
		$bdd = $this->dbconnect();

		$comment = $bdd->prepare('SELECT id, id_billet AS id_post, auteur, commentaire, DATE_FORMAT(date_commentaire,\'%d/%m%Y à %Hh%imin%ss\') AS date_comment FROM commentaires WHERE id = ?');
		$comment->execute(array($id_comment));
		$comment = $comment->fetch();
		
		return $comment;
		$commnet->closeCursor();
	}


	public function postComment($postId, $author, $content){
	$bdd = $this->dbconnect();

	$new_comment = $bdd->prepare('INSERT INTO commentaires(id_billet, auteur, commentaire)
		VALUES(:id_billet, :auteur, :commentaire)');
	$affectedLines = $new_comment->execute(array('id_billet'=>$postId,
		'auteur'=>$author,
		'commentaire'=>$content));

	return $affectedLines;
	$new_comment->closeCursor();
	}

	public function updateComment($id_comment, $new_comment){
		$bdd = $this->dbconnect();

		$updateComment = $bdd->prepare('UPDATE commentaires SET commentaire = :new_comment WHERE id = :id_comment');
		$updateComment->execute(array(
			'new_comment' => $new_comment,
			'id_comment' => $id_comment));
	}

}