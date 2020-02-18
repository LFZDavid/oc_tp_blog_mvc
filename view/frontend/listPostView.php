
<?php $title = 'Mon blog'; ?>

<?php ob_start();?>

<p>Derniers billets du blog :</p>
<div id="news_affichees" class='news'>
	<?php
	
		while($data = $posts->fetch())
		{
		?>
	<h3>
		<?php echo''.$data['titre'].' : '.$data['id'] .$data['date_creation_fr'].'';?>				
	</h3>
	<p><?php echo ''.$data['contenu'].'';?><br>
		<em><a href="index.php?action=post&amp;id=<?php echo ''.$data['id'].'';?>">Commentaires</a></em>
	</p>
	<p>
	<?php
	}
		$index = getIndexPage();
		for ($i = 0; $i < $index; $i++){
	?>
		<a href="index.php?page=<?php echo$i+1;?>"><?php echo$i+1;?></a>	
	<?php
		}
	?>
	</p>
	
</div>
<?php $content = ob_get_clean(); ?>

<?php require ('view/frontend/template.php'); ?>