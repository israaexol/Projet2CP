<?php
session_start(); // Permet d'initier la session afin de pouvoir définir des variables dans le tableau $_SESSION, et qui seront disponibles dans toutes les pages PHP pour le même PC qui a ouvert la page, tant qu'il n'a pas visité la page deconnexion.php qui permettra de détruire la variable de session et toutes les données temporaires qu'on a défini pour l'exécution
if (isset($_SESSION['id'])) // déjà connecté, pourquoi se reconnecter
{
    header('Location: interface.php');
    exit;
}
if (!empty($_SESSION['lien'])) // pour aller directement au lien après la connexion
{
    $_SESSION['lien2']=$_SESSION['lien'];
    $_SESSION['lien']=NULL;
}
else
{
    $_SESSION['lien2']=NULL; // voir verif_connexion.php
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        Connexion
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="./assets/css/blk-design-system.css" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="./assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="index-page" style="background-color: #2a2f63;" >

<div class="wrapper">
    <div class="page-header header-filter">
        <div class="squares square1" ><br><br><br><br><br><br><br><center><img src="./assets/img/logo.png"alt=""/></center></div>
        <div class="squares square2"></div>
        <div class="squares square3"></div>
        <div class="squares square4"></div>
        <div class="squares square5"></div>
        <div class="squares square6"></div>
        <div class="squares square7"></div>
        <br>
        <div class="container">
            <div class="content-center brand">
                <div class="row">
                    <form class="col-lg-10 col-md-12 offset-lg-1 offset-md-1" action="verif_connexion.php" method="post" autocomplete="off">
                        <div id="square7" class="square square-7"></div>
                        <div id="square8" class="square square-8"></div>
                        <div class="card card-register">
                            <div><br><br><center><img src="./assets/img/logoAppBig.png" alt=""></center><br><br><h2 style="color: white"><strong><center>GRS•ESI</center></strong></h2>
                            </div>
                            <div class="card-body">
                                <form class="form">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tim-icons icon-email-85"></i>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="Email" class="form-control" name="email">
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tim-icons icon-lock-circle"></i>
                                            </div>
                                        </div>
                                        <input type="password" class="form-control" placeholder="Mot de passe" name="mdp">
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <button type="submit" id="sendlogin" class="btn btn-info btn-round btn-lg">Connexion</button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                // Lors de la visite pour la première fois de la page connexion.php (nouveau PC), le champs du tableau $_SESSION['erreur'] n'existe pas encore, et donc
                if (!isset($_SESSION['erreur']) ) // étape d'initialisation pour éviter que la variable globale 'erreur' définie dans la session, ne disparaisse après avoir visité la page deconnexion.php qui va détruire totalement la session puis rediriger vers connexion.php avec le header location
                    // et donc on tentera d'afficher la variable 'erreur' en croyant que le fait qu'elle n'est pas définie ne va rien afficher, or elle va afficher une erreur. donc c'est pour celà qu'on l'initialise à NULL pour qu'elle n'affiche rien.
                {
                    $_SESSION['erreur']=NULL;
                }
                if ($_SESSION['erreur']!=NULL)
                {
                    //echo '<span style="color:red">'.$_SESSION['erreur'].'</span>'; // on affiche l'erreur récupérée depuis verif_connexion.php et récupérer dans  l'attribut $_SESSION['erreur'] que nous avons défini
                     ?> <div class="alert alert-danger alert-with-icon">
                            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="tim-icons icon-simple-remove"></i>
                    </button>
                    <span data-notify="icon" class="tim-icons icon-support-17"></span>
                    <span>
                    <?php echo $_SESSION['erreur']; ?></span>
                  </div>
                  <?php 
                    $_SESSION['erreur']=NULL; // On remet l'attribut à NULL (vide) après avoir affiché l'erreur, pour pouvoir le réutiliser.
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!--   Core JS Files   -->
<script src="./assets/js/core/jquery.min.js" type="text/javascript"></script>
<script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="./assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<script src="./assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="./assets/js/plugins/bootstrap-switch.js"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="./assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
<!-- Chart JS -->
<script src="./assets/js/plugins/chartjs.min.js"></script>
<!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
<script src="./assets/js/plugins/moment.min.js"></script>
<script src="./assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
<!-- Black Dashboard DEMO methods, don't include it in your project! -->
<script src="./assets/demo/demo.js"></script>
<!-- Control Center for Black UI Kit: parallax effects, scripts for the example pages etc -->
<script src="./assets/js/blk-design-system.min.js?v=1.0.0" type="text/javascript"></script>
</body>
</html>