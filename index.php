<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    // Inclusion des fichiers de fonctions
    include 'functions.php';
    include 'connexiondb.php';
    // Connexion à la BDD en tant qu'admin
    $conn = connectDBasAdmin();
    // Démarrage de la session pour créer les variables $_SESSION
    session_start();
    ?>
    <script>
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

            // If email already used
            // if (isMailUsed(email)) {
            //     $("#alertMessageRegister").append("Email already used");
            //     return false;
            // }

            // If email not entered
            if (email == '') {
                $("#alertMessageRegister").append("Please enter email");
                return false;
            }

            // If username not entered
            if (username == '') {
                $("#alertMessageRegister").append("Please enter username");
                return false;
            }

            // If password not entered
            if (password1 == '') {
                $("#alertMessageRegister").append("Please enter Password");
                return false;
            }

            // If confirm password not entered
            else if (password2 == '') {
                $("#alertMessageRegister").append("Please enter confirm Password");
                return false;
            }

            // If Not same return False.    
            else if (password1 != password2) {
                $("#alertMessageRegister").append("Passwords not matching");
                return false;
            }
        }
    </script>
    <!-- Import -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="cookiealert.css">

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
                echo 'Utilisateur : ' . $_SESSION['login'];
                echo '<FONT COLOR=white>Utilisateur : ' . $_SESSION['login'] . '</font>';
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
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email or username" name="login">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="pwd">
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
                <form method="POST" action="register.php" onSubmit="return checkRegisterForm(this)">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username" name="username">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password confirmation</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password confirmation" name="passwordverif">
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
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    if (isset($_SESSION['login'])) {
    }
    ?>
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