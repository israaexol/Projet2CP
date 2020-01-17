<?php
session_start();
include 'fonctions.php';

if (isset($_SESSION['privilege'])) {
    if (isset($_GET['id'])) {
        require_once 'config.php';
        $bdd->query('SET NAMES UTF8');
        $requete = $bdd->prepare('SELECT * FROM events WHERE id=?');
        $requete->execute(array($_GET['id']));
        $resultat = $requete->fetch();
        $privilege = $_SESSION['privilege'];
        $club_id = $_SESSION['id'];
        if ($resultat != NULL) {
            if (($privilege == 0) && ($resultat['club_id'] != $club_id)) {
                if ($resultat['valide'] != 1) {
                    header("Location: interface.php");
                    exit;
                }

            }

            ?>
            <html>
            <head><title><?php echo $resultat['titre'] ?></title>
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
                <link href="./assets/css/separator.css" rel="stylesheet"/>
                <link href="coche.css" rel="stylesheet"/>
                <link href="modal.css" rel="stylesheet"/>
            
            </head>

            <body class="register-page" style="background-color: #2a2f63;">
<?php include 'navbar.php';  ?>

                <div class="container align-items-center">
                    <div class="row">
                        <div class="col-lg-7 col-md-10 ml-auto mr-auto">
                            <div class="card card-coin card-plain"  style="top: 200px;background:papayawhip;background-color: rgba(149,208,219,0.15);border-radius: 20px;">
                                <div class="card-header">
                                    <?php

                                    if (($resultat['valide'] == 0) && ($resultat['date'] > date('Y-m-d'))) {
                                        $verif_collision = 1;
                                        creation_tmp_collision($bdd);
                                        $req_colli = $bdd->prepare('SELECT * FROM tmp_collision WHERE event_attente=?');
                                        $req_colli->execute(array($resultat['id']));
                                        $res_colli = $req_colli->fetch();
                                        if ($res_colli != NULL) {
                                            $collision = 1;
                                        } else {
                                            $collision = 0;
                                        }
                                    } else {
                                        $verif_collision = 0;
                                        $collision = 0;
                                    }
                                    ?>
                                    <?php 
                                    $requete2 = $bdd->prepare('SELECT * FROM comptes WHERE id=?');
                                    $requete2->execute(array($resultat['club_id']));
                                    $resultat2 = $requete2->fetch();
                                    $photo = $resultat2['photo'];
                                    if ($photo==1)
                                    {
                                        echo ' <img src="./avatars/' . $resultat['club_id'] . '.png' . '" class="img-center img-fluid rounded-circle">';
                                    }
                                    else
                                    {
                                        echo ' <img src="./avatars/0.png" class="img-center img-fluid rounded-circle">';
                                     
                                    }
                                    ?>

                                    <h4 class="title">Fiche technique de l'évènement</h4>
                                </div>
                                    <div class="tab-content tab-subcategories" style="font-size: 15px;">
                                        <div class="tab-pane active" id="linka">
                                            <div class="hr-separator"></div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <strong style="color: white">Club organisateur :</strong>
                                                </div>
                                                <div class="col-md-5 text-white">
                                                    <?php 
                                                    if ($photo == 1) {
                                                        echo '<img src="avatars/' . $resultat['club_id'] . 'min.png' . '" style="width:30px"/> ';

                                                    }
                                                    echo $resultat2['nom']; ?>
                                                </div>
                                            </div>
                                            <div class="hr-separator"></div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <strong style="color: white" >Titre :</strong>
                                                </div>
                                                <div class="col-md-8 text-white" >
                                                    <?php echo $resultat['titre']; ?>
                                                </div>
                                            </div>
                                            <div class="hr-separator"></div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <strong style="color: white">Type :</strong>
                                                </div>
                                                <div class="col-md-8 text-white">
                                                    <?php echo $resultat['type']; ?>
                                                </div>
                                            </div>
                                            <div class="hr-separator"></div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <strong style="color: white">Date :</strong>
                                                </div>
                                                <div class="col-md-8 text-white">
                                                    <?php echo $resultat['date']; ?>
                                                </div>
                                            </div>

                                              
                                                                <div class="hr-separator"></div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <strong style="color: white">Nombre de participants :</strong>
                                                        </div>
                                                        <div class="col-md-4 text-white">
                                                            <?php echo $resultat['nb_participants']; ?>
                                                        </div>
                                                    </div>
                                                    

                                            <div class="hr-separator"></div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <strong style="color: white">Descriptif :</strong>
                                                </div>
                                                <div class="col-md-8 text-white">
                                                    <?php echo $resultat['descriptif']; ?>
                                                </div>
                                            </div>
                                            <?php if ($resultat['responsable']!=NULL)
                                                    {
                                                        ?>
                                                                <div class="hr-separator"></div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <strong style="color: white">Personne responsable :</strong>
                                                        </div>
                                                        <div class="col-md-4 text-white">
                                                            <?php echo $resultat['responsable']; ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>

                                            <?php if ($resultat['sponsor']!=NULL)
                                                    {
                                                        ?>
                                                                <div class="hr-separator"></div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <strong style="color: white">Sponsor :</strong>
                                                        </div>
                                                        <div class="col-md-8 text-white">
                                                            <?php echo $resultat['sponsor']; ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>
                                            <div class="hr-separator"></div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <strong style="color: white">Salles utilisées :</strong>
                                                </div>
                                                <div class="col-md-8 text-white"><?php
                                                    $requete3 = $bdd->prepare('SELECT * FROM salles_events WHERE id_event=?');
                                                    $requete3->execute(array($resultat['id']));
                                                    $requete3_resultat = $requete3->fetch();
                                                    $creneaux = ['08:30 - 09:30', '09:30 - 10:30', '10:30 - 11:30', '11:30 - 12:30', '12:30 - 13:30', '13:30 - 14:30', '14:30 - 15:30', '15:30 - 16:30', '16:30 - 17:30'];
                                                    if ($requete3_resultat==NULL)
                                                    {
                                                        echo "<b>Aucune</b>";
                                                    }
                                                    while ($requete3_resultat != NULL) {
                                                        if ($verif_collision == 1) {
                                                            $req_collision = $bdd->prepare('SELECT * FROM tmp_collision WHERE event_attente=? AND salle=? AND creneau=?');
                                                            $req_collision->execute(array($resultat['id'], $requete3_resultat['salle'], $requete3_resultat['creneau']));
                                                            $res_collision = $req_collision->fetch();
                                                            if ($res_collision != NULL) // Collision avec un autre évenement pour ce créneau
                                                            { ?>


                                                                <div class="alert alert-danger col-md-10 row-md-2"
                                                                     role="alert">
                                                                    <?php
                                                                    echo '<strong >' . $requete3_resultat['salle'] . '</strong>' . ' ' . $creneaux[$requete3_resultat['creneau'] - 1] . ' (Seance : ' . $requete3_resultat['creneau'] . ') Problème de collision avec l\'evènement <strong>';
                                                                    $req_evt_colli = $bdd->prepare('SELECT * FROM events WHERE id=?');
                                                                    $req_evt_colli->execute(array($res_collision['event_valide']));
                                                                    $res_evt_colli = $req_evt_colli->fetch();
                                                                    echo $res_evt_colli['titre'];
                                                                    echo '</strong><br>'
                                                                    ?>

                                                                </div>

                                                                <?php
                                                            } else {

                                                                echo '<strong>' . $requete3_resultat['salle'] . '</strong>' . ' ' . $creneaux[$requete3_resultat['creneau'] - 1] . ' (Seance : ' . $requete3_resultat['creneau'] . ')<br>';
                                                            }

                                                        } else {
                                                            echo '<strong>' . $requete3_resultat['salle'] . '</strong>' . ' ' . $creneaux[$requete3_resultat['creneau'] - 1] . ' (Seance : ' . $requete3_resultat['creneau'] . ')<br>';

                                                        }

                                                        $requete3_resultat = $requete3->fetch();
                                                    }
                                                    ?></div></div>
                                                    <div class="hr-separator"></div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <strong style="color: white">Status :</strong>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <?php
                                                            if ($resultat['valide'] == 0) {
                                                                if ($resultat['date'] <= date('Y-m-d')) {?>
                                                                    <span class="badge badge-default">En attente puis expiré</span>
                                                                    <?php if ($privilege == 1) {
                                                                        bouton_supprimer($resultat['id'],'&gerer=1');
                                                                    
                                                                    }
                                                                } else {
                                                                    echo '<span class="badge badge-warning">En attente de validation</span>';
                                                                    if ($collision == 1) echo '<br><strong><span style="color:red"> COLLISION</span></strong>';
                                                                    echo '</div></div><div class="hr-separator"></div>
                                                                       <div class="row" >
                                                                         <div class="col-md-12 text-center">';
                                                                    if ($privilege == 1) {
                                                                        if ($collision == 1) {
                                                                            echo '
                                                                           <a ><strike>Valider</strike></a>&nbsp;';
                                                                        } else {


                                                                           bouton_valider($resultat['id']);
                                                                       }
                                                                       bouton_rejeter($resultat['id']);

                                                                        //echo '<a class="btn btn-danger" href="rejeter_event.php?id=' . $resultat['id'] . '"">' . 'Rejeter</a>&nbsp;';
                                                                    }
                                                                    bouton_modifier_salles($resultat['id'],$bdd);
                                                                    if ($privilege == 0) {
                                                                        bouton_annuler($resultat['id'],'demande');
                                                                    }
                                                                }
                                                            } else {

                                                                if ($resultat['valide'] == 1) {

                                                                    if ($resultat['date'] <= date('Y-m-d')) {
                                                                        echo '<span class="badge badge-success">Validé et s\'est déroulé</span>';
                                                                        if ($_SESSION['privilege'] == 1) {
                                                                            bouton_supprimer($resultat['id'],'');
                                                                        }

                                                                    } else {
                                                                        echo '<span class="badge badge-success">Validé et en attente de déroulement</span></div></div>';

                                                                        if ($club_id == $resultat['club_id'])  // n'importe quel profil peut modifier ou annuler son propre évenement (qu'il soit l'admin ou un club)
                                                                        {   bouton_annuler($resultat['id'],'demande');
                                                                            bouton_modifier_salles($resultat['id'],$bdd);
                                                                            if ($privilege == 1) {
                                                                            echo '<br><center><a class="btn btn-default" href="historique_events.php">' . 'Afficher l\'historique</a></center>';
                                                                            }

?>

                </div>
            </div>
        </div>
                                                                        <?php 

                                                                        } else {
                                                                            if ($privilege == 1) // l'administrateur peut annuler et modifier les évenements des autres.
                                                                            {
                                                                                bouton_modifier_salles($resultat['id'],$bdd);
                                                                                bouton_annuler($resultat['id'],'event');

                                                                                echo '<br><center><a class="btn btn-default" href="historique_events.php">' . 'Afficher l\'historique</a></center>';
                                                                            }
                                                                        }


                                                                    }




                                                                } else  // valide=2 (rejeté) ou valide=3(validé puis annulé) ou validé=4(en attente puis anullé)
                                                                {
                                                                    if ($resultat['valide'] == 2) {
                                                                        echo '<span class="badge badge-danger">Rejeté</span></div></div>';
                                                                    } else {
                                                                        if ($resultat['valide'] == 3) {
                                                                            echo '<span class="badge badge-danger">Validé puis annulé</span></div></div>';
                                                                        } else {
                                                                            echo '<span class="badge badge-danger">En attente puis annulé</span></div></div>';
                                                                        }
                                                                    }


                                                                    if ($privilege == 1) {
                                                                        echo '<div class="hr-separator"></div>
                                                                       <div class="row" >
                                                                         <div class="col-md-12 text-center">';
                                                                        if ($resultat['valide'] == 2) {
                                                                            bouton_supprimer($resultat['id'],'&gerer=1');
                                                                        } else {
                                                                            bouton_supprimer($resultat['id'],'&annule=1');

                                                                        }
                                                                         echo '</div></div>';
                                                                    }


                                                                }

                                                            }

                                                            ?>
                                                        </div>
                                                    </div>

                                                </div>
                                    </div></div></div></div></div>


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
            <?php


        } else {
            header("Location: interface.php");
            exit;
        }

    } else {
        header("Location: historique_events.php");
        exit;

    }


} else {
    $_SESSION['lien'] = $_SERVER['REQUEST_URI'];
    header("Location: connexion.php");
    exit;
}
?>