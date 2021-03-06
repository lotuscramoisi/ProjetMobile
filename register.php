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
    $pswhash = password_hash($psw, PASSWORD_DEFAULT);

    //DEBUT RECHERCHE DE L'ADRESSEMAIL
    // Requête sql de recherche de l'adresse mail dans la DB
    $sqlrechercheemail = "select * from USER where USERMAIL like :email";

    // Préparation de la requête
    $stmtsearchmail = $conn->prepare($sqlrechercheemail);

    // Attribution des paramètres de la requête préparée
    $stmtsearchmail->bindParam(':email', $email, PDO::PARAM_STR, 50);

    // Exécution de la requête
    $stmtsearchmail->execute();
    //FIN RECHERCHE DE L'ADRESSEMAIL

    //DEBUT RECHERCHE DE L'USERNAME
    // Requête sql de recherche de l'adresse mail dans la DB
    $sqlrechercheusername = "select * from USER where USERNAME like :username";

    // Préparation de la requête
    $stmtsearchusername = $conn->prepare($sqlrechercheusername);

    // Attribution des paramètres de la requête préparée
    $stmtsearchusername->bindParam(':username', $username, PDO::PARAM_STR, 25);

    // Exécution de la requête
    $stmtsearchusername->execute();
    //FIN RECHERCHE DE L'USERNAME

    //VERIFICATION DE L'INTEGRITÉ DES DONNÉES
    //Si l'adresse mail existe dans la DB
    if ($stmtsearchmail->fetchColumn()) {
        echo 'Mail already registered';
    }
    //Si l'adresse mail n'est pas du bon format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Invalid email';
    }
    //Si l'adresse mail existe dans la DB
    elseif ($stmtsearchusername->fetchColumn()) {
        echo 'Username already registered';
    }
    //Si l'adresse mail est vide
    elseif ($email == ""){
        echo 'Email is empty';
    }
    //Si l'username est vide
    elseif ($username == ""){
        echo 'Username is empty';
    }
    //Si les mots de pass ne correspondent pas
    elseif ($psw != $pswverif){
        echo 'Passwords not matching';
    }
    //Si l'adresse mail n'existe pas dans la DB on valide l'inscription
    else{
        // Requête sql d'insertion des données de l'inscription
        $sql = "INSERT INTO USER(USERNAME, USERPSW, USERMAIL, SIGNUPDATE, ISADMIN) VALUES (:username, :psw, :email, now(), false)";

        // Préparation de la requête
        $stmt = $conn->prepare($sql);

        // Attribution des paramètres de la requête préparée
        $stmt->bindParam(':username', $username, PDO::PARAM_STR, 25);
        $stmt->bindParam(':psw', $pswhash, PDO::PARAM_STR, 100);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR, 25);

        // Exécution de la requête
        $stmt->execute();
        //header("Location: index.php?event=registrationsuccess");
        echo 'Inscription validée';
    }

} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
//fermer la connexion pour libérer les ressources du serveur
$conn = null;


?>