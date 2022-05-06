<!DOCTYPE html>
<html lang="fr">

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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous">
    </script>
    <!-- Test -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="cookiealert.css">
    <link rel="stylesheet" href="style.css">
    <!-- FIN IMPORT -->
    <script>
        var connexionTime;

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
                        // $('<font color="red"></font>').html(
                        //     data
                        // ).appendTo('#alertMessageLogin');
                        savePersonalData(data);
                        location.reload();
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

            $.ajax({
                url: "ajax.php",
                async: false,
                type: "post",
                dataType: 'json',
                data: {
                    registration: "success"
                },
                success: function(result) {
                    var ecrit = JSON.parse(result);
                    document.getElementById("Continent").innerHTML = ecrit.continent + " (" + ecrit.continent_code + ")";
                    document.getElementById("Pays").innerHTML = ecrit.country + " (" + ecrit.country_code + ")";
                    var flag = ecrit.flag.png;
                    document.getElementById("Drapeau").innerHTML =
                        "<img height='30px' width='40px' src=" + flag + ">";
                    document.getElementById("Ville").innerHTML = ecrit.city;
                    document.getElementById("Region").innerHTML = ecrit.region;
                    document.getElementById("CodePostal").innerHTML = ecrit.postal_code;
                    document.getElementById("Devise").innerHTML = ecrit.currency.currency_name;
                    document.getElementById("TypeConnexion").innerHTML = ecrit.connection.connection_type;
                    document.getElementById("FAI").innerHTML = ecrit.connection.isp_name;
                    document.getElementById("OrganisationFAI").innerHTML = ecrit.connection.organization_name;
                    document.getElementById("NomFuseau").innerHTML = ecrit.timezone.name;
                    document.getElementById("HeureConn").innerHTML = ecrit.timezone.current_time;
                    connexionTime = ecrit.timezone.current_time;
                    showPositionLL(ecrit.latitude, ecrit.longitude)
                }
            });

            //Regarde si les droits du navigateur permettent la géolocalisation  
            checkGeolocalisation();

            navigator.permissions.query({
                    name: 'accelerometer'
                })
                .then(result => {
                    if (result.state === 'denied') {
                        console.log('Permission to use accelerometer sensor is denied.');
                    } else {
                        // Use the sensor.
                        document.getElementById("acceleromtre").checked = true;
                    }
                });            
        });
        //Fin du document ready


        //Fonction qui regarde si les droits du navigateur permettent la géolocalisation
        function checkGeolocalisation() {
            navigator.permissions.query({
                name: 'geolocation'
            }).then(function(permissionStatus) {

                if (permissionStatus.state === 'granted') {
                    $("#flexSwitchCheckDefault").prop("checked", true);
                } else if (permissionStatus.state === 'prompt') {
                    $("#flexSwitchCheckDefault").prop("checked", false);
                } else {
                    $("#flexSwitchCheckDefault").prop("checked", false);
                }

                permissionStatus.onchange = function() {
                    if (permissionStatus.state === 'granted') {
                        $("#flexSwitchCheckDefault").prop("checked", true);
                    } else if (permissionStatus.state === 'prompt') {
                        $("#flexSwitchCheckDefault").prop("checked", false);
                    } else {
                        $("#flexSwitchCheckDefault").prop("checked", false);
                    }
                };
            });
        }

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


            var re = new RegExp("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/");
            //On vide les messages d'alerte 
            $("#alertMessageRegister").empty()

            // If email not entered
            if (email == '') {
                $("#alertMessageRegister").append("Please enter email");
            }
            if(re.test(email)){
                $("#alertMessageRegister").append("Invalide email");
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
            //Si on nous donne l'autorisation explicite
            if (document.getElementById("flexSwitchCheckDefault").checked == true) {
                //On regarde les vrais droits de la page
                navigator.permissions.query({
                    name: 'geolocation'
                }).then(function(permissionStatus) {
                    //Si on a les vrai droits, on affiche la maps
                    if (permissionStatus.state === 'granted') {
                        navigator.geolocation.getCurrentPosition(showPosition);
                    } else {
                        //Si non, on demande à l'utilisateur de nous donner les droits
                        navigator.geolocation.getCurrentPosition(showPosition);
                    }
                });
            } else {
                showPositionLL(-27.125657, -109.357357);
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

        function savePersonalData(login) {
            //DEBUT : ENREGISTREMENT DES DONNEES DES USERS DANS LA DB
            //Si l'utilisateur est connecté
            
            $.ajax({
                url: "saveinfo.php",
                async: false,
                type: "post",
                dataType: 'json',
                data: {
                    username: login,
                    connexionTime: connexionTime,
                    deviceType: $("#deviceType").html(),
                    browserName: $('#browserName').html(),
                    operatingSystem: $("#operatingSystemName").html(),
                    IPAdress: $("#IPAdress").html()
                },
                success: function(result) {}
            });

            //FIN   : ENREGISTREMENT DES DONNEES DES USERS DANS LA DB
        }

        //Pour ouvrir les fichiers
        const pickerOpts = {
            types: [{
                description: 'Images',
                accept: {
                    'image/*': ['.png', '.gif', '.jpeg', '.jpg']
                }
            }, ],
            excludeAcceptAllOption: true,
            multiple: false
        };

        async function getTheFile() {
            if (document.getElementById("ca").checked == true) {
                // open file picker
                [fileHandle] = await window.showOpenFilePicker(pickerOpts);

                // get file contents
                const fileData = await fileHandle.getFile();
            }
        }
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What's my info ?!</title>
</head>

<body class="d-flex flex-column h-100">
    <!-- Nav Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Whatsmyinfo</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBareExpendId" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navBareExpendId">
            <ul class="navbar-nav me-auto mb-2 mb-md-0"></ul>
            <!-- Button trigger modal -->
            <?php
            if (isset($_SESSION['login'])) {
                if (isset($_SESSION['admin'])) { ?>
                    <a href="admin.php"><button type="button" class="btn btn-outline-success mb-2 me-1">
                            Admin
                        </button></a>
                <?php } ?>
                <button type="button" class="btn btn-outline-success mb-2 me-1" data-toggle="modal" data-target="#autorisation">
                    Autorisation
                </button>
                <a href="profil.php"><button type="button" class="btn btn-outline-success mb-2 me-1">
                        Profil
                    </button></a>
                <a href="logout.php"><button type="button" class="btn btn-outline-success mb-2 me-1">
                        Logout
                    </button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-outline-success mb-2 me-1" data-toggle="modal" data-target="#autorisation">
                    Autorisation
                </button>
                <button type="button" class="btn btn-outline-success mb-2 me-1" data-toggle="modal" data-target="#signIn">
                    Sign in
                </button>
                <button type="button" class="btn btn-outline-success mb-2 me-1" data-toggle="modal" data-target="#register">
                    Register
                </button>
            <?php }
            ?>
            <div>
    </nav>
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
                        <input class="form-check-input genial" type="checkbox" role="switch" id="flexSwitchCheckDefault" disabled>
                        <label class="form-check-label" for="flexSwitchCheckDefault">Geolocation </label>
                    </div>
                    <div class="form-check form-switch ml-5">
                        <input class="form-check-input genial" type="checkbox" role="switch" id="acceleromtre" disabled>
                        <label class="form-check-label" for="flexSwitchCheckDefault">Accéléromètre </label>
                    </div>
                    <div class="form-check form-switch ml-5">
                        <input class="form-check-input genial" type="checkbox" role="switch" id="flexSwitchCheckDefault" disabled>
                        <label class="form-check-label" for="flexSwitchCheckDefault">Affichage lumineux</label>
                    </div>
                    <div class="form-check form-switch ml-5">
                        <input class="form-check-input genial" type="checkbox" role="switch" id="ca" onchange='getTheFile();'>
                        <label class="form-check-label" for="flexSwitchCheckDefault">Allow File usage</label>
                    </div>
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
    <div class="container-fluid mt-2">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <ul class="list-group-flush">

                    <div class="accordion" id="myAccordion">
                        <div class="accordion-item">
                            <button type="button" class="accordion-button collapsed" data-toggle="collapse" data-target="#collapsible-1" data-parent="#myAccordion">Système</button>
                            <div id="collapsible-1" class="collapse">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Type d'appareil
                                    <span class="badge badge-primary badge-pill" id="deviceType"><?php echo getDevice() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Navigateur
                                    <span class="badge badge-primary badge-pill" id="browserName"><?php echo getBrowser() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Fabricant du navigateur
                                    <span class="badge badge-primary badge-pill" id="Vendor"><?php echo getVendor() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Langue du navigateur
                                    <span class="badge badge-primary badge-pill"><?php echo getNavigatorLang() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    OS
                                    <span class="badge badge-primary badge-pill" id="operatingSystemName"><?php echo getOS() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Fuseau horaire
                                    <span class="badge badge-primary badge-pill" id="NomFuseau"></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Heure de connexion du fuseau
                                    <span class="badge badge-primary badge-pill" id="HeureConn"></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Heure de connexion locale
                                    <span class="badge badge-primary badge-pill" id="HeureConnLoc"><?php echo getTimeLocal() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Résolution de l'écran
                                    <span class="badge badge-primary badge-pill" id="ScreenResolution"><?php echo getResol() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Profondeur de couleur d'écran
                                    <span class="badge badge-primary badge-pill" id="RésolutionEcran"><?php echo getBitsScreen() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Niveau de batterie
                                    <span class="badge badge-primary badge-pill" id="Batterie"><?php echo getBattery() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Mémoire RAM disponible
                                    <span class="badge badge-primary badge-pill" id="Memoire"><?php echo getMemory() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Nombre de coeurs logiques
                                    <span class="badge badge-primary badge-pill" id="NbCoeurs"><?php echo getNbCoeurs() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Nombre de points en Multi-Touch
                                    <span class="badge badge-primary badge-pill" id="MultiTouch"><?php echo getMultiTouch() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Taille du cache utilisée
                                    <span class="badge badge-primary badge-pill" id="TailleCache"><?php echo getCacheSize() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Bloqueur de publicités
                                    <span class="badge badge-primary badge-pill" id="Pub"><?php echo getPub() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Bloqueur de cookies
                                    <span class="badge badge-primary badge-pill" id="Cookies"><?php echo getCookies() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Visualiseur PDF du navigateur
                                    <span class="badge badge-primary badge-pill" id="PdfViewer"><?php echo getPdfViewer() ?></span>
                                </li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
                                    Orientation de l'écran
                                    <span class="badge badge-primary badge-pill" id="Orient"><?php echo getOrient() ?></span>
                                </li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
                                    Gyroscopie Bêta (β)
                                    <span class="badge badge-primary badge-pill" id="GyroX"><?php echo getGyroX() ?></span>
                                </li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
                                    Gyroscopie Gamma (ɣ)
                                    <span class="badge badge-primary badge-pill" id="GyroY"><?php echo getGyroY() ?></span>
                                </li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
                                    Gyroscopie Alpha (α)
                                    <span class="badge badge-primary badge-pill" id="GyroZ"><?php echo getGyroZ() ?></span>
                                </li>
								<li class="list-group-item d-flex justify-content-between align-items-center">
                                    Accéléromètre
                                    <span class="badge badge-primary badge-pill" id="Accel"><?php echo getAccel() ?></span>
                                </li>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button type="button" class="accordion-button collapsed" data-toggle="collapse" data-target="#collapsible-2" data-parent="#myAccordion">Réseau</button>
                            <div id="collapsible-2" class="collapse">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Adresse IP
                                    <span class="badge badge-primary badge-pill" id="IPAdress"><?php echo getUserIP() ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Proxy
                                    <span class="badge badge-primary badge-pill"><?php echo getUserIPFromInternet() ?></span>
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
                                    Type de connexion mobile
                                    <span class="badge badge-primary badge-pill" id="NetworkInformation"><?php echo getNetworkInformation() ?></span>
                                </li>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button type="button" class="accordion-button collapsed" data-toggle="collapse" data-target="#collapsible-3" data-parent="#myAccordion">Localisation</button>
                            <div id="collapsible-3" class="collapse">
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
                            </div>
                        </div>
                    </div>
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
            <b>Do you like cookies?</b> &#x1F36A; We use cookies to ensure you get the best experience on our website.
            <a href="https://cookiesandyou.com/" target="_blank">Learn more</a>

            <button type="button" class="btn btn-primary btn-sm acceptcookies">
                I agree
            </button>
        </div>

        <!-- END Bootstrap-Cookie-Alert -->
        <script src="cookiealert.js"></script>
</body>

</html>