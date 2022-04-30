<?php
include 'functions.php';
include 'connexiondb.php'; 
$conn = connectDBasAdmin();
// On définit un login et un mot de passe de base pour tester notre exemple. Cependant, vous pouvez très bien interroger votre base de données afin de savoir si le visiteur qui se connecte est bien membre de votre site
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
?>