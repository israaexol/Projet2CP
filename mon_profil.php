<?php
session_start(); // Partout

if (!isset($_SESSION['email']))
{   
     $_SESSION['lien']=$_SERVER['REQUEST_URI'];
    header("Location: connexion.php"); // Retour à connexion.php
    exit;
}

require_once 'config.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        Mon profil
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
                    <div class="card card-coin card-plain" style="width: 550px;left: -52px;background:papayawhip;background-color: rgba(149,208,219,0.15);border-radius: 20px;">
                        <div class="card-header">
                            <?php 
                            $requete=$bdd->prepare('SELECT * FROM comptes where id=?');
                            $requete->execute(array($_SESSION['id']));
                            $resultat=$requete->fetch();
                            if ($resultat['photo']!=null)
                            {
                                ?>
                                <img src="./avatars/<?php echo $_SESSION['id']; ?>.png?t=<?php echo time(); ?>" class="img-center img-fluid rounded-circle">
                                <?php
                            }
                            else
                            {
                                ?>  
                                <img src="./avatars/0.png" class="img-center img-fluid rounded-circle">

                                <?php

                            }
                            ?>
                           
                            <h3 class="title text-white"><?php echo $resultat['nom']; ?></h3>
                            <h4 class="title text-white"><?php echo $resultat['email'] ?></h4>

                        </div>
                        <?php 
                        if (!empty($_SESSION['erreur']))
                        {   
                            $verif=1;

                        }
                        ?>
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-primary justify-content-center">
                                <li class="nav-item">
                                    <a class="nav-link <?php if (((isset($verif))&&($_SESSION['num_verif']==1))||(!isset($verif))) echo "active"; ?>" data-toggle="tab" href="#linka">
                                        Modifier l'e-mail
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if ((isset($verif))&&($_SESSION['num_verif']==2)) echo "active"; ?>" data-toggle="tab" href="#linkb">
                                        Modifier le MDP
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if ((isset($verif))&&($_SESSION['num_verif']==3)) echo "active"; ?>" data-toggle="tab" href="#linkc">
                                        Modifier l'avatar
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content tab-subcategories">
                               
                                <div class="tab-pane <?php if (((isset($verif))&&($_SESSION['num_verif']==1))||(!isset($verif))) echo "active"; ?>" id="linka">
                                     <form method="POST" action="verif_changement_email.php" id="modif_email"> 
                                    <div class="table-responsive " >
                                        <div class="input-group ">
                                            <div class="input-group-prepend ">
                                                <span class="input-group-text" ><i class="tim-icons icon-email-85"></i></span>
                                            </div>
                                            <input name="nouvelemail" type="email" class="form-control " placeholder="Nouvel e-mail" style="font-size: medium;">
                                        </div>
                                    </div>
                                    <center><button type="submit" form="modif_email" class="btn btn-twitter" value="Modifier">Modifier</button></center>
                                    <br>
                                </form>
                                <?php 
                                if ((isset($verif))&&($_SESSION['num_verif']==1))
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
                                   Adresse mail modifiée avec succès.</span>
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


                           
                                <div class="tab-pane <?php if ((isset($verif))&&($_SESSION['num_verif']==2)) echo "active"; ?>" id="linkb">
                                    <form method="POST" action="verif_changement_mdp.php" id="modif_mdp"> 
                                     <div class="table-responsive">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="tim-icons icon-lock-circle"></i></span>
                                            </div>
                                            <input name="ancienmdp" type="password" class="form-control" placeholder="Ancien mot de passe" style="font-size: medium;">
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="tim-icons icon-lock-circle"></i></span>
                                            </div>
                                            <input name="nouveaumdp" type="password" class="form-control" placeholder="Nouveau mot de passe" style="font-size: medium;">
                                        </div>
                                    </div>
                                    <center><button type="submit" form="modif_mdp" class="btn btn-twitter" value="Modifier">Modifier</button></center><br>
                                </form>
                                <?php 
                                if ((isset($verif))&&($_SESSION['num_verif']==2))
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
                                   Mot de passe modifié avec succès.</span>
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

                              
                                <div class="tab-pane <?php if ((isset($verif))&&($_SESSION['num_verif']==3)) echo "active"; ?>" id="linkc">
                                    <form method="POST" enctype="multipart/form-data" action="verif_definir_photo.php" id="modif_avatar"> 
                                    <div class="table-responsive">
                                       

                                        <input type="file" name="Avatar" accept="image/*"/>
                                    </div>

                                        <div class="table-responsive">
                                       <center><br> <button type="submit" name="submit" form="modif_avatar" value="maj" class="btn btn-twitter">Mise &agrave; jour de l'avatar</button></center>
                                    

                                    </div>
                                    <br>
                                </form>
                                <?php 
                                if ((isset($verif))&&($_SESSION['num_verif']==3))
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
                                   Avatar mis à jour avec succès.</span>
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
<?php $_SESSION['erreur']=NULL; 
$_SESSION['num_verif']=NULL; ?>
</body>

</html>