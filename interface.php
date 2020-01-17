<?php 
session_start(); // Partout
if (isset($_SESSION['email']) AND isset($_SESSION['mdp'])) // Si $_SESSION['email'] existe c'est qu'elle a été définie (et que la connexion a pu être effectuée sans erreur car si il y'avait une erreur on ne serait même pas arrivé à cette page car on aurait affiché l'erreur dans connexion.php)
// De même si on veut tenter d'accéder directement à interface.php via l'URL, sans se connecter. Si la variable $_SESSION est déjà définie c'est que l'utilisateur s'est déjà connecté auparavant donc on pourra lui afficher l'interface (il n'est pas obligé de se connecter à chaque visite), sinon on le renverra à connexion.php (il n'a pas le droit d'accéder à cette page car il n'est pas connecté)
{
$_SESSION['erreur']=NULL; // Réinitialisation de la variable d'erreur globale qu'on a défini, afin de pouvoir l'utiliser
}
else
{
	header("Location: connexion.php"); // Retour à connexion.php 
    exit;

}

$admin=NULL;
require_once 'config.php';

if ($_SESSION['privilege']==1) $admin="adminstrateur ";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        Accueil
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="./assets/css/blk-design-system.css?v=1.0.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="./assets/demo/demo.css" rel="stylesheet" />
    <link href="modal.css" rel="stylesheet"/>
</head>

<body class="landing-page" style="background-color: #2a2f63;">
<?php include 'navbar.php';?>

<div class="wrapper">
    <div class="page-header">
        <img src="./assets/img/blob.png" class="path">
        <img src="./assets/img/path2.png" class="path2">
        <img src="./assets/img/triunghiuri.png" class="shapes triangle">
        <img src="./assets/img/waves.png" class="shapes wave">
        <img src="./assets/img/patrat.png" class="shapes squares">
        <img src="./assets/img/cercuri.png" class="shapes circle">
        <div class="content-center">

            <div class="row row-grid justify-content-between align-items-center text-left">
                <div class="col-lg-6 col-md-6">
                    <font style="color: #2bffc6" size="+3">GRS•ESI
                        <br/>
                    </font>
                    <font size="+1"><strong>GRS•ESI</strong> est une application web qui permet de gérer les réservations des salles pour les activités culturelles de l'ESI.<br><br>Elle permet aux utilisateurs de consulter et de choisir les salles disponibles et d'obtenir les réponses à leurs demandes.
                    </font>
                    <div class="btn-wrapper mb-3">

                    </div>
                    <div class="btn-wrapper">
                        <div class="button-container">


                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5">
                    <img src="./assets/img/1647500.png" alt="Circle image" class="img-fluid">
                </div>
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
<script>
    $(document).ready(function() {
        blackKit.initDatePicker();
        blackKit.initSliders();
    });

    function scrollToDownload() {

        if ($('.section-download').length != 0) {
            $("html, body").animate({
                scrollTop: $('.section-download').offset().top
            }, 1000);
        }
    }
</script>
</body>

</html>