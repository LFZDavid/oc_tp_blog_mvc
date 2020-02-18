<?php $title = 'Signup';?>
<?php ob_start();?>

<?php $title = 'Login';?>
<h1>Login</h1>

<div id="login-form">
	<form action="/oc_tp_blog_mvc/index.php?action=login" method="post">
		<p>
			<label for="name"></label>
			<input type="text" name="name">
		</p>
		<p>
			<label for="pwd"></label>
			<input type="password" name="pwd">
		</p>
		<p>
			<input type="submit" name="Connexion">
		</p>

	</form>
</div>
<?php 
$content = ob_get_clean(); 
require ('template.php');
?>