<?php $title = 'Mon blog';?>
<?php ob_start(); ?>

<h1>Mon super blog</h1>
<p><a href="/oc_tp_blog_mvc/index.php">Retour à la liste des posts</a></p>

<h2>Commentaire :</h2>

<p>
	<strong><?php echo''.$comment['auteur'].'';?></strong>
	<em><?php echo''.$comment['date_comment'].'';?><br></em>
	<?php echo ''.$comment['commentaire'].'';?>

</p>


<h2>Modifier le commentaire</h2>
<div>
	<form action="/oc_tp_blog_mvc/index.php?action=updateComment&amp;id_comment=<?php echo''.$comment['id'].'';?>&amp;post=<?php echo''.$comment['id_post'].''?>" method="post">
		<label for='content'>Commentaire</label>
		<textarea type="text" id="content" name="content"></textarea>
		</p>
		<input type="submit" name="Envoyer">
	</form>
</div>

<?php 
$content = ob_get_clean(); 
require ('view/frontend/template.php'); 
?>

