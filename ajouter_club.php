<?php 
session_start();

if (!(isset($_SESSION['privilege']) && $_SESSION['privilege']==1)) // on n'autorise que l'administrateur avec le privilège 1 à accéder à cette page .. Si l'utilisateur n'est pas connecté et qu'essaye d'accéder à cette page la variable $_SESSION['privilege'] ne sera pas définie, son isset sera à 0, et donc l'utilisateur sera renvoyé vers interface.php qui prendra le relai de le renvoyer vers connexion.php (car il n'est pas connecté)
{
    if (!isset($_SESSION['privilege']))
    {
         $_SESSION['lien']=$_SERVER['REQUEST_URI'];
        header("Location: connexion.php");
        exit;
    }
    header("Location: interface.php");
    exit;

}
require_once 'config.php';
?>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <title>
        Ajouter un profil
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


</head>

<body class="profile-page" style="background-color: #2a2f63;">

<?php include "navbar.php";?>
<img src="assets/img/path1.png" class="path" style="top: 10px;left: 600px;height: 700px;width: 1000px;"/>
<img src="assets/img/path3.png" class="path path1" style="top: 240px;height: 450px;left: -100px;"/>
<div class="wrapper">
     <div class="page-header">
        <div class="container align-items-center">
            <div class="row">
                   <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                    <div class="card card-coin card-plain" style="width: 550px;left: -52px;">
                      
                        <div class="card-body">
                        <form action="verif_ajout_club.php" method="post" autocomplete="off">

                    
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="tim-icons icon-badge"></i></span>
                                            </div>
                                            <input name="nom" type="text" class="form-control" placeholder="Nom du profil" style="font-size: medium;">
                                        </div>
                             

                       
                                        <div class="input-group ">
                                            <div class="input-group-prepend ">
                                                <span class="input-group-text" ><i class="tim-icons icon-email-85"></i></span>
                                            </div>
                                            <input name="email" type="email" class="form-control " placeholder="Adresse e-mail du profil" style="font-size: medium;">
                                        </div>
                         

                    
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="tim-icons icon-lock-circle"></i></span>
                                            </div>
                                            <input name="mdp" type="password" class="form-control" placeholder="Nouveau mot de passe" style="font-size: medium;">
                                        </div>
                            

                            
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                
                                                <?php 

                                                if ($_SESSION['privilege']==1) // Seul l'administrateur principal peut créer des comptes administrateurs secondaires
                                                {
                                                    ?>
                                                   >

                                                        <div class="form-check">
                                                        <label class="form-check-label">
                                                          <input name="choix_privilege" value="1" class="form-check-input" type="checkbox">
                                                          <span class="form-check-sign"></span>
                                                         Administrateur
                                                        </label>
                                                      </div>
                                                       
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                           
                                        </div>
                            


                        <br>
                            <center><button type="submit" id="sendlogin" class="btn btn-twitter">Ajouter le profil</button></center>
                        </form>
                        <br>
                        <?php 
                        if (!empty($_SESSION['erreur']))
                        {
                            if (($_SESSION['erreur'])=='ok')
                                    {
                                        ?>
                                    <div class="alert alert-success alert-with-icon">
                                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                                      <i class="tim-icons icon-simple-remove"></i>
                                    </button>
                                    <span data-notify="icon" class="tim-icons icon-bell-55"></span>
                                    <span>
                                   Profil ajouté avec succès</span>
                                  </div>
                                  <?php

                                    }
                                    else
                                    {
                                        ?>
                                            <div class="alert alert-danger alert-with-icon">
                                            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                                      <i class="tim-icons icon-simple-remove"></i>
                                    </button>
                                    <span data-notify="icon" class="tim-icons icon-support-17"></span>
                                    <span>
                                    <?php echo $_SESSION['erreur']; ?></span>
                                  </div>
                                  <?php 
                                }

                        }
                        ?>

                       
                    </div>

                            
                          
                        </div>
                    </div>
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
<?php $_SESSION['erreur']=NULL; ?>
</body>

</html>