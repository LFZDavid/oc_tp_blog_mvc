<?php

// On charge le fichier du modele
require ('controller/frontend.php');

try { // On essaie de faire des choses

	// On teste le paramètre action pour savoir quel contrôleur appeler.
	if (isset ($_GET['action'])) {
		if ($_GET['action'] == 'lastPosts'){
			listPosts(0);
		}
		elseif ($_GET['action'] == 'post'){
		
			// On vérifie la valeur indiquée 
			if (isset($_GET['id']) && $_GET['id'] > 0){
				post();
			}
			else{
				// Erreur ! On arrête tout, on envoie une exception, donc au saute directement au catch
                throw new Exception('Aucun identifiant de billet envoyé');
			}
		}
		elseif ($_GET['action'] == 'addComment'){
			if (isset($_GET['id']) && $_GET['id'] > 0){
				if (!empty($_POST['author']) && !empty($_POST['content'])){
					$postId = htmlspecialchars($_GET['id']);
					$author = htmlspecialchars($_POST['author']);
					$content = htmlspecialchars($_POST['content']);
					addComment($postId, $author, $content);
				}
				else{
					// Autre exception
                    throw new Exception('Tous les champs ne sont pas remplis !');
				}
			}
			else{
				// Autre exception
                throw new Exception('Aucun identifiant de billet envoyé');
			}
		}
		elseif ($_GET['action'] == 'addUser') {
			// Verification du nom
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
	// Si aucun controleur n'est appelé on charge la liste des posts
	elseif (isset($_GET['page']) && $_GET['page'] >= 0){
			
			$page = htmlspecialchars($_GET['page']);
			$offset = ($page - 1) * 5;
			listPosts($offset);
	}
	else{
		listPosts(0);
	}
}
catch(Exception $e) { // S'il y a eu une erreur, alors...
    echo 'Erreur : ' . $e->getMessage();
    
}



?>
