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
        // DEBUT AJAX FORMULAIRE REGISTER
        $(document).ready(function() {
            $("#btnregister").click(function(event) {
                // Serialisation des données du formulaire
                var serializedData = $("#registerform").serialize();
                //Affichage des données du formulaire
                alert(serializedData);
                $.post(
                        'register.php', // Le fichier à appeler sur serveur.
                        serializedData, // Paramètre envoyé à la méthode post
                        function() {}, // Le nom de la fonction à appeler pour le callback
                        'text' // Format des données retournées par le serveur.
                    )
                    .done(function(data) {
                        $('<font color="red"></font>').html(
                            data
                        ).appendTo('#alertMessageRegister');
                    })
                    .fail(function(error) {
                        alert("error détectée:" + error.responseText);
                        $("#Div_error").append(error.responseText);
                    })
                    .always(function() {
                        // Reenable the inputs
                        $inputs.prop("disabled", false);
                    });
            });
        });
        // FIN AJAX FORMULAIRE REGISTER

        // Fonction pour vérifier les données du formulaire de login
        function checkLoginForm(form) {
            //Récupération des données du formulaire
            login = form.login.value;
            pwd = form.pwd.value;

            //On vide les messages d'alerte 
            $("#alertMessageLogin").empty()

            // If email not entered
            if (login == '') {
                $("#alertMessageLogin").append("Please enter login or email");
                return false;
            }

            // If username not entered
            if (pwd == '') {
                $("#alertMessageLogin").append("Please enter password");
                return false;
            }

        }
        // Fonction pour vérifier les données du formulaire d'enregistrement
        function checkRegisterForm(form) {
            //Récupération des données du formulaire
            username = form.username.value;
            email = form.email.value;
            password1 = form.password.value;
            password2 = form.passwordverif.value;

            //On vide les messages d'alerte 
            $("#alertMessageRegister").empty()

            // If email not entered
            if (email == '') {
                $("#alertMessageRegister").append("Please enter email");
            }
            // If username not entered
            if (username == '') {
                $("#alertMessageRegister").append("Please enter username");
            }
            // If password not entered
            if (password1 == '') {
                $("#alertMessageRegister").append("Please enter Password");
            }
            // If confirm password not entered
            else if (password2 == '') {
                $("#alertMessageRegister").append("Please enter confirm Password");
            }
            // If Not same return False.    
            else if (password1 != password2) {
                $("#alertMessageRegister").append("Passwords not matching");
            }
            return false;
        }

        function create() {
            $.ajax({
                url: "ajax.php", //the page containing php script
                type: "post", //request type,
                dataType: 'json',
                data: {
                    registration: "success"
                },
                success: function(result) {
                    var ecrit = JSON.parse(result);
                    document.getElementById("Pays").innerHTML = ecrit.country;
                    document.getElementById("Ville").innerHTML = ecrit.region;
                    document.getElementById("Region").innerHTML = ecrit.city;
                }
            });
        }


        //géolocalisation


        function getLocation() {
            var x = document.getElementById("location");
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            var x = document.getElementById("location");
            x.innerHTML = "Latitude: " + position.coords.latitude +
                "<br>Longitude: " + position.coords.longitude;
        }
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
    <div id="infotest"></div>
    <!-- Modal Sign In -->
    <div class="modal fade" id="signIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sign In</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="login.php" onSubmit="return checkLoginForm(this)">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address/Username</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email or username" name="login" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="pwd" maxlength="25">
                        </div>
                        <small id="alertMessageLogin" class="form-text text-muted"></small>
                    </div>
                    <div class="modal-footer">
                        <small id="emailHelp" class="form-text text-muted">
                            Not registered yet ?
                            <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-dismiss="modal" data-target="#register" tabindex="-1">
                                Register
                            </button>
                        </small>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Register -->
    <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Register</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" onSubmit="return checkRegisterForm(this)" id="registerform">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username" name="username" maxlength="25">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" maxlength="25">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password confirmation</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password confirmation" name="passwordverif" maxlength="25">
                        </div>
                        <small id="alertMessageRegister" class="form-text text-muted"></small>
                    </div>
                    <div class="modal-footer">
                        <small id="emailHelp" class="form-text text-muted">
                            Already registered ?
                            <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-dismiss="modal" data-target="#signIn" tabindex="-1">
                                Login
                            </button>
                        </small>
                        <button id="btnregister" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Event-->
    <div class="modal fade" id="event" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventtitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="eventbody">

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <?php
    //DEBUT : RENVOIS MESSAGE D'ERREUR VERIFICATION COTE CLIENT FORMULAIRE REGISTER
    // if (isset($_GET["error"])) {
    //     $errormsg = $_GET["error"];
    //     echo "<script>$('#alertMessageRegister').empty();</script>";
    //     echo "<script>$('#register').modal('show');</script>";
    //     //Si l'adresse mail existe dans la DB
    //     if ($errormsg  == "existingmail") {
    //         echo "<script>$('#alertMessageRegister').append('<font color=red>Email address already taken</font>');</script>";
    //     }
    //     //Si l'username existe dans la DB
    //     elseif ($errormsg == "existingusername") {
    //         echo "<script>$('#alertMessageRegister').append('<font color=red>Username already taken</font>');</script>";
    //     }
    //     //Si l'adresse mail est vide
    //     elseif ($errormsg == "emptyemail") {
    //         echo "<script>$('#alertMessageRegister').append('<font color=red>Address mail is empty</font>');</script>";
    //     }
    //     //Si l'username est vide
    //     elseif ($errormsg == "emptyusername") {
    //         echo "<script>$('#alertMessageRegister').append('<font color=red>Username is empty</font>');</script>";
    //     }
    //     //Si les mots de passe ne correspondent pas
    //     elseif ($errormsg == "pswnomatch") {
    //         echo "<script>$('#alertMessageRegister').append('<font color=red>Passwords don\'t match</font>');</script>";
    //     }
    // }
    //FIN : RENVOIS MESSAGE D'ERREUR VERIFICATION COTE CLIENT FORMULAIRE REGISTER
    //DEBUT : RENVOIS MESSAGE D'EVENEMENT
    if (isset($_GET["event"])) {
        $eventmsg = $_GET["event"];
        echo "<script>$('#event').modal('show');</script>";
        //Si l'inscription s'est bien déroulée
        if ($eventmsg  == "registrationsuccess") {
            echo "<script>$('#eventtitle').append('Registration completed');</script>";
            echo "<script>$('#eventbody').append('Your registration was successfully completed');</script>";
        }
    }
    //FIN : RENVOIS MESSAGE DE CONFIRMATION D'INSCRIPTION
    ?>
    <!-- START Liste des informations -->
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
            Pays
            <span class="badge badge-primary badge-pill" id="Pays"></span>
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
            Géolocalisation
            <span class="badge badge-primary badge-pill" id="location"></span>
        </li>

    </ul>

    <button type="button" onclick="create()">Call API</button>
    <button type="button" onclick="getLocation()">Geolocalisation</button>

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