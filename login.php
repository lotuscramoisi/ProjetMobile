<?php
include 'functions.php';
include 'connexiondb.php'; 
$conn = connectDBasAdmin();
// On définit un login et un mot de passe de base pour tester notre exemple. Cependant, vous pouvez très bien interroger votre base de données afin de savoir si le visiteur qui se connecte est bien membre de votre site
try {
    // Récupération des informations du formulaire + vérification de leur intégrité via test_input
    $login=test_input($_POST["login"]);
    $pwd=test_input($_POST["pwd"]);

    

    // Requête sql
    $sql = "select * from USER where USERNAME like binary :login";
    
    // Préparation de la requête
    $stmt = $conn->prepare($sql);

    // Attribution des paramètres de la requête préparée
    $stmt->bindParam(':login', $login, PDO::PARAM_STR, 25);
    
    // Exécution de la requête
    $stmt->execute();

    //Récupération du mot de pass haché
    $pwdhash = $stmt->fetch(PDO::FETCH_ASSOC);
    // echo "avant if : " . $pwdhash['USERPSW'];
    // echo "<br/> test : " . password_hash("test", PASSWORD_DEFAULT);
    //Si la requête renvois un résultat c'est que le login et mot de pass existe dans le bdd
    if(password_verify($pwd, $pwdhash['USERPSW'])){
        
         // on démarre la session
         session_start();
         
         // on enregistre les paramètres de notre visiteur comme variables de session ($login et $pwd) (notez bien que l'on utilise pas le $ pour enregistrer ces variables)
         $_SESSION['login'] = $login;
         $_SESSION['pwd'] = $pwdhash;
 
    }
    // on redirige notre visiteur vers la page d'accueil
    header('location: index.php');
}
    
catch(PDOException $e) {
    if(password_verify($pwd, $pwdhash['USERPSW'])){
        echo "expection : " . $pwdhash['USERPSW'];
   }
    else{
        echo "hash failed";

    }
}
?>
