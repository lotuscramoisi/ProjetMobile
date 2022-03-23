<?php
// Fonction de connection à une BDD
function connectDB($host, $bdname, $user, $pass){
	try {
		$bdd = new PDO('mysql:host=' . $host .';dbname=' . $bdname . ';charset=utf8', $user, $pass);
	} 
	catch(Exception $e){
		die('Erreur : '.$e->getMessage());
	}
	return $bdd;
}

?>