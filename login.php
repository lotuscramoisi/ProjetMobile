<?php
include 'functions.php';
include 'connexiondb.php'; 
$conn = connectDBasAdmin();
// On définit un login et un mot de passe de base pour tester notre exemple. Cependant, vous pouvez très bien interroger votre base de données afin de savoir si le visiteur qui se connecte est bien membre de votre site
try {
    // Récupération des informations du formulaire + vérification de leur intégrité via test_input
    $login=test_input($_POST["login"]);
    $pwd=test_input($_POST["pwd"]);

    
    //DEBUT RECHERCHE DE L'ADRESSEMAIL
    // Requête sql de recherche de l'adresse mail dans la DB
    $sqlrechercheemail = "select * from USER where USERMAIL like :login or USERNAME like :login";

    // Préparation de la requête
    $stmtsearchmail = $conn->prepare($sqlrechercheemail);

    // Attribution des paramètres de la requête préparée
    $stmtsearchmail->bindParam(':login', $login, PDO::PARAM_STR, 50);

    // Exécution de la requête
    $stmtsearchmail->execute();
    //FIN RECHERCHE DE L'ADRESSEMAIL

    //SI L'ADRESSE MAIL EST ENREGISTREE ON RECHERCHE LE MDP
    if($stmtsearchmail->fetchColumn()){
        //DEBUT RECHERCHE DU MDP EN FONCTION DE L'ADRESSE MAIL
        // Requête sql
        $sql = "select * from USER where USERNAME like binary :login or USERMAIL like :login";
        
        // Préparation de la requête
        $stmt = $conn->prepare($sql);

        // Attribution des paramètres de la requête préparée
        $stmt->bindParam(':login', $login, PDO::PARAM_STR, 25);
        
        // Exécution de la requête
        $stmt->execute();
        //Récupération du mot de pass haché
        $userinfos = $stmt->fetch(PDO::FETCH_ASSOC);
        //FIN RECHERCHE DU MDP EN FONCTION DE L'ADRESSE MAIL

        //Si la requête renvois un résultat c'est que le login et mot de pass existe dans le bdd
        if(password_verify($pwd, $userinfos['USERPSW'])){
            // on démarre la session
            session_start();
            
            // on enregistre les paramètres de notre visiteur comme variables de session
            $_SESSION['login'] = $userinfos['USERNAME'];
            $_SESSION['pwd'] = $pwdhash;
            header ("Location: $_SERVER[HTTP_REFERER]");
            echo "Connexion réussie";
        }
        else{
            echo "Password incorrect";
        }
    }
    else{
        echo "Login not registered";
    }
    
}
    
catch(PDOException $e) {
   echo "Connection failed";
}
?>
