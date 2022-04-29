<?php
include 'functions.php';
include 'connexiondb.php'; 
$conn = connectDBasAdmin();

try {
    // Récupération des informations du formulaire + vérification de leur intégrité via test_input
    $login=test_input($_POST["login"]);
    $sessiontime=test_input($_POST["sessiontime"]);

    
    //DEBUT DELETE SESSION
    // Requête sql de recherche des sessions liées à l'username dans la DB
    $sql = "delete from SESSIONUSER where USERNAME like :login and CONNEXIONTIME = :sessionTime";

    // Préparation de la requête
    $stmt = $conn->prepare($sql);

    // Attribution des paramètres de la requête préparée
    $stmt->bindParam(':login', $login, PDO::PARAM_STR, 25);
    $stmt->bindParam(':sessionTime', $sessiontime, PDO::PARAM_STR);

    // Exécution de la requête
    $stmt->execute();

    //FIN DELETE SESSION
    
}
    
catch(PDOException $e) {
   echo "Connection failed PHP";
}
?>