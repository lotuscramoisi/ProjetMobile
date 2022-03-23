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
// Fonction de test d'intégrité des données
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>