<?php
require ('controller/frontend.php');

try { 
	
	if (isset ($_GET['action'])) {
		if ($_GET['action'] == 'lastPosts'){
			listPosts(0);
		}
		elseif ($_GET['action'] == 'post'){
		
			if (isset($_GET['id']) && $_GET['id'] > 0){
				post();
			}
			else{
                throw new Exception('Aucun identifiant de billet envoyé');
			}
		}
		elseif ($_GET['action'] == 'comment'){
			if (isset($_GET['id_comment']) && $_GET['id_comment'] > 0){
				comment();
			}
		}
		elseif ($_GET['action'] == 'updateComment'){
			if (!empty($_GET['id_comment']) && 
				!empty($_GET['post'])){
				
				updateComment($_GET['post'],$_GET['id_comment'],$_POST['content']);
			}
		}
		elseif ($_GET['action'] == 'addComment'){
			if (isset($_GET['id']) && $_GET['id'] > 0){
				if (!empty($_POST['author']) && !empty($_POST['content'])){
					addComment($_GET['id'], $_POST['author'], $_POST['content']);
				}
				else{
                    throw new Exception('Tous les champs ne sont pas remplis !');
				}
			}
			else{
                throw new Exception('Aucun identifiant de billet envoyé');
			}
		}
		elseif ($_GET['action'] == 'addUser') {
			$name = htmlspecialchars($_POST['name']);
			$pwd = $_POST['pwd'];
			$pwd_verif = $_POST['pwd_verif'];
			$mail = htmlspecialchars($_POST['mail']);
			checkAndAddUser($name, $pwd, $pwd_verif, $mail);
		}
		elseif ($_GET['action'] == 'login'){
			if (isset($_POST['name']) && isset($_POST['pwd'])){
				sessionConnect($_POST['name'], $_POST['pwd']);
			}

		}
		elseif ($_GET['action'] == 'profile'){
			if (isset($_SESSION['name']) && isset($_SESSION['pwd'])){
				sessionConnect($_SESSION['name'], $_SESSION['pwd']);
			}
			else{
				require ('view/frontend/login.php');
			}
		}

	}
	elseif (isset($_GET['page']) && $_GET['page'] >= 0){
			
			$page = htmlspecialchars($_GET['page']);
			$offset = ($page - 1) * 5;
			listPosts($offset);
	}
	else{
		listPosts(0);
	}
}
catch(Exception $e) { 
    echo 'Erreur : ' . $e->getMessage();
    
}



?>
