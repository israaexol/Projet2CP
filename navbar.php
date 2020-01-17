<?php
if (isset($_SESSION['nom'])) // condition nécessaire pour empêcher à l'accès direct au lien navbar.php
// car on fait l'appel à navbar.php via include 'navbar.php' dans la page interface.php. include permet d'insérer navbar.php dans n'endroit où l'instruction est appelée dans le fichier interface.php
// De ce fait, lorsqu'on essaye d'accéder directement à localhost/navbar.php, on a que $_SESSION['nom'] n'est pas définie donc son isset est à 0, car : On n'a pas fait de session_start() dans le fichier navbar.php et donc accéder directement au fichier navbar.php depuis l'URL ne lui permettra pas d'accéder à la variable $_SESSION. Alors que include navbar.php permet d'insérer navbar.php dans interface.php ,et dans interface.php on a initialisé la session avec session_start() donc la variable session est disponible et ses champs sont accessibles.
// De ce fait on protège cette page contre l'accès direct par la simple condition isset($_SESSION['nom']) et elle sera automatiquement à 0 si on accède directement depuis l'URL. Donc dans le 'else' de la condition on renvoie l'utilisateur vers interface.php
{
    $admin=NULL;
    require_once 'config.php';    ?>
<head>
    <style>
       #item{
           padding: 0 14px;
       }
       .button__badge {
           background-color: #fa3e3e;
           border-radius: 20px;
           color: white;
           font-size: medium;
           font-weight: bold;
           width: 15%;
           height: 50%;

           padding: 0px 12px 10px 8px ;
           font-size: 10px;

           position: absolute; /* Position the badge within the relatively positioned button */
           top: 0;
           right: 0;
       }
    </style>
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

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top navbar-transparent " color-on-scroll="100" style="<?php if ($_SESSION['privilege']==0){?>padding-left: 6%;<?php }else{?>padding-left: 1%;<?php }?>">
      <div class="container" style="justify-content: inherit;    max-width: 100%;display: contents">
      <div class="navbar-translate">
          <img src="./assets/img/logoAppSmall.png" />

          <a class="navbar-brand" href="interface.php" rel="tooltip" data-placement="bottom">
          <span>GRS•ESI</span>
        </a>
        <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse justify-content-end" id="navigation" style="display: block !important;margin-left: 1%">
        <div class="navbar-collapse-header">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a>
                GRS•ESI
              </a>
            </div>
            <div class="col-6 collapse-close text-right">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <i class="tim-icons icon-simple-remove"></i>
              </button>
            </div>
          </div>
        </div>
        <ul class="navbar-nav" style="font-size:larger ;font-weight: bold">
            <?php
            if ($_SESSION['privilege']==1) { // N'afficher ce menu que si l'utilisateur a un privilège à 1 (compte service)
            ?>
          <li class="dropdown nav-item" id="item" >
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <i class="tim-icons icon-chart-bar-32" ></i>Administration
            </a>
              <div class="dropdown-menu dropdown-with-icons">
                  <a href="gerer_reservations.php" class="dropdown-item">
                      <i class="tim-icons icon-single-copy-04"></i> Gérer les réservations
                  </a>
                  <a href="gerer_clubs.php" class="dropdown-item" >
                      <i class="fa fa-users fa-lg"></i>Gérer les profils
                  </a>
                  <a href="afficher_salles.php" class="dropdown-item" >
                      <i class="tim-icons icon-calendar-60"></i>Gérer le planning
                  </a>
                  <a href="gerer_vacances.php" class="dropdown-item" >
                      <i class="tim-icons icon-bus-front-12"></i>Gérer les vacances
                  </a>

              </div>
          </li><?php } ?>
          <li class="nav-item " id="item">
              <a href="reserver.php" class="nav-link">
                  <i class="tim-icons icon-pencil" ></i> Réserver
              </a>

          </li>
            <?php if ($_SESSION['privilege']==1) // De même
            { ?>
          <li class="nav-item " id="item">
              <a href="demandes_acceptees.php" class="nav-link">
                  <i class="tim-icons icon-paper"></i> Mes réservations
              </a>
          </li><?php } ?>
            <?php if ($_SESSION['privilege']==0) // N'afficher ce menu que si l'utilisateur a un privilege à 0 (compte club)
            { ?>
                <li class="dropdown nav-item" id="item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="tim-icons icon-paper"></i> Statut de mes réservations
                    </a>
                    <div class="dropdown-menu dropdown-with-icons">
                        <a href="demandes_acceptees.php" class="dropdown-item">
                            <i class="fa fa-circle" style="color: #009933"></i> Acceptées
                        </a>
                        <a href="demandes_rejetees.php" class="dropdown-item">
                            <i class="fa fa-circle" style="color: #e60000"></i>Rejetées
                        </a>
                        <a href="demandes_attente.php" class="dropdown-item">
                            <i class="fa fa-circle" style="color: #ff6600"></i>En attente
                        </a>
                    </div>
                </li>
            <?php } ?>
            <?php if ($_SESSION['privilege']==1) //
            { ?>
            <li class="dropdown nav-item" id="item">
                <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown" >
                    <i class="tim-icons icon-refresh-02"  ></i> Historique des évènements
                </a>
                <div class="dropdown-menu dropdown-with-icons">
                    <a href="historique_events.php"class="dropdown-item">
                        <i class="fa fa-history fa-lg" style="color:black"></i> Tous les évènements
                    </a>
                    <a href="events_annules.php" class="dropdown-item">
                        <i class="tim-icons icon-simple-remove" style="color: red"></i> Evènements annulés
                    </a>

                </div>
            </li><?php } ?>
            <?php if ($_SESSION['privilege']==0) //
            { ?>
                <li class="nav-item" id="item">
                    <a href="historique_events.php" class="nav-link" >
                        <i class="tim-icons icon-refresh-02"></i> Historique des évènements
                    </a>
                </li><?php } ?>
            <?php
            $requetee=$bdd->prepare('SELECT * FROM notifications WHERE idConcerne=? AND vu=0');
            if ($_SESSION['privilege']==0)
            {
                $requetee->execute(array($_SESSION['id']));
            }
            else
            {
                $requetee->execute(array(1)); // les admins ont des notifications communes, dès que l'un la visualise, elle est marquée lue pour tous les admins
            }
            $nombre_notifs=$requetee->rowCount(); // nombre de notifications non lues


            ?>
            <li class="nav-item" id="item">
                <?php
                if ($nombre_notifs!=0)
                {
                    ?>
                    <a href="notifications.php" class="nav-link" data-toggle="">
                        <i class="tim-icons icon-bell-55"></i><span class="button__badge"><?php echo $nombre_notifs; ?></span>
                    </a>
                    <?php
                }
                else
                {
                    ?>
                    <a href="notifications.php" class="nav-link" data-toggle="">
                        <i class="tim-icons icon-bell-55"></i>(0)
                    </a>
                    <?php

                }
                ?>

            </li>
            <li class="nav-item" id="item">
                <a href="mon_profil.php" class="nav-link">
                    <i class="tim-icons icon-single-02"></i> Mon profil
                </a>
            </li>
            <li class="nav-item" id="item">
                <a href="<?php if ($_SESSION['privilege']==1){?>./guide_admin<?php }else{?>./guide_club<?php } ?>" class="nav-link" rel="tooltip" title="Aide">
                    <i class="tim-icons icon-alert-circle-exc"></i>
                </a>
            </li>
          <li class="nav-item" id="item">
            <a class="nav-link btn btn-default d-none d-lg-block" href="deconnexion.php" onclick="scrollToDownload()">
                <i class="tim-icons icon-button-power"></i> Se déconnecter
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
<?php
}

if (!isset($_SESSION['nom'])) // On ouvre une nouvelle boucle car on dirait que PHP ne permet pas de mettre des else après avoir fermé puis réouvert une balise php , ça joue le rôle du else car c'est la négation de la première condition en haut
{
    header("Location: interface.php");
    exit;
}

?>
