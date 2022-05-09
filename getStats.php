<?php
include 'functions.php';
include 'connexiondb.php';
$conn = connectDBasAdmin();
// Démarrage de la session pour créer les variables $_SESSION
session_start();
if (isset($_SESSION["admin"])) {
    // On définit un login et un mot de passe de base pour tester notre exemple. Cependant, vous pouvez très bien interroger votre base de données afin de savoir si le visiteur qui se connecte est bien membre de votre site
    try {

        //DEBUT RECHERCHE DES SESSIONS
        // Requête sql de recherche des sessions liées à l'username dans la DB
        $sql = "select count(*)/(select count(*) from SESSIONUSER)*100 as y, USEROS as label from SESSIONUSER group by USEROS";

        // Préparation de la requête
        $stmt = $conn->prepare($sql);

        // Attribution des paramètres de la requête préparée
        //$stmt->bindValue(':osuser', "Windows", PDO::PARAM_STR, 50);

        // Exécution de la requête
        $stmt->execute();

        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($rs);

        //FIN RECHERCHE DES SESSIONS

    } catch (PDOException $e) {
        echo "Connection failed PHP";
    }
}