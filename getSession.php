<?php
include 'functions.php';
include 'connexiondb.php';
$conn = connectDBasAdmin();
if (isset($_SESSION["login"])) {
    // On définit un login et un mot de passe de base pour tester notre exemple. Cependant, vous pouvez très bien interroger votre base de données afin de savoir si le visiteur qui se connecte est bien membre de votre site
    try {
        // Récupération des informations du formulaire + vérification de leur intégrité via test_input
        $login = test_input($_POST["login"]);


        //DEBUT RECHERCHE DES SESSIONS
        // Requête sql de recherche des sessions liées à l'username dans la DB
        $sql = "select * from SESSIONUSER where USERNAME like :login";

        // Préparation de la requête
        $stmt = $conn->prepare($sql);

        // Attribution des paramètres de la requête préparée
        $stmt->bindParam(':login', $login, PDO::PARAM_STR, 25);

        // Exécution de la requête
        $stmt->execute();

        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo utf8_encode(json_encode($rs));

        //FIN RECHERCHE DES SESSIONS

    } catch (PDOException $e) {
        echo "Connection failed PHP";
    }
}
