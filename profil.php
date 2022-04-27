<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    // Inclusion des fichiers de fonctions
    include 'functions.php';
    include 'connexiondb.php';
    include 'fonctionUser.php';
    // Connexion à la BDD en tant qu'admin
    $conn = connectDBasAdmin();
    // Démarrage de la session pour créer les variables $_SESSION
    session_start();

    require_once realpath(__DIR__ . '/vendor/autoload.php');
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $APIGOO = $_ENV['GOOGLE_KEY'];
    ?>
    <!-- DEBUT IMPORT -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <!-- Test -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="cookiealert.css">
    <link rel="stylesheet" href="style.css">
    <!-- FIN IMPORT -->
    <script>
        $(document).ready(function() {

            username = <?php $_SESSION["login"];?>;
            document.getElementById(body).innerHTML = username;

        });
        //Fin du document ready
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What's my info ?!</title>
</head>

<body>
    <!-- Nav Bar -->
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Whatsmyinfo</a>
        <form class="form-inline">
            <!-- Button trigger modal -->
            <?php
            if (isset($_SESSION['login'])) {
                echo '<font color = white>Utilisateur : ' . $_SESSION['login'] . '</font>';
                echo '<a href="logout.php"><button type="button" class="btn btn-outline-success">';
                echo 'Logout';
                echo '</button></a>';
            } else {
                echo '<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#signIn">';
                echo 'Sign in';
                echo '</button>';
                echo '<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#register">';
                echo 'Register';
                echo '</button>';
            }
            ?>
        </form>
    </nav>

    <!-- START Liste des informations -->
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Adresse IP
                        <span class="badge badge-primary badge-pill"><?php echo getUserIP() ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Proxy
                        <span class="badge badge-primary badge-pill"><?php echo getUserIPFromInternet() ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Navigateur
                        <span class="badge badge-primary badge-pill"><?php echo getBrowser() ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        OS
                        <span class="badge badge-primary badge-pill"><?php echo getOS() ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Continent
                        <span class="badge badge-primary badge-pill" id="Continent"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pays
                        <span class="badge badge-primary badge-pill" id="Pays"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Drapeau
                        <span id="Drapeau"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Region
                        <span class="badge badge-primary badge-pill" id="Region"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Ville
                        <span class="badge badge-primary badge-pill" id="Ville"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Code Postal
                        <span class="badge badge-primary badge-pill" id="CodePostal"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Devise
                        <span class="badge badge-primary badge-pill" id="Devise"></span>
                    </li>
                </ul>
                <button type="button" onclick="getLocation()">Geolocalisation</button>
                <button type="button" id="CallApi">Call API</button>
            </div>
            <div class="col">
                <div class="ratio" style="--bs-aspect-ratio: 50%;">
                    <iframe id="frame" width="600" height="400" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

        </div>
        <!-- END Liste des informations -->
        <!-- START Bootstrap-Cookie-Alert -->
        <div class="alert text-center cookiealert" role="alert">
            <b>Do you like cookies?</b> &#x1F36A; We use cookies to ensure you get the best experience on our website. <a href="https://cookiesandyou.com/" target="_blank">Learn more</a>

            <button type="button" class="btn btn-primary btn-sm acceptcookies">
                I agree
            </button>
        </div>

        <!-- END Bootstrap-Cookie-Alert -->
        <script src="cookiealert.js"></script>
</body>

</html>