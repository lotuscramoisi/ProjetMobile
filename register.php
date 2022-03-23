<?php
include 'functions.php';
include 'connexiondb.php';
$conn = connectDBasAdmin();

try {
    // Récupération des informations du formulaire + vérification de leur intégrité via test_input
    $email = test_input($_POST["email"]);
    $username = test_input($_POST["username"]);
    $psw = test_input($_POST["password"]);
    $pswverif = test_input($_POST["passwordverif"]);
    // Hachage du mot de passe
    $psw = password_hash($psw, PASSWORD_DEFAULT);

    // Requête sql de recherche de l'adresse mail dans la DB
    $sqlrecherche = "select * from USER where USERMAIL like binary :email";

    // Préparation de la requête
    $stmtsearch = $conn->prepare($sqlrecherche);

    // Attribution des paramètres de la requête préparée
    $stmtsearch->bindParam(':email', $email, PDO::PARAM_STR, 50);

    // Exécution de la requête
    $stmtsearch->execute();

    //Si l'adresse mail n'existe pas dans la DB on valide l'inscription
    if (!$stmtsearch->fetchColumn()) {
        // Requête sql d'insertion des données de l'inscription
        $sql = "INSERT INTO USER(USERNAME, USERPSW, USERMAIL, SIGNUPDATE, ISADMIN) VALUES (:username, :psw, :email, now(), false)";

        // Préparation de la requête
        $stmt = $conn->prepare($sql);

        // Attribution des paramètres de la requête préparée
        $stmt->bindParam(':username', $username, PDO::PARAM_STR, 25);
        $stmt->bindParam(':psw', $psw, PDO::PARAM_STR, 100);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR, 25);

        // Exécution de la requête
        $stmt->execute();
    }
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
//fermer la connexion pour libérer les ressources du serveur
$conn = null;

header("Location: $_SERVER[HTTP_REFERER]");
?>