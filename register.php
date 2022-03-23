<?php
    include 'functions.php'; 
    include 'connexiondb.php'; 
    $conn=connectDBasAdmin();

    try {
        // Récupération des informations du formulaire + vérification de leur intégrité via test_input
        $email=test_input($_POST["email"]);
        $username=test_input($_POST["username"]);
        $psw=test_input($_POST["password"]);
        $pswverif=test_input($_POST["passwordverif"]);
    
        // Requête sql
        $sql = "INSERT INTO stage(USERNAME, USERPSW, USERMAIL, SIGNUPDATE, ISADMIN) VALUES (:username, :psw, :email, now(), false)";
        
        // Préparation de la requête
        $stmt = $conn->prepare($sql);
    
        // Attribution des paramètres de la requête préparée
        $stmt->bindParam(':username', $username, PDO::PARAM_STR, 25);
        $stmt->bindParam(':psw', $psw, PDO::PARAM_STR, 25);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR, 25);
        
        // Exécution de la requête
        $stmt->execute();
    }
        
    catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    //fermer la connexion pour libérer les ressources du serveur
    $conn = null;  
        
    header ("Location: $_SERVER[HTTP_REFERER]" );
?>
