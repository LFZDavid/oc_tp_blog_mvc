<?php $title = 'Mon blog';?>
<?php ob_start(); ?>

<h1>Mon super blog</h1>
<p><a href="index.php">Retour à la liste des posts</a></p>
<p>Derniers posts</p>

<div class="news">
	<h3>
		<?php echo htmlspecialchars($post['titre']);?>
		<em>le <?php echo htmlspecialchars($post['date_creation_fr']);?></em>
	</h3>

	<p>
		<?php echo htmlspecialchars($post['contenu']);?>
	</p>
</div>




<h2>Commentaires :</h2>
<?php
while ($comment = $comments->fetch()){

	echo '<p><strong>'.$comment['auteur'].': </strong>';
	echo '<em>'.$comment['date_comments'].'</em><br>';
	echo ''.$comment['commentaire'].'</p>';
}

$comments->closeCursor();
?>
<h2>Poster un commentaire</h2>
<div>
	<form action="index.php?action=addComment&amp;id=<?=$post['id']?>" method="post">
		<p>
		<label for="author">Pseudo</label>
		<input id="author" type="text" name="author">
		</p>
		<label for='content'>Commentaire</label>
		<textarea type="text" id="content" name="content">
		</textarea>
		</p>
		<input type="submit" name="Envoyer">
	</form>
</div>

<?php 
$content = ob_get_clean(); 
require ('view/frontend/template.php'); 
?>

