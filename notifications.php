<?php 
session_start(); // Partout
if (!isset($_SESSION['email'])) 
{
    $_SESSION['lien']=$_SERVER['REQUEST_URI'];
    header("Location: connexion.php");
    exit;

}
?>

<html>
<head>
    <title>Notifications</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
<body style="background-color: #2a2f63;background-image: url(./assets/img/dots.png);background-size: contain">
    <?php
   include 'navbar.php';
   require_once 'config.php';
   $bdd->query('SET NAMES UTF8');
   $nb_par_page=5;
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
   $requete=$bdd->prepare('SELECT * FROM notifications WHERE idConcerne=? ORDER BY dateHeureNotif desc');
   if ($_SESSION['privilege']==0)
    {
        $requete->execute(array($_SESSION['id']));
    }
    else
    {
       $requete->execute(array(1));
    }

    $nb_results=$requete->rowCount();

    $requete=$bdd->prepare('SELECT * FROM notifications WHERE idConcerne=? ORDER BY dateHeureNotif desc LIMIT '.$debut.','.$nb_par_page);
   if ($_SESSION['privilege']==0)
    {
        $requete->execute(array($_SESSION['id']));
    }
    else
    {
       $requete->execute(array(1));
    }
    

    $nb_pages=floor($nb_results/$nb_par_page); // partie entière 
    if ($nb_results%$nb_par_page >0) $nb_pages++;





   $resultat=$requete->fetch();

   ?>
<div class="container">
        <div class="row justify-content-center align-items-center" style="height:50vh">
            <div class="col-8" style="max-width: 100.666667%;top: 150px;">
                <div class="card" style="background-color: rgba(149,208,219,0.15) ;">
                    <div class="card-body" style="padding: 0.5rem">
                        <?php
                        if ($resultat==NULL) echo 'Aucune notification jusqu\'à présent';


                        while ($resultat!=NULL)
                        {
                            ?>
                             <a href="<?php echo 'gerer_event.php?id='.$resultat['id_event']; ?>" style="text-decoration: none;">
                                <div class="alert alert-with-icon" style="border:2px solid white;padding-left: 16px;<?php if ($resultat['vu']==0) echo 'background-color: #1f2251;';?>">
                                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="tim-icons icon-simple-remove" style="color: red"></i>
                                    </button>
                                    <p style="color: #11f3c7"><strong><?php echo date('d-m-Y H:i:s',strtotime($resultat['dateHeureNotif'])); ?></strong></p>
                               <p class="text-white">

                                <?php
                                  $req1=$bdd->prepare('SELECT * FROM events WHERE id=?');
                                    $req1->execute(array($resultat['id_event']));
                                    $event=$req1->fetch();
                                    $req12=$bdd->prepare('SELECT * FROM comptes WHERE id=?');
                                    $req12->execute(array($resultat['idActionneur']));
                                    $actionneur=$req12->fetch();
                                    $req13=$bdd->prepare('SELECT * FROM comptes WHERE id=?');
                                    $req13->execute(array($resultat['idConcerne']));
                                    $concerne=$req13->fetch();
                                    $photo=$actionneur['photo'];

                                if ($photo==1)
                                {
                                    echo '<img src="avatars/'.$resultat['idActionneur'].'min.png'.'" width="40px" alt="Raised circle image" class="img-fluid rounded-circle shadow-lg myimg" /> ';

                                }
                                if ($resultat['action']==1) // notif d'ajout de demande
                                {
                                  ?>
                                     Une nouvelle demande d'organisation d'évènement, intitulée<strong> <?php echo $event['titre']; ?></strong> a été envoyée par le club <strong><?php echo $actionneur['nom']; ?></strong>, veuillez l'accepter ou la rejeter.

                                     <?php
                                }
                                else
                                {
                                    if ($resultat['action']==2) // notif de modification de salle
                                    {
                                        if ($resultat['idActionneur']==1) // donc c'est l'admin qui a modifié les salles d'un event d'un club (qu'il soit validé ou en attente)
                                        {
                                            ?>
                                            Les salles de votre demande de l'évènement intitulé <strong><?php echo $event['titre']; ?></strong> viennent d'&ecirc;tre modifi&eacute;es par un administrateur.

                                            <?php

                                        }
                                        else // donc c'est le club qui a modifié les salles de son event validé ou en attente, et au final son event devient en attente pour une nouvelle approbation de validation suite aux modifications
                                        {
                                            ?>

                                            Les salles de la demande de l'évènement intitulé <strong><?php echo $event['titre']; ?></strong> viennent d'&ecirc;tre modifi&eacute;es par le club <strong><?php echo $actionneur['nom']; ?></strong>, veuillez approuver les nouveaux changements.


                                            <?php

                                        }

                                    }
                                    else
                                    {
                                        if ($resultat['action']==3) // notif d'annulation d'un event validé
                                        {
                                            if ($resultat['idActionneur']==1) // donc c'est l'admin qui annulé l'event validé d'un club
                                            {
                                                ?>
                                               Votre &eacute;vènement pr&eacute;c&eacute;demment valid&eacute; intitul&eacute; <strong><?php echo $event['titre']; ?></strong> vient d'&ecirc;tre annul&eacute; par un administrateur.

                                                <?php

                                            }
                                            else // donc c'est le club qui a annulé son propre event validé
                                            {
                                                ?>
                                                L'&eacute;venèment qu'un administrateur a pr&eacute;c&eacute;demment valid&eacute; et intitul&eacute; <strong><?php echo $event['titre']; ?></strong> vient d'&ecirc;tre annul&eacute; par le club <strong><?php echo $actionneur['nom']; ?></strong>.
                                                <?php

                                            }

                                        }
                                        else
                                        {
                                            if ($resultat['action']==4) // notif d'annulation d'un event en attente
                                            {

                                                    ?>
                                                    La demande en attente de l'&eacute;vènement intitul&eacute; <strong><?php echo $event['titre']; ?></strong> vient d'&ecirc;tre annul&eacute;e par le club <strong><?php echo $actionneur['nom']; ?></strong>.
                                                    <?php



                                            }
                                            else
                                            {
                                                if ($resultat['action']==5) // notif de validation d'un event par l'admin
                                                {
                                                    ?>
                                                    La demande en attente de votre &eacute;vènement intitul&eacute; <strong><?php echo $event['titre']; ?></strong> vient d'&ecirc;tre valid&eacute;e par un administrateur.
                                                    <?php


                                                }
                                                else // notif de rejet d'un event par l'admin
                                                {

                                                    ?>
                                                    La demande en attente de votre &eacute;vènement intitul&eacute; <strong><?php echo $event['titre']; ?></strong> vient d'&ecirc;tre rejet&eacute;e par un administrateur.
                                                    <?php


                                                }

                                            }

                                        }

                                    }

                                }
                                    ?>
                               </p>
                                </div>
                             </a>
                             <?php

                            $resultat=$requete->fetch();
                        }
                        $req3=$bdd->prepare('UPDATE notifications SET vu=1 WHERE idConcerne=? AND vu=0');


                        if ($_SESSION['privilege']==0)
                        {
                            $req3->execute(array($_SESSION['id']));
                        }
                        else
                        {
                           $req3->execute(array(1));
                        }
                        ?>



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
                             echo '<li class="page-item active"><a href="notifications.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                        }
                        else
                        {
                            echo '<li class="page-item"><a href="notifications.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                          <a href="notifications.php?page=<?php echo $nb_pages; ?>" class="page-link" aria-label="Next">
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
                                     echo '<li class="page-item active"><a href="notifications.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="notifications.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                              <a class="page-link" href="notifications.php" aria-label="Previous">
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
                                     echo '<li class="page-item active"><a href="notifications.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="notifications.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                                     echo '<li class="page-item active"><a href="notifications.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="notifications.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                                          <a class="page-link" href="notifications.php" aria-label="Previous">
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
                                     echo '<li class="page-item active"><a href="notifications.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="notifications.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                                      <a href="notifications.php?page=<?php echo $nb_pages; ?>" class="page-link" aria-label="Next">
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
    

            </div>
        </div>
</div>

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