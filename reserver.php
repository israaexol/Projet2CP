<?php 
session_start();
 include 'fonctions.php';
if (isset($_SESSION['nom'])==1)
{
	?>

<html>
<head><title>Reserver</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/reset.css" rel="stylesheet" />
    <link href="assets/css/style1.css" rel="stylesheet" />
    <link rel='stylesheet prefetch' href='./datepicker/bootstrap-datepicker3.standalone.css'>
    <link href="allstyle.css" rel="stylesheet"/>
    <!-- CSS Files -->
    <link href="./assets/css/blk-design-system.css?v=1.0.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="./assets/demo/demo.css" rel="stylesheet" />
    <link href="coche.css" rel="stylesheet"/>
    <link href="modal.css" rel="stylesheet"/>
    <style>
        /* width */
        ::-webkit-scrollbar {
            width: 20px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey;
            border-radius: 10px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(rgb(42, 47, 99), rgb(136, 220, 210));
            border-radius: 10px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(rgb(136, 220, 210), rgb(42, 47, 99));        }
    </style>


</head>
<body class="register-page" style="background-color: #2a2f63">
<?php include 'navbar.php';?>
            <div class="col-6 " style="top: 130px;left: 25%;">
                <div class="card " style="border-radius: 10px; background-color: rgba(149,208,219,0.15);width: 100%;height: 95%" >
                    <div class="card-body table-responsive" style="overflow-x: unset">

                        <form action="verif_reserver.php" method="post" autocomplete="off" class="fo">


                        <?php 
                        	if (!isset($_SESSION['temp_date']))
                        	{

                        	  $_SESSION['temp_titre']=NULL;
						    	          $_SESSION['temp_type']=NULL;
                            $_SESSION['temp_nb_participants']=NULL;
						    	          $_SESSION['temp_date']=NULL;
						    	          $_SESSION['temp_description']=NULL;
						    	          $_SESSION['temp_sponsor']=NULL;
                                         $_SESSION['temp_responsable']=NULL;
                            if (empty($_SESSION['procederaffichage']))
                            {
                              $_SESSION['date_afficher']=NULL;
                            }
                        	}

                        	?>
                            <br><center><a class="text-white" style="font-weight: normal;font-size: large">Fiche technique de l'évènement</a></center><br><br>
                        	<div class="form-group" style="height: 8%">
                                <input type="text" value = "<?php echo $_SESSION['temp_titre'] ;?>" placeholder="Titre de l'évènement*" style="font-size: medium" class="form-control" name="titre">
                            </div>
                            <div class="form-group" style="height: 8%">
                                <input type="text" value = "<?php echo $_SESSION['temp_type'] ;?>" placeholder="Type de l'évènement*" style="font-size: medium" class="form-control" name="type">
                            </div>

                           


                                        <div class="form-group" style="border: 1px solid #2b3553;border-radius: 0.4285rem;height: 6%">

                                                <div id="flight-datepicker" class="input-daterange input-group" style="margin-top: 0px;margin-bottom: 0px;">

                                                        <?php
                                                        $date_convertie=date("d/m/Y", strtotime($_SESSION['temp_date']));
                                                        ?>
                                                        <input type="text"  name="date"  value="<?php if (!empty($_SESSION['temp_date'])) echo $date_convertie;?>" placeholder="Date de l'évènement*" class="form-control " style="border-bottom: 0 none;border-top: 0 none;">


                                                </div>

                                                <script src='./datepicker/jquery.min.js'></script>
                                                                <script src='./datepicker/bootstrap-datepicker.min.js'></script>
                                                                <script src='./datepicker/jquery.dateFormat.js'></script>

                                                                <script src="assets/js/index.js"></script>


                                            </div><br>
                                             <div class="form-group" style="height: 8%">
                                <input type="text" value = "<?php echo $_SESSION['temp_nb_participants'] ;?>" placeholder="Nombre de participants*" style="font-size: medium" class="form-control" name="nb_participants">
                            </div>

                            <div class="form-group" style="height: 10%">
                             <textarea  class="form-control" rows="6" name="description"  placeholder="Description de l'évènement*" style="font-size: medium;border-radius: 0.4285rem; border: 1px solid #2b3553"><?php echo $_SESSION['temp_description'] ;?></textarea>
                         </div>

                        <?php if ($_SESSION['privilege']==0)
                        {
                            ?>
                          <div class="form-group"style="height: 8%;margin-top: 0%">
                                <input type="text" placeholder="Personne responsable*" value = "<?php echo $_SESSION['temp_responsable'] ;?>" style="font-size: medium" class="form-control" name="responsable">
                            </div>
				
		
                             <div class="form-group"style="height: 8%;margin-top: 0%">
                                <input type="text" placeholder="Sponsor" value = "<?php echo $_SESSION['temp_sponsor'] ;?>" style="font-size: medium" class="form-control" name="sponsor">
                            </div>
                            <?php
                        }
                        else
                        {
                            ?>
                
        
                             <div class="form-group"style="height: 8%;margin-top: 8%">
                                <input type="text" placeholder="Sponsor" value = "<?php echo $_SESSION['temp_sponsor'] ;?>" style="font-size: medium" class="form-control" name="sponsor">
                            </div>
                            <?php
                        }
                        ?>

                  <a class="text-white">Veuillez choisir les salles :</a>
                    <!-- Button trigger modal -->
                    <button class="btn btn-secondary" name="afficher" value="1">
                        Afficher les salles libres</button><br>

                    <!-- Modal -->
                    <div style="max-height: 50%;
    overflow-y: auto;
    overflow-x: hidden;border: 1px solid #2b3553;border-radius: 10px">
                  <?php if (!empty($_SESSION['procederaffichage']))
                            {

                            require_once 'config.php';
                            $bdd->query('SET NAMES UTF8');
                            $salles= $bdd->query('SELECT * FROM salles_id ORDER BY nom');
                            creation_tmp_occupe($_SESSION['date_afficher'],$bdd);
                            $resultat=$salles->fetch();

                            while ($resultat!=NULL)
                            {

                            ?>
                            <div class="accordion" id="accordionExample">
                                <div class="card" style="background-color: white;border-radius: 10px" >
                                    <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <?php echo '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne'.$resultat['id'].'" aria-expanded="true" aria-controls="collapseOne">';?>
                                                <?php echo $resultat['nom']; ?>                                            </button>
                                        </h2>
                                    </div>

                                    <?php echo '<div id="collapseOne'.$resultat['id'].'" class="collapse " aria-labelledby="headingOne" data-parent="#accordionExample"';?>
                                        <div class="card-body" id="wsh">
                                            <?php
                                            affich_creneaux_libres($resultat['nom'],$_SESSION['date_afficher'],$bdd);
                                            ?>                                        </div>
                                </div>
                            </div>
                                <?php
                                $resultat=$salles->fetch();
                            }}
                            ?>

                        </div><br>
                            <center><button type="button" class="btn btn-success" data-toggle="modal" data-target="#example">
                                    Envoyer la demande
                                </button></center>
                            <!-- Modal -->
                            <div class="modal fade" id="example" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p id="mssg">Veuillez confirmer l'envoie de la demande</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler
                                            </button>
                                            <button type="submit" name ="envoyer" value="2" class="btn btn-success">Confirmer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>




                                        </form>
                </div>
                </div>
            </div>

                 <?php
                if (!isset($_SESSION['erreur']) ) 
                {
                	$_SESSION['erreur']=NULL;
                }
                 if ($_SESSION['erreur']!=NULL)
                 {
                 	echo '<div class="alert alert-danger" role="alert" style="height: 9%; width: 60%; top: -85%;margin: auto;
"> 
  <center>'.$_SESSION['erreur'].'</center>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
                 	$_SESSION['erreur']=NULL;
                 } 

          
                if (!empty($_SESSION['verif_envoi']))                {
                   echo '<div class="alert alert-success" role="alert" style="height: 7%; width: 40%; top: -85%;margin: auto;
"> 
  <center>Demande de r&eacute;servation prise en compte.</center>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
                } ?>

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
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</body>
</html>

	<?php

								$_SESSION['temp_titre']=NULL;
						    	$_SESSION['temp_type']=NULL;
                                $_SESSION['temp_nb_participants']=NULL;
						    	$_SESSION['temp_date']=NULL;
						    	$_SESSION['temp_description']=NULL;
						    	$_SESSION['temp_sponsor']=NULL;
                                $_SESSION['temp_reponsable']=NULL;
                                $_SESSION['verif_envoi']=NULL;


    if (!empty($_SESSION['procederaffichage']))
                                {
                                    $_SESSION['procederaffichage']=NULL;
                                }
                             
}
else

{
	$_SESSION['lien']=$_SERVER['REQUEST_URI'];
    header("Location: connexion.php");
    exit;
}



?>