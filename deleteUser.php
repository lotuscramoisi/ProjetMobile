<?php
include 'functions.php';
include 'connexiondb.php'; 
$conn = connectDBasAdmin();

try {
    // Récupération des informations du formulaire + vérification de leur intégrité via test_input
    $username=$_POST["username"];

    
    //DEBUT DELETE SESSION
    // Requête sql de recherche des sessions liées à l'username dans la DB
    $sql = "delete from USER where USERNAME like :login";

    // Préparation de la requête
    $stmt = $conn->prepare($sql);

    // Attribution des paramètres de la requête préparée
    $stmt->bindParam(':login', $username, PDO::PARAM_STR, 25);

    // Exécution de la requête
    $stmt->execute();

    //FIN DELETE SESSION
    
}
    
catch(PDOException $e) {
   echo "Connection failed PHP";
}
?>