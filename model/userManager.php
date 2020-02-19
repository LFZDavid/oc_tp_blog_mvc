<?php
require_once("model/manager.php");

class userManager extends manager{

	public function insertNewUser($name, $pwd, $mail){
		$bdd = $this->dbConnect();

		$new_membre = $bdd->prepare('INSERT INTO membre(name, pwd, mail, date_inscription) VALUES(:pseudo, :pwd, :mail, CURDATE())');
		$new_membre->execute(array(
			'pseudo'=>$name,
			'pwd'=>$pwd,
			'mail'=>$mail));
		$new_membre->closeCursor();
	}

	public function isNameExist($name_to_test){
		$bdd = $this->dbConnect();

		$req = $bdd->prepare('SELECT * FROM membre WHERE name = ?');
		$req->execute(array($name_to_test));
		$result = $req->fetch();

		return $result;
		$req->closeCursor();
	}

	public function isMailExist($mail_to_test){
	$bdd = $this->dbconnect(); 

	$req = $bdd->prepare('SELECT * FROM membre WHERE mail = ?');
	$req->execute(array($mail_to_test));
	$result = $req->fetch();
	
	return $result;
	$req->closeCursor();
	}

	function getMemberInfos ($name){
	$bdd = $this->dbconnect();

	$req = $bdd->prepare('SELECT * FROM membre WHERE name = ?');
	$req->execute(array($name));
	$member_infos = $req->fetch();

	return $member_infos;
	$req->closeCursor();
	}


}