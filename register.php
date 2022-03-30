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

    //DEBUT RECHERCHE DE L'ADRESSEMAIL
    // Requête sql de recherche de l'adresse mail dans la DB
    $sqlrechercheemail = "select * from USER where USERMAIL like binary :email";

    // Préparation de la requête
    $stmtsearchmail = $conn->prepare($sqlrechercheemail);

    // Attribution des paramètres de la requête préparée
    $stmtsearchmail->bindParam(':email', $email, PDO::PARAM_STR, 50);

    // Exécution de la requête
    $stmtsearchmail->execute();
    //FIN RECHERCHE DE L'ADRESSEMAIL

    //DEBUT RECHERCHE DE L'USERNAME
    // Requête sql de recherche de l'adresse mail dans la DB
    $sqlrechercheusername = "select * from USER where USERNAME like binary :username";

    // Préparation de la requête
    $stmtsearchusername = $conn->prepare($sqlrechercheusername);

    // Attribution des paramètres de la requête préparée
    $stmtsearchusername->bindParam(':username', $username, PDO::PARAM_STR, 25);

    // Exécution de la requête
    $stmtsearchusername->execute();
    //FIN RECHERCHE DE L'USERNAME

    //Si l'adresse mail existe dans la DB on renvoie sur la page d'accueil
    if ($stmtsearchmail->fetchColumn()) {
        header('Location: index.php?error=existingmail');
    }
    //Si l'adresse mail existe dans la DB on renvoie sur la page d'accueil
    elseif ($stmtsearchusername->fetchColumn()) {
        header('Location: index.php?error=existingusername');
    }
    //Si l'adresse mail n'existe pas dans la DB on valide l'inscription
    else{
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
        header("Location: $_SERVER[HTTP_REFERER]");
    }

    

} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
//fermer la connexion pour libérer les ressources du serveur
$conn = null;


?>