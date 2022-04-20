<?php
include 'connexiondb.php';
$conn = connectDBasAdmin();

try {

    echo 'Réussi';

} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
//fermer la connexion pour libérer les ressources du serveur
$conn = null;

?>