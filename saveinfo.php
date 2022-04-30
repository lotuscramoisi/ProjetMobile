<?php
include 'functions.php';
include 'connexiondb.php';
$conn = connectDBasAdmin();

try {
    //DEBUT  Récupération des informations AJAX
    $username = $_POST["username"];
    //On ajoute la date du jour à l'heure récupérée
    $connexionTime = date("Y-m-d ") . $_POST["connexionTime"];
    $deviceType = $_POST["deviceType"];
    $browserName = $_POST["browserName"];
    $operatingSystem = $_POST["operatingSystem"];
    $screenResolution = $_POST["screenResolution"];
    //FIN    Récupération des informations AJAX

    //DEBUT AJOUT DONNEES SESSION
    // Requête sql d'ajout des données de session
    $sql = "INSERT INTO SESSIONUSER(USERNAME, CONNEXIONTIME, DEVICE, USERNAV, USEROS, SCREENRES) VALUES (:username, :connexionTime, :deviceType, :browserName, :operatingSystem, :screenResolution)";

    // Préparation de la requête
    $stmt = $conn->prepare($sql);

    // Attribution des paramètres de la requête préparée
    $stmt->bindParam(':username', $username, PDO::PARAM_STR, 25);
    $stmt->bindParam(':connexionTime', $connexionTime, PDO::PARAM_STR, 50);
    $stmt->bindParam(':deviceType', $deviceType, PDO::PARAM_STR, 15);
    $stmt->bindParam(':browserName', $browserName, PDO::PARAM_STR, 50);
    $stmt->bindParam(':operatingSystem', $operatingSystem, PDO::PARAM_STR, 50);
    $stmt->bindParam(':screenResolution', $screenResolution, PDO::PARAM_STR, 25);
    // Exécution de la requête
    $stmt->execute();
    //FIN AJOUT DONNEES SESSION

} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
//fermer la connexion pour libérer les ressources du serveur
$conn = null;


?>