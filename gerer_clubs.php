<?php
session_start();
$admin = NULL;
require_once 'config.php';
if (isset($_SESSION['privilege']) && $_SESSION['privilege'] == 1) {
    ?>
    <html>
    <title>
        Gestion des profils
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet"/>
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet"/>
    <!-- CSS Files -->
    <link href="./assets/css/blk-design-system.css?v=1.0.0" rel="stylesheet"/>
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="./assets/demo/demo.css" rel="stylesheet"/>
    <link href="./assets/css/swiper.min.css" rel="stylesheet"/>
    <link href="./assets/css/styleSwiper.css" rel="stylesheet"/>
    <link href="modal.css" rel="stylesheet"/>

    </head>
    <body class="landing-page" style="background-color: #2a2f63;">
    <?php include 'navbar.php';?>
    <!-- //bouton ajouter club -->



    <center>
        <button type="button" class="btn btn-info" data-toggle="modal"
                data-target="#exampleModal4" style="top: 120px;z-index: 50;">Ajouter un compte
        </button>
        </a>
    </center>

    <div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><strong>Ajout d'un compte :</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="verif_ajout_club.php" method="post" autocomplete="off">


                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="tim-icons icon-badge"></i></span>
                            </div>
                            <input name="nom" type="text" class="form-control" placeholder="Nom du profil" style="font-size: medium;color: black">
                        </div>



                        <div class="input-group ">
                            <div class="input-group-prepend ">
                                <span class="input-group-text" ><i class="tim-icons icon-email-85"></i></span>
                            </div>
                            <input name="email" type="email" class="form-control " placeholder="Adresse e-mail du profil" style="font-size: medium;color: black">
                        </div>



                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="tim-icons icon-lock-circle"></i></span>
                            </div>
                            <input name="mdp" type="password" class="form-control" placeholder="Nouveau mot de passe" style="font-size: medium;color: black">
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="form-check">
                                    <label class="form-check-label" style="color: #1f2251">
                                        <input name="choix_privilege" value="1" class="form-check-input" type="checkbox">
                                        <span class="form-check-sign"></span>
                                        Administrateur
                                    </label>
                                </div>
                            </div>

                        </div>



                        <br>
                        <button style="background-position: left;" type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="submit" id="sendlogin" class="btn btn-primary" style="background-position: right">Ajouter le profil</button>
                    </form>



                </div>
            </div>
        </div>
    </div>


    <?php
    if (!empty($_SESSION['erreur']))
    {
        if (($_SESSION['erreur'])=='ok')
        {
            ?>
            <div class="alert alert-success alert-with-icon" style="    width: 30%; z-index: 1000; margin: auto; top: 60%;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <center><span><strong>compte ajouté avec succés</strong></span></center>
            </div>
            <?php
$_SESSION['erreur']=NULL;
        }
          }
    ?>


    <!-- fin bouton ajouter club -->
    <div class="wrapper" style="height: 850px;">
        <div class="page-header">
            <img src="./assets/img/blob.png" class="path">
            <img src="./assets/img/triunghiuri.png" class="shapes triangle">
            <img src="./assets/img/cercuri.png" class="shapes circle"
                 style="top: 600px;left: 450px;max-height: 150px;opacity: 0.08;z-index: -1;">
            <img src="./assets/img/cercuri.png" class="shapes circle"
                 style="top: 750px; left: 50px;max-height: 100px;opacity: 0.15;">
            <div class="container">
                <div class="wrapper">
                    <div class="page-header">
                        <?php
                        require_once 'config.php';
                        $bdd->query('SET NAMES UTF8');
                        $requete = $bdd->prepare('SELECT * FROM comptes');
                        $requete->execute(array($_SESSION['id'])); // On ne liste pas le compte de l'administrateur parmi les profils! s'il veut changer son mot de passe ou son email il a, comme tous les profils, la section "Changer Email" et "Changer MDP"
                        $resultat = $requete->fetch();
                        echo '<div class="swiper-container">';
                        echo '<div class="swiper-wrapper " style="height: 830px;top: 100px;" >';
                        while ($resultat != NULL) {

                            echo '<div class="swiper-slide" style="width: 350px;height: 720px;">';
                            echo '<div class="imgBx">';
                        if ($resultat['privilege'] == 1)//si c'est l'admin principal ou les sadmins secondaires
                        {
                            echo '<img src="assets/img/lace.png">';;
                        }
                            if ($_SESSION['id'] == $resultat['id']) {
                                if ($_SESSION['privilege'] == 1)//si c'est l'admin principal ou les sadmins secondaires
                                {
                                    echo '<a style="padding-left: 180px; color: green">Connecté</a>&nbsp;<img src="./assets/img/rec%20(1).png"><br><br><br>';;
                                }
                            }
                            if ($resultat['photo'] != null) {
                                echo '<br>

<img src="avatars/' . $resultat['id'] . '.png' . '" style="width:100%; padding-left:2px;"/> ';
                            } else {
                                echo '<br><img src="avatars/0.png' . '" style="width:100%; padding-left:2px;"/> ';
                            }
                            echo '</div><br>';
                            echo '<div style="text-align:center; padding-left:20px; padding-right:20px;padding-top:10px;padding-bottom:10px; border:1px solid white;background: linear-gradient(to right,rgb(133, 156, 237), rgb(137, 16, 99));color:white;font-size: large;height: 75px;">' . $resultat['nom'] . '<br>' . $resultat['email'] . '</div>';
                            if ($resultat['id'] == 1) {
                                $rang = "Administrateur principal";
                            } else {
                                if ($resultat['privilege'] == 1) {
                                    $rang = "Administrateur secondaire";
                                } else {
                                    $rang = "Profil normal";
                                }
                            }
                            //echo '<div style="text-align:center; padding-left:20px; padding-right:20px;padding-top:1px;padding-bottom:11px; border:1px solid white;background: linear-gradient(to right,rgb(76, 0, 0), rgb(76, 0, 0));color:white;font-size: large;height: 30px;">'.$rang.'</div><br>';
                            if ($_SESSION['id'] != $resultat['id']) {

                                if ($resultat['id'] != 1)// Ce n'est pas l'administrateur principal qui est connecté (c'est un admin secondaire) et il n'a aucun droit sur l'administrateur principal (ni modification d'email, ni changement de mdp..)
                                {
                                    $request = $bdd->prepare('SELECT * FROM comptes WHERE id=?');
                                    $request->execute(array($resultat['id']));
                                    $result = $request->fetch();
                                    if ($result == NULL) {
                                        header("Location: gerer_clubs.php");
                                        exit;
                                    } else {
                                        if ($_SESSION['id'] == $resultat['id']) // le service culturel (ou l'admin) tente d'accéder au lien changer_email_par_admin?id=<<L'id_du_service>> alors qu'il n'est pas listé sur la page gerer_clubs.php
                                        {
                                            header("Location: mon_profil.php");
                                            exit;

                                        }
                                    }

                                    if (($_SESSION['id'] != 1) && ($resultat['id'] == 1)) // c'est un admin secondaire qui est connecté et il essaye de changer l'email de l'admin principal, il n'a pas le droit
                                    {
                                        header("Location: gerer_clubs.php");
                                        exit;
                                    }


                                    echo '<br><center><button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModal' . $resultat['id'] . '1">
                   Modifier l\'email
                </button>
            </center>
        <!-- Modal -->
            <link href="modal.css" rel="stylesheet"/>
        <div class="modal fade" id="exampleModal' . $resultat['id'] . '1"  style="padding-right: 1px; margin-right: 3%;margin-left: 3%;" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">'; ?>
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content" style="background-color: #1f2251">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                    <form action="verif_changement_email_par_admin.php" method="post"
                                    autocomplete="off">

                                    <div class="form-group">
                                        <?php
                                        if ($result['photo'] == 1) {
                                            echo '<img src="avatars/' . $result['id'] . 'min.png' . '" width="20%"/> &nbsp;<a class="text-white">' . $result['nom'] . '</a>';

                                        } else {
                                            echo '<a class="text-white">' . $result['nom'] . '</a>';

                                        }
                                        ?>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <a class="text-white"><strong>E-mail actuel
                                                : </strong><?php echo $result['email']; ?></a>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                                        <div class="input-group ">
                                            <div class="input-group-prepend ">
                                                    <span class="input-group-text"><i
                                                                class="tim-icons icon-email-85"></i></span>
                                            </div>
                                            <input type="email" placeholder="Nouvel e-mail" class="form-control"
                                                   name="nouvelemail" required>
                                        </div>
                                    </div>
                                    <br>
                                        <center>
                                            <button type="submit" id="envoyer" class="btn btn-primary">Modifier
                                                l'e-mail
                                            </button></center>
                                   <?php echo '

                                    </form>

                                                    </div>
                                                </div>
                                            </div></div>';
                                    //voila le contorle d'erreur

                                    echo '<br>';

                                    // Contrôles de sécurité d'URL (impossible d'y accéder par le lien si les droits sont insuffisants: Voir la partie Sécurisation de l'application du rapport)
                                    if (!(isset($_SESSION['email']) AND isset($_SESSION['mdp']))) {
                                        $_SESSION['lien'] = $_SERVER['REQUEST_URI'];
                                        header("Location: connexion.php");
                                        exit;

                                    }
                                    if ($_SESSION['privilege'] == 0) {
                                        header("Location: interface.php");
                                        exit;
                                    }
                                    $request = $bdd->prepare('SELECT * FROM comptes WHERE id=?');
                                    $request->execute(array($resultat['id']));
                                    $result = $request->fetch();
                                    if ($result == NULL) {
                                        header("Location: gerer_clubs.php");
                                        exit;
                                    } else {
                                        if ($_SESSION['id'] == $resultat['id']) // le service culturel (ou l'admin) tente d'accéder au lien changer_email_par_admin?id=<<L'id_du_service>> alors qu'il n'est pas listé sur la page gerer_clubs.php
                                        {
                                            header("Location: mon_profil.php");
                                            exit;

                                        }
                                    }

                                    if (($_SESSION['id'] != 1) && ($result['id'] == 1)) // c'est un admin secondaire qui est connecté et il essaye de changer l'email de l'admin principal, il n'a pas le droit
                                    {
                                        header("Location: gerer_clubs.php");
                                        exit;
                                    }

                                    echo '<center><button type="button" class="btn btn-info" data-toggle="modal"
                        data-target="#exampleModal' . $resultat['id'] . '2">
                   Modifier le MDP
                </button>
            </center>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal' . $resultat['id'] . '2" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content" style="background-color: #1f2251">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <form action="verif_changement_mdp_par_admin.php" method="post" autocomplete="off">

                        <div class="form-group">
                            <strong>';
                                    if ($result['photo'] == 1) {
                                        echo '<img src="avatars/' . $resultat['id'] . 'min.png' . '" width="20%"/> &nbsp;</strong><a class="text-white">' . $resultat['nom'] . '</a>';

                                    } else {
                                        echo '<a class="text-white">' . $resultat['nom'] . '</a>';

                                    }

                                    echo '</div><br>
                        <div class="form-group">
                            <a class="text-white"><strong>E-mail actuel : </strong>' . $resultat['email'] . '</a>
                        </div><br>
                        <div class="form-group">
                            <input type="hidden" name="id" value="' . $resultat['email'] . '">
                            <div class="input-group ">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text" ><i class="tim-icons icon-email-85"></i></span>
                                </div>
                                <input type="password" placeholder="Nouveau mot de passe" class="form-control" name="nouveaumdp" required>
                            </div>
                        </div><br>';?>
                        <center><button type="submit" id="envoyer" class="btn btn-info">Modifier le MDP</button></center>
                                    <?php

                                    echo '</form>
                                </div>
                                </div>
                                </div>
                                </div>';
                                    echo '<br>';
                                    echo '
            <center>
                <button type="button" class="btn btn-warning" data-toggle="modal"
                        data-target="#exampleModal' . $resultat['id'] . '3">Supprimer le profil et ses demandes
                </button>
            </center>
     
        <!-- Modal -->
        <div class="modal fade" id="exampleModal' . $resultat['id'] . '3" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">'; ?>
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="mssg">Voulez-vous vraiment supprimer ce club ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        Annuler
                                                    </button>
                                                    <?php echo '<a class="btn btn-warning" href="supprimer_club.php?id=' . $resultat['id'] . '">OK</a>'; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php    }
                            }

                            echo '</div>';
                            $resultat = $requete->fetch();
                        }

                            echo '</div><div class="swiper-pagination" style="top: 810px;"></div></div>
                            
                        </div>
                    </div>';

                        if (($_SESSION['erreur']!=NULL)&&($_SESSION['erreur']!='ok1')&&($_SESSION['erreur']!='ok2')&&($_SESSION['erreur']!='ok3')&&($_SESSION['erreur']!='ok'))
                        {
                            echo '<div class="alert alert-warning" role="alert" style="width: 40%; z-index: 1;top: -65%;margin: auto;"><center>'.$_SESSION['erreur'].'</center>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
                            $_SESSION['erreur']=NULL;
                        }else{
                            if ($_SESSION['erreur']=='ok1')
                            {
                                echo '<div class="alert alert-success" role="alert" style="width: 40%; z-index: 1;top: -65%;margin: auto;"><center>Adresse e-mail modifiée avec succes.</center>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
                                $_SESSION['erreur']=NULL;
                            }
                            if ($_SESSION['erreur']=='ok2')
                            {
                                echo '<div class="alert alert-success" role="alert" style="width: 40%; z-index: 1;top: -65%;margin: auto;"><center>Mot de passe modifié avec succes.</center>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
                                $_SESSION['erreur']=NULL;
                            }
                            if ($_SESSION['erreur']=='ok3')
                            {
                                echo '<div class="alert alert-success" role="alert" style="width: 40%; z-index: 1;top: -65%;margin: auto;"><center>Compte supprimé avec succes.</center>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
                                $_SESSION['erreur']=NULL;
                            }
                        }





                        ?>



                    <script type="text/javascript" src="swiper.min.js"></script>
                    <script>
                        var swiper = new Swiper('.swiper-container', {
                            effect: 'coverflow',
                            grabCursor: true,
                            centeredSlides: true,
                            slidesPerView: 'auto',
                            coverflowEffect: {
                                rotate: 0,
                                stretch: 0,
                                depth: 100,
                                modifier: 1,
                                slideShadows: true,
                            },
                            pagination: {
                                el: '.swiper-pagination',
                            },
                        });
                    </script>
                </div>
            </div>


                                    </div></div></div></div></div></div>
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
            $(document).ready(function () {
                // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
                demo.initLandingPageChart();
            });
        </script>
    </body>
    </html>

    <?php
} else {

    if (!isset($_SESSION['privilege'])) {
        $_SESSION['lien'] = $_SERVER['REQUEST_URI'];
        header("Location: connexion.php");
        exit;
    }
    header("Location: interface.php");
    exit;
}
?>