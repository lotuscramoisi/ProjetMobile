<?php
include 'functions.php';
include 'connexiondb.php';
$conn = connectDBasAdmin();

try {
    // Récupération des informations AJAX
    $username = $_POST["username"];
    $connexionTime = $_POST["connexionTime"];
    $deviceType = $_POST["type"];

    //DEBUT AJOUT DONNEES SESSION
    // Requête sql d'ajout des données de session
    $sql = "INSERT INTO SESSIONUSER(USERNAME, CONNEXIONTIME) VALUES (:username, now())";

    // Préparation de la requête
    $stmt = $conn->prepare($sql);

    // Attribution des paramètres de la requête préparée
    $stmt->bindParam(':username', $username, PDO::PARAM_STR, 25);
    $stmt->bindParam(':connexionTime', $connexionTime, PDO::PARAM_STR, 50);

    // Exécution de la requête
    $stmt->execute();
    //FIN AJOUT DONNEES SESSION

} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
//fermer la connexion pour libérer les ressources du serveur
$conn = null;


?>