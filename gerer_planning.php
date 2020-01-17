
<?php
session_start();

if (isset($_SESSION['privilege']) && $_SESSION['privilege']==1)
{
   if ((!isset($_GET['semestre']))||(!isset($_GET['salle'])))
   {
       header('Location: interface.php');
       exit;
   }
   $semestre=$_GET['semestre'];
   $id_salle=$_GET['salle'];
   if (($semestre <1) || ($semestre>2))
   {
      header('Location: interface.php');
      exit;
   }

   require_once 'config.php';
   $req1=$bdd->prepare('SELECT * from salles_id WHERE id=?');
   $req1->execute(array($id_salle));
   $salle=$req1->fetch();
   if ($salle==NULL)
   {
       header('Location: interface.php');
       exit;
   }


    ?>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <head><title>Gestion du planning</title>
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
      <div class="container" style="background:papayawhip;border-radius: 20px; background-color: rgba(149,208,219,0.15)  ;margin-top: 150px;">
        <center>

          <form method="POST" action="gerer_planning_traitement.php">
            <input type="hidden" name="semestre" value="<?php echo $semestre; ?>"> 
            <input type="hidden" name="salle" value="<?php echo $_GET['salle']; ?>"> 

          <center><p style="font-size:20px;padding-top: 13px;font-weight: bold;">Modification du planning du <strong>semestre</strong> <?php echo $_GET['semestre']; ?> de la salle : <strong><?php echo $salle['nom']; ?></strong><br></p></center>
        <br>
          <?php 
           $jours = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
           $creneaux = ['08:30 - 09:30', '09:30 - 10:30', '10:30 - 11:30', '11:30 - 12:30', '12:30 - 13:30', '13:30 - 14:30', '14:30 - 15:30', '15:30 - 16:30', '16:30 - 17:30'];
           ?>
           <table class="table table-bordered">
            <thead>
              <tr>
                <td><a class="text-white" style="font-weight: bold;">Séance\Jour</a></td>
                  <td><a style="color:white;font-weight: bold">Dimanche&nbsp;&nbsp;</a></td>
                  <td><a style="color:white;font-weight: bold;">Lundi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
                  <td><a style="color:white;font-weight: bold;">Mardi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
                  <td><a style="color:white;font-weight: bold;">Mercredi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
                  <td><a style="color:white;font-weight: bold;">Jeudi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
              </tr>
            </thead>
            <tbody>
              <?php
              $seance=1;
              while ($seance<=9)
              {
                ?>
                  <tr>
                  <th scope="row" style="color:white;"><?php echo $creneaux[$seance-1]; ?></th>
                  <?php
                  $jour=0;
                  while ($jour<5)
                  {
                    ?>
                    <td>
                        <?php 

                         if ($semestre ==1) 
                        {
                          $req=$bdd->prepare('SELECT * FROM planning_s1 WHERE ID=? AND Jour=? AND Creneau=?');
                        }
                        else
                        {
                          $req=$bdd->prepare('SELECT * FROM planning_s2 WHERE ID=? AND Jour=? AND Creneau=?');
                        }
                        $req->execute(array($salle['nom'], $jours[$jour], $seance)); // Soit il y'a un seul résultat soit 0, donc on coche ou pas la case (une case cochée est une case définie comme libre du planning, les clubs pourront réserver)
                        $res=$req->fetch();
                        ?>
                        <div class="form-check" >
                        <label class="form-check-label" >
                            <input type="checkbox" class="form-check-input" name="choix[]" style="width:30px;height:30px" value="<?php echo $jour.' '.$seance; ?>" <?php if ($res!=NULL) echo "checked";?>>
                        <span class="form-check-sign" style="width:200%;"></span>
                        </label>
                      </div>





                    </td>
                    <?php
                    $jour++;

                  }
                  ?>
                </tr>
                <?php
                $seance++;


              }
              ?>
              
             
            </tbody>
          </table>
           <center><button type="submit" id="envoi" class="btn btn-secondary">Modifier le planning</button></center>
          </form>

        </center>
      

      </div></div>
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
  
if (!isset($_SESSION['privilege']))
    {
         $_SESSION['lien']=$_SERVER['REQUEST_URI'];
        header("Location: connexion.php");
        exit;
    }
    header("Location: interface.php");
    exit;
}
?>
?>