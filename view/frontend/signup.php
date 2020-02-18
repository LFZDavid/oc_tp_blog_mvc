<?php $title = 'Signup';?>
<?php ob_start();?>


<h1>Formulaire d'inscription</h1>

<div id="singup-form">
	<form action="/oc_tp_blog_mvc/index.php?action=addUser" method="post">
		<p>
			<label for="name">Pseudo :</label>
			<input type="texte" id="name" name="name">
			<?php if(isset($Errorname)){
				echo $Errorname;
			}?>
		</p>
		<p>
			<label for="pwd">Mot de passe :</label>
			<input type="password" id="pwd" name="pwd">
		</p>
		<p>
			<label for="pwd_verif">Vérification :</label>
			<input type="password" id="pwd_verif" name="pwd_verif">
			<?php if(isset($Errorpwd_verif)){
				echo $Errorpwd_verif;
			}?>
		</p>
		<p>
			<label for="mail">Mail :</label>
			<input type="texte" id="mail" name="mail">
			<?php if(isset($Errormail) || isset($Errormail_preg)){
				echo $Errormail.$Errormail_preg;
			}?>
		</p>
		<p>
			<input type="submit"  name="Envoyer">
		</p>
	</form>
</div>
<?php 
$content = ob_get_clean(); 
require ('template.php');
?>


