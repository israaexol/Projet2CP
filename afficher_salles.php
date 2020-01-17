<?php
session_start();

if (isset($_SESSION['privilege']))
{
  if ($_SESSION['privilege']!=1)
  {
    header("Location: interface.php");
    exit;
  }
       include 'navbar.php' ;
       require_once 'config.php'; ?>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <head><title>Planning des salles</title>
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

<body class="profile-page" style="background-color: #2a2f63;">
  <div class="wrapper">
    
      <div class="container" style="background:papayawhip;border-radius: 20px; background-color: rgba(149,208,219,0.15)  ;margin-top: 150px;">
        <center>

          <table class="table table-striped " style="width: 1250px;" >
              <thead>
                <tr>
                    <!-- Button trigger modal -->
                        <a class="hello" href="#" rel="tooltip" title="Ajouter une salle" data-placement="bottom">

                        <button type="button" class="btn btn-primary btn-icon btn-round" data-toggle="modal" data-target="#exampleModal">
                        <i style="font-weight: bold" class="tim-icons icon-simple-add"></i>
                        </button></a>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document" id="display">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle"><strong>Ajout d'une salle :</strong></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="ajouter_salle.php" method="POST">
                                        <div class="form-group">
                                            <input style="font-size: 15px;color: black" type="text" placeholder="Nom de la salle" class="form-control" name="salle" required>
                                        </div>
                                        <button style="background-position: left;" type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="submit" id="envoyer" class="btn btn-primary">Ajouter cette salle</button>

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
                            <div class="alert alert-success alert-with-icon">
                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>
                                <span>
                                    Salle ajoutée avec succès</span>
                            </div>
                            <?php

                        }
                        else
                        {
                            ?>
                            <div class="alert alert-danger alert-with-icon">
                                <?php echo $_SESSION['erreur']; ?>
                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>

                            </div>
                            <?php
                        }

                    }
                    $_SESSION['erreur']=NULL;

                    ?>
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
                $req=$bdd->prepare('SELECT * FROM salles_id ORDER BY nom');
                $req->execute();
                $nb_results= $req->rowCount();

                 $req=$bdd->prepare('SELECT * FROM salles_id ORDER BY nom LIMIT '.$debut.','.$nb_par_page);
                $req->execute();

                 $nb_pages=floor($nb_results/$nb_par_page); // partie entière 
                if ($nb_results%$nb_par_page >0) $nb_pages++;


                $res=$req->fetch();
                while ($res!=null)
                {
                  echo '<tr>';
                  echo '<td><strong>'.$res['nom'].'</strong></td>';
                    echo '<td><a class=" btn btn-twitter" href="gerer_planning.php?semestre=1&salle='.$res['id'].'"">Modifier le planning du S1</a></td>';
                  echo '<td><a class=" btn btn-primary" href="gerer_planning.php?semestre=2&salle='.$res['id'].'">Modifier le planning du S2</a></td>
                   <!-- Button trigger modal -->
                            <td><center><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal'.$res['id'].'">
                                    Supprimer la salle
                                    </button></center></td>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal'.$res['id'].'" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">';?>
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p id="mssg">Voulez-vous vraiment supprimer cette salle ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler
                                            </button>
                                        <?php echo '<a class=" btn btn-danger" href="supprimer_salle.php?salle='.$res['id'].'">OK</a>';?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                 <?php echo '</tr>';
                  $res=$req->fetch();
                }


                ?>
                      

              </tbody>
</table>

        </center>
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
                             echo '<li class="page-item active"><a href="afficher_salles.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                        }
                        else
                        {
                            echo '<li class="page-item"><a href="afficher_salles.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                          <a href="afficher_salles.php?page=<?php echo $nb_pages; ?>" class="page-link" aria-label="Next">
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
                                     echo '<li class="page-item active"><a href="afficher_salles.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="afficher_salles.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                              <a class="page-link" href="afficher_salles.php" aria-label="Previous">
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
                                     echo '<li class="page-item active"><a href="afficher_salles.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="afficher_salles.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                                     echo '<li class="page-item active"><a href="afficher_salles.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="afficher_salles.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                                          <a class="page-link" href="afficher_salles.php" aria-label="Previous">
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
                                     echo '<li class="page-item active"><a href="afficher_salles.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="afficher_salles.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                                      <a href="afficher_salles.php?page=<?php echo $nb_pages; ?>" class="page-link" aria-label="Next">
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