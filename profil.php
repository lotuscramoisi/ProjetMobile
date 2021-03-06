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
    if(!isset($_SESSION['admin']))
        header ('location: index.php');
    ?>
    <!-- DEBUT IMPORT -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
        integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous">
    </script>
    <!-- Test -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
        integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="cookiealert.css">
    <link rel="stylesheet" href="style.css">
    <!-- FIN IMPORT -->
    <script>
    $(document).ready(function() {

        // Récupération du login 
        username = "<?php echo $_SESSION['login']; ?> ";
        // document.getElementById("test").innerHTML = username;

        // Récupération des sessions de l'utilisateur
        $.ajax({
            url: "getSession.php", //the page containing php script
            async: false,
            type: "post", //request type,
            dataType: 'json',
            data: {},
            success: function(result) {
                i = 0;
                //Affichage de chaque ligne des sessions récupérées
                for (var r of result) {
                    // keys = Object.keys(r);
                    affichageLigne(i, r.CONNEXIONTIME);
                    affichageDonnee(i, "Username", r.USERNAME);
                    affichageDonnee(i, "Type d'appareil", r.DEVICE);
                    affichageDonnee(i, "Navigateur", r.USERNAV);
                    affichageDonnee(i, "OS", r.USEROS);
                    affichageDonnee(i, "Adresse IP", r.USERIP);
                    i++;
                }
            }
        });

        //Suppression d'une session lors du click sur le bouton Delete
        $(".btn-danger").click(function(event) {
            //Suppression côté serveur
            $.ajax({
                url: "removeSession.php", //the page containing php script
                type: "post", //request type,
                dataType: 'json',
                data: {
                    login: username,
                    sessiontime: $(this).siblings().html()
                },
                success: function(result) {}
            });
            // alert($(this).siblings().html());
            //Suppression côté client
            $(this).parent().remove();
        });
    });
    //Fin du document ready

    //DEBUT : Fonction d'affichage d'une ligne de session
    function affichageLigne(index, dateSession) {
        $('<div class="accordion-item" id="session-' + index + '"></div>').html(
            '<button type="button" class="accordion-button collapsed" data-toggle="collapse" data-target="#collapsible-' +
            index + '" data-parent="#myAccordion">' +
            dateSession +
            '</button>' +
            '<button type="button" class="btn btn-danger" id="toastbtn">Delete</button>' +
            '<div id="collapsible-' + index + '" class="collapse"></div>'
        ).appendTo('#myAccordion');
    }

    function affichageDonnee(index, name, data) {
        $("#collapsible-" + index).append(
            '<li class="list-group-item d-flex justify-content-between align-items-center">' +
            name +
            '<span class="badge badge-primary badge-pill">' + data + '</span>' +
            '</li>');
    }
    //FIN : Fonction d'affichage d'une ligne de session
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What's my info ?!</title>
</head>

<body>
    <!-- Nav Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Whatsmyinfo</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBareExpendIdProfil"
            aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navBareExpendIdProfil">
            <ul class="navbar-nav me-auto mb-2 mb-md-0"></ul>
            <!-- Button trigger modal -->
            <?php
            if (isset($_SESSION['login'])) {
                echo '<a href="index.php"><button type="button" class="btn btn-outline-success mb-2 me-1">';
                echo 'Accueil';
                echo '</button></a>';
                if (isset($_SESSION['admin'])) {
                    echo '<a href="admin.php"><button type="button" class="btn btn-outline-success mb-2 me-1">';
                    echo 'Admin';
                    echo '</button></a>';
                }
                echo '<a href="logout.php"><button type="button" class="btn btn-outline-success mb-2 me-1">';
                echo 'Logout';
                echo '</button></a>';
            }
            ?>
            <div>
    </nav>
    <div class="accordion" id="myAccordion">
    </div>

    <!-- START Bootstrap-Cookie-Alert -->
    <div class="alert text-center cookiealert" role="alert">
        <b>Do you like cookies?</b> &#x1F36A; We use cookies to ensure you get the best experience on our website. <a
            href="https://cookiesandyou.com/" target="_blank">Learn more</a>

        <button type="button" class="btn btn-primary btn-sm acceptcookies">
            I agree
        </button>
    </div>

    <!-- END Bootstrap-Cookie-Alert -->
    <script src="cookiealert.js"></script>
</body>

</html>