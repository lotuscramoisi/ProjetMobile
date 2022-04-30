<?php
include 'functions.php';
include 'connexiondb.php'; 
$conn = connectDBasAdmin();

try {
    // Récupération des informations du formulaire + vérification de leur intégrité via test_input
    $username=test_input($_POST["username"]);
    $permission = test_input($_POST["permission"]);
    //DEBUT UPDATE ADMIN
    // Requête sql de recherche des sessions liées à l'username dans la DB
    $sql = "update USER set ISADMIN = :permission where USERNAME like :username";

    // Préparation de la requête
    $stmt = $conn->prepare($sql);

    // Attribution des paramètres de la requête préparée
    $stmt->bindParam(':username', $username, PDO::PARAM_STR, 25);
    if($permission == false){
        $stmt->bindParam(':permission', 0, PDO::PARAM_INT);
    }
    else{
        $stmt->bindParam(':permission', 1, PDO::PARAM_INT);
    }

    // Exécution de la requête
    $stmt->execute();

    //FIN UPDATE ADMIN
    
}
    
catch(PDOException $e) {
   echo "Connection failed PHP";
}
?>