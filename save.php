<?php
include 'connexiondb.php';
$conn = connectDBasAdmin();

try {
    // Récupération des informations du formulaire + vérification de leur intégrité via test_input
    $username = test_input($_POST["username"]);
    $date = ;
  
    // Requête sql d'insertion des données de l'inscription
    $sql = "INSERT INTO USER(USERNAME,SIGNUPDATE) VALUES (:username, date('Y-m-d h:i:s'))";

    // Préparation de la requête
    $stmt = $conn->prepare($sql);

    // Attribution des paramètres de la requête préparée
    $stmt->bindParam(':username', $username, PDO::PARAM_STR, 25);

    // Exécution de la requête
    $stmt->execute();
    echo 'Réussi';

} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
//fermer la connexion pour libérer les ressources du serveur
$conn = null;

?>