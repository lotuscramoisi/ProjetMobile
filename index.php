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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous">
    </script>
    <!-- Test -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="cookiealert.css">
    <link rel="stylesheet" href="style.css">
    <!-- FIN IMPORT -->
    <!-- <script>
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
                    })
                    .fail(function(error) {
                        alert("error détectée:" + error.responseText);
                        $("#Div_error").append(error.responseText);
                    })
                    .always(function() {
                        // Reenable the inputs
                        $inputs.prop("disabled", false);
                        savePersonalData()
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

            //Call à l'API qui nous fournit les positions via l'adresse IP
            $.ajax({
                url: "ajax.php",
                type: "post",
                dataType: 'json',
                data: {
                    registration: "success"
                },
                success: function(result) {
                    var ecrit = JSON.parse(result);
                    document.getElementById("Continent").innerHTML = ecrit.continent;
                    document.getElementById("AbrevContinent").innerHTML = ecrit.continent_code;
                    document.getElementById("Pays").innerHTML = ecrit.country;
                    document.getElementById("AbrevPays").innerHTML = ecrit.country_code;
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
                    showPositionLL(ecrit.latitude, ecrit.longitude)
                }
            });

            //Regarde si les droits à la navigation sont données
            if (navigator.geolocation) {
                $("#flexSwitchCheckDefault").prop("checked", true);
            }
            navigator.permissions.query({
                    name: 'geolocation'
                })
                .then(function(permissionStatus) {
                    console.log('geolocation permission state is ', permissionStatus.state);

                    permissionStatus.onchange = function() {
                        console.log('geolocation permission state has changed to ', this.state);
                    };
                });


            //DEBUT : ENREGISTREMENT DES DONNEES DES USERS DANS LA DB
            //Si l'utilisateur est connecté
            // <?php
                //             if (isset($_SESSION['login'])) {

                //                 echo "$.ajax({";
                //                 echo  "url: \"saveinfo.php\", //the page containing php script";
                //                 echo  "type: \"post\", //request type,";
                //                 echo  "dataType: 'json',";
                //                 echo  "data: {";
                //                 echo  "username:  \"" . $_SESSION['login'] ."\"";
                //                 echo  "},";
                //                 echo  "success: function(result) {}";
                //                 echo  "});";          
                //             }
                // 
                ?>
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
            //DEBUT : ENREGISTREMENT DES DONNEES DES USERS DANS LA DB
            //Si l'utilisateur est connecté
            var login = "<?php echo $_SESSION['login'] ?>";
            
            if (login != "") {
                $.ajax({
                    url: "saveinfo.php",
                    type: "post",
                    dataType: 'json',
                    data: {
                        username: login
                    },
                    success: function(result) {}
                });
            }
            //FIN   : ENREGISTREMENT DES DONNEES DES USERS DANS LA DB
        }

        function handleChange(checkbox) {
            if (checkbox.checked == true) {
                getLocation();
            } else {
                showPositionLL(-27.125657, -109.357357);
            }
        }

        function handleChangeAPI(checkbox) {
            if (checkbox.checked == true) {
                document.getElementById(checkbok).disabled = true;
            }
        }
    </script> -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What's my info ?!</title>
</head>

<body class="d-flex flex-column h-100">
    
   

</body>

</html>