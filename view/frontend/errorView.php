<?php $title = 'Page d\'erreur'; ?>

<?php ob_start();?>

<p>Erreur :</p>


<?php $content = ob_get_clean(); ?>

<?php require ('view/frontend/template.php'); ?>