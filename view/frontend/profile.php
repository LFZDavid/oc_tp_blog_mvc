<?php $title = 'Profile';?>
<?php ob_start();?>


<h1>Mon profil</h1>

<div id="my-profil">

	<img src="" alt="avatar">
	<h2><?php echo $member_infos['name'];?></h2>
	<h2><?php echo $member_infos['mail'];?></h2>
	<h2><?php echo $member_infos['date_inscription'];?></h2>
	<h2><?php echo $member_infos['avatar'];?></h2>
	
</div>
<?php 
$content = ob_get_clean(); 
require ('template.php');
?>