
<?php 
session_start();

if (isset($_SESSION['privilege']))
{
  include 'fonctions.php';
   require_once 'config.php';

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <head><title>Demandes rejet&eacute;es</title>
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
  <?php include 'navbar.php';?>
  <div class="wrapper">
     <section class="section section-lg">
        <section class="section" style="margin-top: -50px;">
    <?php // j'ai effacé temporairement ce qu'il y'avait ici : les deux images du background, car elles rendaient les boutons incliquables ?>
        </section>
    </section>
    
      <div class="container" style="background:papayawhip;border-radius: 20px; background-color: rgba(149,208,219,0.15)  ;margin-top: -50px;">
        <center>
          <table class="table table-striped " style="width: 1250px;" >
              <thead>
                <tr>
                   <th style="font-size: 18px;color: white;"><center>Nom de l'évènement</center></th>
                   <th style="font-size: 18px;color: white;"><center>Date</center></th>
                   <th style="font-size: 18px;color: white;width:"><center>Club organisateur</center></th>
                   <th style="font-size: 18px;color: white;"><center>Status</center></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $bdd->query('SET NAMES UTF8');

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
                $requete=$bdd->prepare('SELECT * FROM events WHERE valide=2 AND club_id=? ORDER BY id DESC');
                $requete->execute(array($_SESSION['id']));
                $nb_results= $requete->rowCount();

               $requete=$bdd->prepare('SELECT * FROM events WHERE valide=2 AND club_id=? ORDER BY id DESC LIMIT '.$debut.','.$nb_par_page);
                $requete->execute(array($_SESSION['id']));

                 $nb_pages=floor($nb_results/$nb_par_page); // partie entière 
                if ($nb_results%$nb_par_page >0) $nb_pages++;

                
                $resultat=$requete->fetch();
                while ($resultat!=NULL)
                {
                     echo '<tr>';
                  echo '<td ><center><a class="btn btn-link" style="color: white;" href="gerer_event.php?id='.$resultat['id'].'">'.$resultat['titre'].'</a></center></td>';
                  echo '<td><center>'.$resultat['date'].'</center></td>';
                  $requete2=$bdd->prepare('SELECT * FROM comptes WHERE id=?');
                  $requete2->execute(array($resultat['club_id']));
                  $resultat2=$requete2->fetch();
                  $photo=$resultat2['photo'];
                          if ($photo==1)
                          {
                            echo '<td><center><img src="avatars/'.$_SESSION['id'].'min.png'.'" width="24px"/><a style="color:white;">&nbsp '.$resultat2['nom'].'</a></center></td>';

                          }
                          else
                          {
                             echo '<td><center><a style="color:white;">'.$resultat2['nom'].'</a></center></td>';

                          }
                   
                            echo '<td><span class="badge badge-danger">Rejet&eacute</span></td>';

                      

                    echo '</tr>';
                    $resultat=$requete->fetch();
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
                             echo '<li class="page-item active"><a href="demandes_rejetees.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                        }
                        else
                        {
                            echo '<li class="page-item"><a href="demandes_rejetees.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                          <a href="demandes_rejetees.php?page=<?php echo $nb_pages; ?>" class="page-link" aria-label="Next">
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
                                     echo '<li class="page-item active"><a href="demandes_rejetees.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="demandes_rejetees.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                              <a class="page-link" href="demandes_rejetees.php" aria-label="Previous">
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
                                     echo '<li class="page-item active"><a href="demandes_rejetees.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="demandes_rejetees.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                                     echo '<li class="page-item active"><a href="demandes_rejetees.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="demandes_rejetees.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                                          <a class="page-link" href="demandes_rejetees.php" aria-label="Previous">
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
                                     echo '<li class="page-item active"><a href="demandes_rejetees.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="demandes_rejetees.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                                      <a href="demandes_rejetees.php?page=<?php echo $nb_pages; ?>" class="page-link" aria-label="Next">
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
}
else
{
  $_SESSION['lien']=$_SERVER['REQUEST_URI'];
  header("Location: connexion.php");
  exit;
}
?>