<?php
session_start();

if (isset($_SESSION['privilege']) && $_SESSION['privilege'] == 1) {

    require_once 'config.php'; ?>


    <html lang="en">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <head><title>Gestion des vacances</title>
            <!--     Fonts and icons     -->
            <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet"/>
            <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
            <!-- Nucleo Icons -->
            <link href="./assets/css/nucleo-icons.css" rel="stylesheet"/>
            <!-- CSS Files -->
            <link href="assets/css/style1.css" rel="stylesheet" />
            <link href="assets/css/style2.css" rel="stylesheet" />
              <link rel='stylesheet prefetch' href='./datepicker/bootstrap-datepicker3.standalone.css'>
            <link href="./assets/css/blk-design-system.css?v=1.0.0" rel="stylesheet"/>
            <!-- CSS Just for demo purpose, don't include it in your project -->
            <link href="./assets/demo/demo.css" rel="stylesheet"/>
            <link href="modal.css" rel="stylesheet"/>
        </head>

    <body class="profile-page" style="background-color: #2a2f63;">
    <?php include 'navbar.php'; ?>
    <div class="container"
         style="background:papayawhip;border-radius: 20px; background-color: rgba(149,208,219,0.15)  ;margin-top: 150px;width: 1050px;">
        <center>
            <?php
                                    if (!empty($_SESSION['erreur'])) {
                                        if (($_SESSION['erreur']) == 'ok') {
                                            ?>
                                            <div class="alert alert-success alert-with-icon" id="delete">
                                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </button>
                                                <span data-notify="icon" class="tim-icons icon-bell-55"></span>
                                                <p>Vacances ajoutées avec succès.</p>
                                            </div>
                                            <?php

                                        } else {
                                            ?>
                                            <div class="alert alert-danger alert-with-icon" id="delete">
                                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert"
                                                        aria-label="Close" style="right: 1%;">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </button>
                                                <span id="error1"><?php echo $_SESSION['erreur']; ?></span>
                                            </div>
                                            <?php
                                        }

                                    }
                                    $_SESSION['erreur'] = NULL;

                                    ?>
            <table class="table table-striped " style="width: 1000px;">
                <thead>
                <tr>
                    <th style="font-size: 18px;color: white;">
                        <center>Nom des vacances</center>
                    </th>
                    <th style="font-size: 18px;color: white;">
                        <center>Date de début</center>
                    </th>
                    <th style="font-size: 18px;color: white;">
                        <center>Date de fin</center>
                    </th>
                    <th id="btn">
                        <!-- Button trigger modal -->
                        <a href="#" rel="tooltip" title="Ajouter une période de vacances"
                           data-placement="bottom">
                            <button type="button" class="btn btn-primary btn-icon btn-round" data-toggle="modal"
                                    data-target="#exampleModalCenter">
                                <i style="font-weight: bold" class="tim-icons icon-simple-add"></i>
                            </button>
                        </a>
                    </th>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document" id="deleteForm" ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle"><strong>Ajout d'une période de
                                            vacances :</strong></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="ajouter_vacances.php" method="POST">
                                        <div class="row" style="margin-left: 5%;">
                                             
                                                    <div class="form-group">
                                                                        <div id="flight-datepicker" class="input-daterange input-group" style="margin-top: 0px;margin-bottom: 0px;">

                                                                        <?php
                                                                        ?>
                                                                        <input type="text"  style="color: black;"  name="debut" placeholder="debut des vacances" class="form-control " style="border-bottom: 0 none;border-top: 0 none;" required>


                                                                </div>

                                                              

                                                    </div>
                                              
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                              
                                                    <div class="form-group">
                                                        <div id="flight-datepicker2" class="input-daterange input-group" style="margin-top: 0px;margin-bottom: 0px;">

                                                                        <?php
                                                                        ?>
                                                                        <input type="text" style="color: black;"  name="fin" placeholder="fin des vacances" class="form-control " style="border-bottom: 0 none;border-top: 0 none;" required>


                                                                </div>
                                                    </div>

                                                      <script src='./datepicker/jquery.min.js'></script>
                                                                <script src='./datepicker/bootstrap-datepicker.min.js'></script>
                                                                <script src='./datepicker/jquery.dateFormat.js'></script>

                                                                <script src="assets/js/index.js"></script>
                                                                 <script src="assets/js/index2.js"></script>
                                                
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <input type="text" style="color: black; font-size: 15px;"
                                                   placeholder="Nom des vacances" class="form-control"
                                                   name="description" required>
                                        </div>
                                        <center>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <button type="submit" id="envoyer" class="btn btn-primary">Ajouter</button>

                                        </center>

                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
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
                  $requete = $bdd->prepare('SELECT * FROM dates_vacances ORDER BY debut DESC');
                $requete->execute();
                $nb_results= $requete->rowCount();

                $requete = $bdd->prepare('SELECT * FROM dates_vacances ORDER BY debut DESC LIMIT '.$debut.','.$nb_par_page);
                $requete->execute(array());


                 $nb_pages=floor($nb_results/$nb_par_page); // partie entière 

                if ($nb_results%$nb_par_page >0) $nb_pages++;
              

                $resultat = $requete->fetch();
                
                while ($resultat != NULL) {
                    echo '<tr>';
                    echo '<td><center><a class="text-white"> ' . $resultat['description'].'</a></center></td>';
                    echo '<td><center><a class="text-white"> ' . date('d-m-Y', strtotime($resultat['debut'])) . '</a></center></td>';
                    echo '<td><center><a class="text-white"> ' . date('d-m-Y', strtotime($resultat['fin'])) . '</a></center></td>';
                    echo '<td><center><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal'.$resultat['id'].'">
                                    Supprimer
                                    </button></center></td>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal'.$resultat['id'].'" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">';?>
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p id="mssg">Voulez-vous vraiment supprimer cette période de vacances ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler
                                            </button>
                                        <?php echo '<a class="btn btn-danger" href="supprimer_vacances_traitement.php?id=' . $resultat['id'] . '">OK</a>';?>
                                        </div>
                                    </div>
                                </div>

                    <?php echo '</div></tr>';
                    $resultat = $requete->fetch();
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
                             echo '<li class="page-item active"><a href="gerer_vacances.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                        }
                        else
                        {
                            echo '<li class="page-item"><a href="gerer_vacances.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                          <a href="gerer_vacances.php?page=<?php echo $nb_pages; ?>" class="page-link" aria-label="Next">
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
                                     echo '<li class="page-item active"><a href="gerer_vacances.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="gerer_vacances.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                              <a class="page-link" href="gerer_vacances.php" aria-label="Previous">
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
                                     echo '<li class="page-item active"><a href="gerer_vacances.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="gerer_vacances.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                                     echo '<li class="page-item active"><a href="gerer_vacances.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="gerer_vacances.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                                          <a class="page-link" href="gerer_vacances.php" aria-label="Previous">
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
                                     echo '<li class="page-item active"><a href="gerer_vacances.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
                                }
                                else
                                {
                                    echo '<li class="page-item"><a href="gerer_vacances.php?page='.$cpt.'" class="page-link">'.$cpt.'</a></li>';
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
                                      <a href="gerer_vacances.php?page=<?php echo $nb_pages; ?>" class="page-link" aria-label="Next">
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
    <script>
        $(document).ready(function () {
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