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
    if (!isset($_SESSION['admin']))
        header('location: index.php');

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="cookiealert.css">
    <link rel="stylesheet" href="style.css">
    <!-- FIN IMPORT -->
    <script>
        var firstData;
        $(document).ready(function() {
            // Récupération de la liste des utilisateurs + affichage de celle ci
            $.ajax({
                url: "getUserList.php", //the page containing php script
                async: false,
                type: "post", //request type,
                dataType: 'json',
                data: {},
                success: function(result) {

                    //Affichage de chaque ligne des utilisateurs récupérés
                    for (var r of result) {
                        //Affichage d'un user admin
                        if (r.ISADMIN == 1) {
                            $('<tr></tr>').html(
                                '<td>' + r.USERNAME + '</td>' +
                                '<td>' + r.USERMAIL + '</td>' +
                                '<td>' + r.SIGNUPDATE + '</td>' +
                                '<td> <div class="form-check form-switch ml-5">' +
                                '<input class="form-check-input genial" type="checkbox" role="switch" id="flexSwitchCheckDefault" checked>' +
                                '</div></td>' +
                                '<td><button type="button" class="btn btn-danger">Delete</button>' +
                                '</td>'
                            ).appendTo('#usertable');
                        }
                        //Affichage d'un user non admin
                        else {
                            $('<tr></tr>').html(
                                '<td>' + r.USERNAME + '</td>' +
                                '<td>' + r.USERMAIL + '</td>' +
                                '<td>' + r.SIGNUPDATE + '</td>' +
                                '<td> <div class="form-check form-switch ml-5">' +
                                '<input class="form-check-input genial" type="checkbox" role="switch" id="flexSwitchCheckDefault">' +
                                '</div></td>' +
                                '<td><button type="button" class="btn btn-danger">Delete</button>' +
                                '</td>'
                            ).appendTo('#usertable');
                        }
                    }
                }
            });


            //Changement du droit d'administrateur quand click sur le switch
            $(".form-check-input").click(function(event) {
                $.ajax({
                    url: "setAdmin.php", //the page containing php script
                    async: false,
                    type: "post", //request type,
                    dataType: 'json',
                    data: {
                        username: $(this).parent().parent().siblings().html(),
                        permission: $(this).is(':checked')
                    },
                    success: function(result) {}
                });
            });

            //Suppression d'un utilisateur
            $(".btn-danger").click(function(event) {
                $.ajax({
                    url: "deleteUser.php", //the page containing php script
                    async: false,
                    type: "post", //request type,
                    dataType: 'json',
                    data: {
                        username: $(this).parent().siblings().html()
                    },
                    success: function(result) {}
                });
                $(this).parent().parent().remove();
            });

            //Debut récupération des stats
            $.ajax({
                url: "getStats.php", //the page containing php script
                async: false,
                type: "post", //request type,
                dataType: 'json',
                data: {},
                success: function(result) {
                    var donnees = JSON.parse(result);
                    firstData = result;
                }
            });
            //Fin récupération des stats
            document.getElementById("affiche").innerHTML = firstData;
            //DEBUT FONCTION POUR LES GRAPHIQUES PIECHART
            window.onload = function() {

                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    title: {
                        text: "OS utilisation by users"
                    },
                    data: [{
                        type: "pie",
                        startAngle: 240,
                        yValueFormatString: "##0.00\"%\"",
                        indexLabel: "{label} {y}",
                        dataPoints: [{
                                y: 75,
                                label: "Windows"
                            },
                            {
                                y: 7,
                                label: "Bing"
                            },
                            {
                                y: 7,
                                label: "Baidu"
                            },
                            {
                                y: 7,
                                label: "Yahoo"
                            },
                            {
                                y: 4,
                                label: "Others"
                            }
                        ]
                    }]
                });
                chart.render();

            }
            //FIN FONCTION POUR LES GRAPHIQUES PIECHART
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Whatsmyinfo</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBareExpendIdAdmin" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navBareExpendIdAdmin">
            <ul class="navbar-nav me-auto mb-2 mb-md-0"></ul>
            <!-- Button trigger modal -->
            <?php
            if (isset($_SESSION['login'])) {
                echo '<a href="index.php"><button type="button" class="btn btn-outline-success mb-2 me-1">';
                echo 'Accueil';
                echo '</button></a>';
                echo '<a href="profil.php"><button type="button" class="btn btn-outline-success mb-2 me-1">';
                echo 'Profil';
                echo '</button></a>';
                echo '<a href="logout.php"><button type="button" class="btn btn-outline-success mb-2 me-1">';
                echo 'Logout';
                echo '</button></a>';
            }
            ?>
            <div>
    </nav>
    <div id="affiche"></div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Sign Up Date</th>
                <th scope="col">Admin Rights</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody id="usertable">
        </tbody>
    </table>

    <!-- START Bootstrap-Cookie-Alert -->
    <div class="alert text-center cookiealert" role="alert">
        <b>Do you like cookies?</b> &#x1F36A; We use cookies to ensure you get the best experience on our website. <a href="https://cookiesandyou.com/" target="_blank">Learn more</a>

        <button type="button" class="btn btn-primary btn-sm acceptcookies">
            I agree
        </button>
    </div>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <!-- END Bootstrap-Cookie-Alert -->
    <script src="cookiealert.js"></script>
</body>

</html>