<?php
include 'connexiondb.php'; 

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

//Fonction pour vérifier si l'adresse mail est déjà utilisée à l'inscription

function isMailUsed($email){

	//Connexion à la BD
	$conn = connectDBasAdmin();

	// Requête sql
    $sql = "select * from USER where USERMAIL like binary :email";
    
    // Préparation de la requête
    $stmt = $conn->prepare($sql);

    // Attribution des paramètres de la requête préparée
    $stmt->bindParam(':email', $email, PDO::PARAM_STR, 50);
    
    // Exécution de la requête
    $stmt->execute();

    //Si la requête renvois un résultat c'est que le login et mot de pass existe dans le bdd
    if($stmt->fetch()){
		return true;
    }
	return false;
}
?>