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
            // DEBUT AJAX FORMULAIRE REGISTER
            $("#btnregister").click(function(event) {
                // Serialisation des données du formulaire
                var serializedData = $("#registerform").serialize();
                //Récupération de tous les inputs du formulaire
                var $inputs = $("#registerform").find("input, select, button, textarea");
                //désactivation des inputs
                $inputs.prop("disabled", true);
                $.post(
                        'register.php', // Le fichier à appeler sur serveur.
                        serializedData, // Paramètre envoyé à la méthode post
                        function() {}, // Le nom de la fonction à appeler pour le callback
                        'text' // Format des données retournées par le serveur.
                    )
                    .done(function(data) {
                        //Si l'inscription est validée on fait apparaître un pop up
                        if (data == "Inscription validée") {
                            $('#register').modal('hide');
                            $('#event').modal('show');
                            $('#eventtitle').append('Registration completed');
                            $('#eventbody').append('Your registration was successfully completed');
                        }
                        //Si l'inscription a échouée on affiche un message d'erreur
                        else {
                            $('#alertMessageRegister').empty();
                            $('<font color="red"></font>').html(
                                data
                            ).appendTo('#alertMessageRegister');
                        }
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
            // FIN AJAX FORMULAIRE REGISTER
            // DEBUT AJAX FORMULAIRE LOGIN
            $("#btnlogin").click(function(event) {
                // Serialisation des données du formulaire
                var serializedData = $("#loginform").serialize();
                //Récupération de tous les inputs du formulaire
                var $inputs = $("#loginform").find("input, select, button, textarea");
                //désactivation des inputs
                $inputs.prop("disabled", true);
                $.post(
                        'login.php', // Le fichier à appeler sur serveur.
                        serializedData, // Paramètre envoyé à la méthode post
                        function() {}, // Le nom de la fonction à appeler pour le callback
                        'text' // Format des données retournées par le serveur.
                    )
                    .done(function(data) {
                        $('#signIn').modal('show');
                        $('#alertMessageLogin').empty();
                        $('<font color="red"></font>').html(
                            data
                        ).appendTo('#alertMessageLogin');
                        location.reload();
                        savePersonalData();
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
            // FIN AJAX FORMULAIRE LOGIN

            //Appelle l'API pour obtenir les informations à partir d'une IPV4
            // $('#CallApi').one('click', function(e) {
            //     $.ajax({
            //         url: "ajax.php", //the page containing php script
            //         type: "post", //request type,
            //         dataType: 'json',
            //         data: {
            //             registration: "success"
            //         },
            //         success: function(result) {
            //             var ecrit = JSON.parse(result);
            //             document.getElementById("Continent").innerHTML = ecrit.continent;
            //             document.getElementById("Pays").innerHTML = ecrit.country;
            //             var flag = ecrit.flag.png;
            //             document.getElementById("Drapeau").innerHTML = "<img height='30px' width='40px' src=" + flag + ">";
            //             document.getElementById("Ville").innerHTML = ecrit.region;
            //             document.getElementById("Region").innerHTML = ecrit.city;
            //             document.getElementById("CodePostal").innerHTML = ecrit.postal_code;
            //             document.getElementById("Devise").innerHTML = ecrit.currency.currency_name;
			// 			document.getElementById("TypeConnexion").innerHTML = ecrit.postal_code;
            //             showPositionLL(ecrit.latitude, ecrit.longitude)
            //         }
            //     });
            // });

            $.ajax({
                    url: "ajax.php", //the page containing php script
                    type: "post", //request type,
                    dataType: 'json',
                    data: {
                        registration: "success"
                    },
                    success: function(result) {
                        var ecrit = JSON.parse(result);
                        document.getElementById("Continent").innerHTML = ecrit.continent;
                        document.getElementById("Pays").innerHTML = ecrit.country;
                        var flag = ecrit.flag.png;
                        document.getElementById("Drapeau").innerHTML = "<img height='30px' width='40px' src=" + flag + ">";
                        document.getElementById("Ville").innerHTML = ecrit.city;
                        document.getElementById("Region").innerHTML = ecrit.region;
                        document.getElementById("CodePostal").innerHTML = ecrit.postal_code;
                        document.getElementById("Devise").innerHTML = ecrit.currency.currency_name;
						document.getElementById("TypeConnexion").innerHTML = ecrit.connection.connection_type;
						document.getElementById("FAI").innerHTML = ecrit.connection.isp_name;
						document.getElementById("OrganisationFAI").innerHTML = ecrit.connection.organization_name;
						document.getElementById("NomFuseau").innerHTML = ecrit.timezone.name;
						var date = <?php echo getCurrentTime() ?>;
						document.getElementById("HeureConn").innerHTML = date;
                        showPositionLL(ecrit.latitude, ecrit.longitude)
                    }
                });
 

            if(navigator.geolocation){
                $("#flexSwitchCheckDefault").prop("checked",true);
                console.log("ici");
            }
            //DEBUT : ENREGISTREMENT DES DONNEES DES USERS DANS LA DB
            //Si l'utilisateur est connecté
            // <?php
            // if (isset($_SESSION['login'])) {

            //     echo "$.ajax({";
            //     echo  "url: \"saveinfo.php\", //the page containing php script";
            //     echo  "type: \"post\", //request type,";
            //     echo  "dataType: 'json',";
            //     echo  "data: {";
            //     echo  "username:  \"" . $_SESSION['login'] ."\"";
            //     echo  "},";
            //     echo  "success: function(result) {}";
            //     echo  "});";          
            // }
            // ?>
            //FIN   : ENREGISTREMENT DES DONNEES DES USERS DANS LA DB

            //DEBUT : ENREGISTREMENT DES DONNEES DES USERS DANS LA DB
            //Si l'utilisateur est connecté
            // <?php
            // if (isset($_SESSION['login'])) {

            //     echo "$.ajax({
            //         url: \"saveinfo.php\", //the page containing php script
            //         type: \"post\", //request type,
            //         dataType: 'json',
            //         data: {
            //             username:  \"" . $_SESSION['login'] .
            //         "\"},
            //         success: function(result) {
                        
            //             }   
            //         });";
            // }
            // ?>
            //FIN   : ENREGISTREMENT DES DONNEES DES USERS DANS LA DB

        });
        //Fin du document ready


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
            //Permet de ne pas recharger la page
            return false;
        }

        //géolocalisation
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                //problème de navigateur
            }
        }

        function showPosition(position) {
            var x = document.getElementById("frame");
            let str = 'https://www.google.com/maps/embed/v1/place?key=<?php echo $APIGOO ?>';
            str += "&q=";
            str += position.coords.latitude;
            str += "+";
            str += position.coords.longitude;
            x.src = str;
        }

        function showPositionLL(latitude, longitude) {
            var x = document.getElementById("frame");
            let str = 'https://www.google.com/maps/embed/v1/place?key=<?php echo $APIGOO ?>';
            str += "&q=";
            str += latitude;
            str += "+";
            str += longitude;
            x.src = str;
        }

        function savePersonalData() {
            $.ajax({
                url: "savephp.php", //the page containing php script
                type: "post", //request type,
                dataType: "json",
                data: {
                    username: "<?php $_SESSION["login"] ?>"
                },
                success: function(result) {
                    console.log("ici");
                }
            });
        }

        function handleChange(checkbox) {
            if(checkbox.checked == true){
                getLocation();
            }else{
                showPositionLL(-27.125657, -109.357357);
            }
        }

        function handleChangeAPI(checkbox) {
            if(checkbox.checked == true){
                document.getElementById(checkbok).disabled = true;
            }
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
                echo '<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#autorisation">';
                echo 'Autorisation';
                echo '</button>';
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
                <form method="POST" onSubmit="return checkLoginForm(this)" id="loginform">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address/Username</label>
                            <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter email or username" name="login" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="pwd" maxlength="25">
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
                        <button id="btnlogin" class="btn btn-primary">Submit</button>
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
                            <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email" name="email" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter username" name="username" maxlength="25">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" maxlength="25">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password confirmation</label>
                            <input type="password" class="form-control" placeholder="Password confirmation" name="passwordverif" maxlength="25">
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

    <!-- Modal Autorisation -->
    <div class="modal fade" id="autorisation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Autorisation</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-check form-switch ml-5">
                            <input class="form-check-input genial" type="checkbox" role="switch" id="flexSwitchCheckDefault" onchange='handleChange(this);'>
                            <label class="form-check-label" for="flexSwitchCheckDefault">Geolocation</label>
                        </div>

                        <!-- <div class="form-check form-switch">
                            <input class="form-check-input" type="button" role="switch" id="CallApi" onchange='handleChangeAPI(this);'>
                            <label class="form-check-label" for="flexCheckDisabled">
                            Call API
                            </label>
                        </div> -->
                    </div>
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
    <!-- START Liste des informations -->
    <div class="container-fluid">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <ul class="list-group-flush">
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
					<li class="list-group-item d-flex justify-content-between align-items-center">
                        Type de connexion
                        <span class="badge badge-primary badge-pill" id="TypeConnexion"></span>
                    </li>
					<li class="list-group-item d-flex justify-content-between align-items-center">
                        Fournisseur d'accès Internet
                        <span class="badge badge-primary badge-pill" id="FAI"></span>
                    </li>
					<li class="list-group-item d-flex justify-content-between align-items-center">
                        Organisation du FAI
                        <span class="badge badge-primary badge-pill" id="OrganisationFAI"></span>
                    </li>
					<li class="list-group-item d-flex justify-content-between align-items-center">
                        Nom du fuseau horaire
                        <span class="badge badge-primary badge-pill" id="NomFuseau"></span>
                    </li>
					<li class="list-group-item d-flex justify-content-between align-items-center">
                        Heure de connexion
                        <span class="badge badge-primary badge-pill" id="HeureConn"></span>
                    </li>
                </ul>                
                                
            </div>
            <div class="col">
                <div class="ratio" style="--bs-aspect-ratio: 50%;">
                    <iframe id="frame" width="600" height="800" style="border:0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade">
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