<?php

class manager {
	
	protected function dbconnect(){
		$bdd = new PDO('mysql:host=localhost;dbname=oc_tp_blog;charset=utf8','root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		return $bdd;
	}
}