<?php
include 'functions.php';
include 'connexiondb.php'; 
$conn = connectDBasAdmin();

// Démarrage de la session pour créer les variables $_SESSION
session_start();
if (isset($_SESSION["admin"])) {
    try {
        //DEBUT RECHERCHE DES UTILISATEURS
        // Préparation de la requête
        $stmt = $conn->prepare("select * from USER");

        // Exécution de la requête
        $stmt->execute();

        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo utf8_encode(json_encode($rs));

        //FIN RECHERCHE DES UTILISATEURS
        
    }
        
    catch(PDOException $e) {
    echo "Connection failed PHP";
    }
}
?>