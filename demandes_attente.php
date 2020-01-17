<?php
session_start();

if (isset($_SESSION['privilege'])) {
    include 'fonctions.php';
    require_once 'config.php';

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <head><title>Demandes en attente</title>
            <!--     Fonts and icons     -->
            <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet"/>
            <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
            <!-- Nucleo Icons -->
            <link href="./assets/css/nucleo-icons.css" rel="stylesheet"/>
            <!-- CSS Files -->
            <link href="./assets/css/blk-design-system.css?v=1.0.0" rel="stylesheet"/>
            <!-- CSS Just for demo purpose, don't include it in your project -->
            <link href="./assets/demo/demo.css" rel="stylesheet"/>
            <link href="coche.css" rel="stylesheet"/>
            <link href="modal.css" rel="stylesheet"/>
        </head>

    <body class="profile-page" style="background-color: #2a2f63;">
    <?php include 'navbar.php'; ?>
    <div class="wrapper">
        <section class="section section-lg">
            <section class="section" style="margin-top: -50px;">
                <?php // j'ai effacé temporairement ce qu'il y'avait ici : les deux images du background, car elles rendaient les boutons incliquables
                ?>
            </section>
        </section>

        <div class="container"
             style="background:papayawhip;border-radius: 20px; background-color: rgba(149,208,219,0.15)  ;margin-top: -50px;">
            <center>
                <table class="table table-striped " style="width: 1250px;">
                    <thead>
                    <tr>
                        <th style="font-size: 18px;color: white;">
                            <center>Nom de l'évènement</center>
                        </th>
                        <th style="font-size: 18px;color: white;">
                            <center>Date</center>
                        </th>
                        <th style="font-size: 18px;color: white;width:">
                            <center>Club organisateur</center>
                        </th>
                        <th style="font-size: 18px;color: white;">
                            <center>Status</center>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $bdd->query('SET NAMES UTF8');
                       creation_tmp_collision($bdd);

                     $nb_par_page=10;
                if (isset($_GET['page']))
                {
                       $page_actuelle=intval($_GET['page']);
                }
                else
                {
                    $page_actuelle=1;
                }
                if ($page_actuelle<=0) $page_actuelle=1;
               $debut=($page_actuelle-1)*$nb_par_page;
                $requete = $bdd->prepare('SELECT * FROM events WHERE (valide=0 OR valide=4) AND club_id=? ORDER BY id DESC');
                    $requete->execute(array($_SESSION['id']));
                $nb_results= $requete->rowCount();

                $requete = $bdd->prepare('SELECT * FROM events WHERE (valide=0 OR valide=4) AND club_id=? ORDER BY id DESC LIMIT '.$debut.','.$nb_par_page);
                    $requete->execute(array($_SESSION['id']));

                 $nb_pages=floor($nb_results/$nb_par_page); // partie entière 
                if ($nb_results%$nb_par_page >0) $nb_pages++;
                    
                    $resultat = $requete->fetch();
                    while ($resultat != NULL) {
                        echo '<tr>';
                        echo '<td ><center><a class="btn btn-link" style="color: white;" href="gerer_event.php?id=' . $resultat['id'] . '">' . $resultat['titre'] . '</a></center></td>';
                        echo '<td><center><a class="text-white">' . $resultat['date'] . '</a> </center></td>';
                        $requete2 = $bdd->prepare('SELECT * FROM comptes WHERE id=?');
                        $requete2->execute(array($resultat['club_id']));
                        $resultat2 = $requete2->fetch();
                        $photo = $resultat2['photo'];
                        if ($photo == 1) {
                            echo '<td><center><img src="avatars/' . $_SESSION['id'] . 'min.png' . '" width="24px"/><a style="color:white;">&nbsp ' . $resultat2['nom'] . '</a></center></td>';

                        } else {
                            echo '<td><center><a style="color:white;">' . $resultat2['nom'] . '</a></center></td>';

                        }

                        if ($resultat['valide'] == 0) {
                            if ($resultat['date'] > date('Y-m-d')) {
                                echo '<td><span class="badge badge-warning">En attente</span></td>';
        echo ' <td>
            <center>
               <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModal' . $resultat['id'] . '1">
                    Modifier les salles
                </button>
            </center>
        </td>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal' . $resultat['id'] . '1" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">'; ?>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="wsh">

                    <?php
                    $_GET['id'] = $resultat['id'];
                    if (isset($_SESSION['privilege']) && (isset($_GET['id']))) {
                        require_once 'config.php';
                        $bdd->query('SET NAMES UTF8');
                        $date_evt = $bdd->prepare('SELECT * FROM events WHERE id=?');
                        $date_evt->execute(array($_GET['id']));
                        $res_evt = $date_evt->fetch();
                        $valide = $res_evt['valide'];
                        $privilege = $_SESSION['privilege'];
                        $id_club = $_SESSION['id'];
                        $expire = 0;
                        if ($res_evt['date'] <= date('Y-m-d')) {
                            $expire = 1;
                        }


                        ?>

                        <div class="container">
                            <div class="row justify-content-center align-items-center"
                                 style="height:50vh">
                                <div class="col-6" style="max-width: 30%; right: 32.5%;">
                                    <div class="card">
                                        <div class="card-body"
                                             style="background-color: white;">
                                            <div class="form-group"
                                                 style="background-color: white;">
                                                <form method="POST"
                                                      action="changer_salles_traitement.php?id=<?php echo $_GET['id'] ?>"
                                                      style="font-size: large">
                                                    <input name="verif_envoi" type="hidden"
                                                           value="1">
                                                    <div class="panel-group" id="accordion">

                                                        <?php

                                                        $jours = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
                                                        $creneaux = ['08:30 - 09:30', '09:30 - 10:30', '10:30 - 11:30', '11:30 - 12:30', '12:30 - 13:30', '13:30 - 14:30', '14:30 - 15:30', '15:30 - 16:30', '16:30 - 17:30'];


                                                        $jour = date('w', strtotime($res_evt['date']));

                                                        $salles = $bdd->query('SELECT * FROM salles_id ORDER BY nom');


                                                        creation_tmp_occupe($res_evt['date'], $bdd);


                                                        $result = $salles->fetch();
                                                        while ($result != NULL) {
                                                            ?>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse"
                                                                           data-parent="#accordion"
                                                                           href="#<?php echo $result['nom'] ?>"><?php echo $result['nom']; ?></a>
                                                                    </h4>
                                                                </div>

                                                                <?php
                                                                $req11 = $bdd->prepare('SELECT * FROM salles_events WHERE id_event=? AND salle=?'); //l'event est en attente car pour l'instant on ne permet le changement de salles qu'aux events en attente (pour les evenements validés, la solution (pas ici) serait de les remettre en attente pendant une fraction de seconde juste pour que leurs salles n'occupent plus effectivement le calendrier, et donc ils seront affichés dans le formulaire, dès que l'affichage se termine on les remet à valide=1)
                                                                $req11->execute(array($_GET['id'], $result['nom']));
                                                                $res_req11 = $req11->fetch();
                                                                $cpt = 0;
                                                                while ($res_req11 != NULL) {

                                                                    $req12 = $bdd->prepare('SELECT * FROM tmp_occupe WHERE salle=? AND creneau =?');
                                                                    $req12->execute(array($result['nom'], $res_req11['creneau']));
                                                                    $res_req12 = $req12->fetch();
                                                                    if ($res_req12 == NULL) // donc la séance prise par la salle n'est pas occupée par un évenement validé
                                                                    {
                                                                        $cpt++;
                                                                    }
                                                                    $res_req11 = $req11->fetch();
                                                                }

                                                                ?>
                                                                <div id="<?php echo $result['nom'] ?>"
                                                                     class="panel-collapse collapse <?php if ($cpt != 0) echo "show"; ?>">
                                                                    <div class="panel-body">
                                                                        <?php
                                                                        $planning = choix_planning(strtotime($res_evt['date']), $bdd);
                                                                        if ($planning == 0) {
                                                                            $request = $bdd->prepare('SELECT * FROM planning_vacances WHERE Jour=? AND ID=?');  // Planning des weekends et de vacances
                                                                        } else {
                                                                            if ($planning == 1) {
                                                                                $request = $bdd->prepare('SELECT * FROM planning_s1 WHERE Jour=? AND ID=?');  //Semestre 1

                                                                            } else {
                                                                                $request = $bdd->prepare('SELECT * FROM planning_s2 WHERE Jour=? AND ID=?');
                                                                            }
                                                                        }
                                                                        $request->execute(array($jours[$jour], $result['nom']));

                                                                        $res = $request->fetch();
                                                                        while ($res != NULL) {
                                                                            $recherche_dans_tmp_occupe = $bdd->prepare('SELECT * FROM tmp_occupe WHERE salle=? AND creneau=?');
                                                                            $recherche_dans_tmp_occupe->execute(array($res['ID'], $res['Creneau']));
                                                                            $resultat_recherche = $recherche_dans_tmp_occupe->fetch();
                                                                            if ($resultat_recherche == NULL) {
                                                                                $req21 = $bdd->prepare('SELECT * FROM salles_events WHERE salle=? AND creneau=? AND id_event=?');
                                                                                $req21->execute(array($res['ID'], $res['Creneau'], $_GET['id']));
                                                                                $res_req21 = $req21->fetch();
                                                                                $coche = 0;
                                                                                if ($res_req21 != NULL) {
                                                                                    $coche = 1;
                                                                                }


                                                                                ?>


                                                                                <label class="customcheck"
                                                                                       style="color: black"><?php echo $res['Jour'] . " " . "Séance " . $res['Creneau'] . " (" . $creneaux[$res['Creneau'] - 1] . ")"; ?>
                                                                                    <input type="checkbox"
                                                                                           name="choix[]"
                                                                                           value="<?php echo $res['id_ligne']; ?>" <?php if ($coche == 1) echo "checked"; ?>>
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                                <?php
                                                                            } // fin du if ($resultat_recherche!=NULL), donc on n'a trouvé aucune occurence dans la table des salles occupées pour la séance qui est dans $res, et celà pour la date donnée et pour tous les évenements validés seulement. (on ne s'intéressera pas à l'occupation des salles par les évenements non validés du faits que les salles resteront toujours disponibles tant que l'évenement n'est pas validé)
                                                                            $res = $request->fetch();
                                                                        }

                                                                        ?>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $result = $salles->fetch();
                                                        }
                                                        ?>


                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" name="envoyer"
                                                                value="2"
                                                                class="btn btn-primary">
                                                            Modifier
                                                            les salles
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">
                                                            Annuler
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php

                    } else {
                        if (!isset($_SESSION['privilege'])) {
                            $_SESSION['lien'] = $_SERVER['REQUEST_URI'];
                            header("Location: connexion.php");
                            exit;
                        }

                        header("Location: interface.php");
                        exit;
                    } ?>

                </div>
            </div>
        </div>
    <?php echo '</div>';

    //Annuler event modal
         echo ' <td>
            <center>
                <button type="button" class="btn btn-warning" data-toggle="modal"
                        data-target="#exampleModal' . $resultat['id'] . '2">
                    Annuler l\'évènement
                </button>
            </center>
        </td>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal' . $resultat['id'] . '2" tabindex="-1" role="dialog"
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
                    <p id="mssg">Voulez-vous vraiment annuler cet évènement ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Annuler
                    </button>
                    <?php echo '<a class=" btn btn-warning" href="annuler_demande.php?id=' . $resultat['id'] . '">OK</a>'; ?>
                </div>
            </div>
        </div>


    <?php echo'</div>';




                                $req_collision = $bdd->prepare('SELECT * FROM tmp_collision WHERE event_attente=?');
                                $req_collision->execute(array($resultat['id']));
                                $res_collision = $req_collision->fetch();
                                if ($res_collision != NULL) {
                                    echo '<td><center><a style="color: #e60000;font-size: 20px;"><strong>COLLISION</strong></a></center></td><td></td><td></td>';

                                }

                            } else {
                                echo '<td><span class="label label-default">En attente et expir&eacute;</span></td><td></td><td></td>';

                            }

                        } else // donc l'event est en attente puis annulé par le club (validé=4)
                        {
                            echo '<td><span class="badge badge-danger">En attente puis annul&eacute;</span></td><td></td><td></td>';


                        }


                        echo '</tr>';
                        $resultat = $requete->fetch();
                    }

                    ?>


                    </tbody>
                </table>

            </center>


        </div>
    </div>
     <div style="   width: -moz-fit-content;
    width: -webkit-fit-content;
    width: fit-content;

  display: block;
  margin-left: auto;
  margin-right: auto;">
         <nav>
              <ul class="pagination pg-blue">
                
                <?php
              

                if ($page_actuelle==1)
                {
                    $cpt=1;
                    while (($cpt<=3) && ($cpt<=$nb_pages))
                    {
                         if ($cpt==$page_actuelle)
                        {
                             echo '<li class="page-item active"><a href="demandes_attente.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                        }
                        else
                        {
                            echo '<li class="page-item"><a href="demandes_attente.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                        }
                        $cpt++;

                    }
                    if ($nb_pages>3)
                    {
                        ?>
                                 <li class="page-item">
                            <?php 
                                if ($page_actuelle!=$nb_pages)
                                {

                                ?>
                          <a href="demandes_attente.php?page=<?php echo $nb_pages; ?>" class="page-link" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Last</span>
                          </a>
                          <?php 
                              }
                              ?>
                        </li>
                        <?php
                    }
                }
                else
                {
                    if ($page_actuelle==$nb_pages)
                    {
                        if ($nb_pages<=3)
                        {
                            $cpt=1;
                            while (($cpt<=3) && ($cpt<=$nb_pages))
                            {
                                 if ($cpt==$page_actuelle)
                                {
                                     echo '<li class="page-item active"><a href="demandes_attente.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="demandes_attente.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                $cpt++;

                            }

                        }
                        else
                        {
                            $cpt=$nb_pages-2;
                            ?>
                                        <li class="page-item">
                                <?php 
                                    if ($page_actuelle!=1)
                                    {

                                    ?>
                              <a class="page-link" href="demandes_attente.php" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">First</span>
                              </a>
                                 <?php 
                                     }
                                     ?>

                            </li>
                            <?php
                            while ($cpt<=$nb_pages)
                            {
                                if ($cpt==$page_actuelle)
                            
                                {
                                     echo '<li class="page-item active"><a href="demandes_attente.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="demandes_attente.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                       
                               $cpt++;

                            }
                          
                        }
                       
                       
                             

                    }
                    else
                    {
                        if ($nb_pages==3) // ie $page_actuelle est forcément à 2
                        {
                            $cpt=1;
                            while ($cpt<=$nb_pages)
                            {
                                if ($cpt==$page_actuelle)
                            
                                {
                                     echo '<li class="page-item active"><a href="demandes_attente.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="demandes_attente.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                       
                               $cpt++;

                            }

                        }
                        else
                        {
                            $cpt=$page_actuelle-1;
                            if ($page_actuelle!=2)
                                {
                                                ?>
                                                    <li class="page-item">
                                            <?php 
                                                if ($page_actuelle!=1)
                                                {

                                                ?>
                                          <a class="page-link" href="demandes_attente.php" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">First</span>
                                          </a>
                                             <?php 
                                                 }
                                                 ?>

                                        </li>
                                        <?php

                                }
                            while ($cpt<=$page_actuelle+1)
                            {
                                if ($cpt==$page_actuelle)
                            
                                {
                                     echo '<li class="page-item active"><a href="demandes_attente.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="demandes_attente.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                 

                                $cpt++;
                            }

                                if ($page_actuelle!=$nb_pages-1)
                                {
                                                ?>
                                             <li class="page-item">
                                        <?php 
                                            if ($page_actuelle!=$nb_pages)
                                            {

                                            ?>
                                      <a href="demandes_attente.php?page=<?php echo $nb_pages; ?>" class="page-link" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Last</span>
                                      </a>
                                      <?php 
                                          }
                                          ?>
                                    </li>
                                    <?php
                                }
                        }

                    }
                }
               
                ?>
               
              </ul>
            </nav>
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
    <?php
} else {
    $_SESSION['lien'] = $_SERVER['REQUEST_URI'];
    header("Location: connexion.php");
    exit;
}
?>