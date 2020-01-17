<?php
require_once 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function bouton_supprimer($id,$get)
{
  
echo '<td>
            <center>
                <button type="button" class="btn btn-info" data-toggle="modal"
                        data-target="#exampleModal'.$id.'0">Supprimer
                </button>
            </center>
        </td>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal'.$id.'0" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">';?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="mssg">Voulez-vous vraiment supprimer cet évènement ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Supprimer
                </button>
                <?php echo '<a class="btn btn-info" href="supprimer_historique.php?id=' . $id .$get. '">OK</a>'; ?>
            </div>
        </div>
    </div>
  </div>
  <?php
}
function bouton_valider($id)
{
  echo '<td>
            <center>
                <button type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#exampleModal' . $id. '3">Valider
                </button>
            </center>
        </td>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal' . $id . '3" tabindex="-1" role="dialog"
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
                        <p id="mssg">Voulez-vous confirmer la validation ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Annuler
                        </button>
                        <?php echo '<a class="btn btn-success" href="valider_event.php?id=' .$id . '">OK</a>'; ?>
                    </div>
                </div>
            </div>
            </div>
<?php
}



function bouton_rejeter($id)
{
   echo '<td>
            <center>
                <button type="button" class="btn btn-danger" data-toggle="modal"
                        data-target="#exampleModal' . $id. '4">Rejeter
                </button>
            </center>
        </td>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal' . $id . '4" tabindex="-1" role="dialog"
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
                        <p id="mssg">Voulez-vous vraiment rejeter cette demande ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Rejeter
                        </button>
                        <?php echo '<a class="btn btn-danger" href="rejeter_event.php?id=' . $id . '"">OK</a>'; ?>
                    </div>
                </div>
            </div>
            </div>
<?php
}
function bouton_annuler($id,$demande)
{

  echo '<td>
            <center>
                <button type="button" class="btn btn-info" data-toggle="modal"
                        data-target="#exampleModal'.$id.'1">Annuler
                </button>
            </center>
        </td>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal'.$id.'1" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">';?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                <?php echo '<a class="btn btn-info" href="annuler_'.$demande.'.php?id=' . $id . '"">OK</a>'; ?>
            </div>
        </div>
    </div>
  </div>
  <?php
}

function bouton_modifier_salles($id,$bdd)
{
  ?>
<td>
  <center>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $id ?>2">
        Modifier les salles
    </button>
  </center>
</td>

<!-- Modal -->
<?php echo '<div class="modal fade" id="exampleModal' . $id . '2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">    
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <div class="modal-body" id="wsh">'; ?>

  <?php

      $bdd->query('SET NAMES UTF8');
       $date_evt = $bdd->prepare('SELECT * FROM events WHERE id=?');
      $date_evt->execute(array( $id));
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
                                    action="changer_salles_traitement.php?id=<?php echo $id ?>"
                                    style="font-size: large">
                                  <input name="verif_envoi" type="hidden"
                                         value="1">
                                  <div class="panel-group" id="accordion">
                                    <?php
                                      $jours = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
                                      $creneaux = ['08:30 - 09:30', '09:30 - 10:30', '10:30 - 11:30', '11:30 - 12:30', '12:30 - 13:30', '13:30 - 14:30', '14:30 - 15:30', '15:30 - 16:30', '16:30 - 17:30'];
                                      $jour = date('w', strtotime($res_evt['date']));
                                      $salles = $bdd->query('SELECT * FROM salles_id ORDER BY nom');
                                      if ($valide==1)
                                      {
                                        $req3=$bdd->prepare('UPDATE events SET valide=0 WHERE id=?'); // on remet le champs validé à 0 (temporairement, juste pour l'affichage des salles)
                                        $req3->execute(array($res_evt['id']));
                                      }
                                      creation_tmp_occupe($res_evt['date'], $bdd);
                                      $result = $salles->fetch();
                                      while ($result != NULL) {
                                      ?>
                                        <div class="panel panel-default">
                                          <div class="panel-heading">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $result['nom'] ?>"><?php echo $result['nom']; ?></a>
                                            </h4>
                                          </div>
                                          <?php
                                            $req11 = $bdd->prepare('SELECT * FROM salles_events WHERE id_event=? AND salle=?'); //l'event est en attente car pour l'instant on ne permet le changement de salles qu'aux events en attente (pour les evenements validés, la solution (pas ici) serait de les remettre en attente pendant une fraction de seconde juste pour que leurs salles n'occupent plus effectivement le calendrier, et donc ils seront affichés dans le formulaire, dès que l'affichage se termine on les remet à valide=1)                               
                                            $req11->execute(array($id, $result['nom']));
                                            $res_req11 = $req11->fetch();
                                            $cpt = 0;
                                            while ($res_req11 != NULL) {
                                              $req12 = $bdd->prepare('SELECT * FROM tmp_occupe WHERE salle=? AND creneau =?');
                                              $req12->execute(array($result['nom'], $res_req11['creneau']));
                                              $res_req12 = $req12->fetch();
                                              if ($res_req12 == NULL) // donc la séance prise par la salle n'est pas occupée par un évenement validé
                                              { $cpt++;}
                                              $res_req11 = $req11->fetch();
                                            }
                                          ?>
                                          <div id="<?php echo $result['nom'] ?>" class="panel-collapse collapse <?php if ($cpt != 0) echo "show"; ?>">
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
                                                    $req21->execute(array($res['ID'], $res['Creneau'], $id));
                                                    $res_req21 = $req21->fetch();
                                                    $coche = 0;
                                                    if ($res_req21 != NULL) {
                                                      $coche = 1;
                                                    }
                                              ?>
                                              <label class="customcheck" style="color: black"><?php echo $res['Jour'] . " " . "Séance " . $res['Creneau'] . " (" . $creneaux[$res['Creneau'] - 1] . ")"; ?>
                                                <input type="checkbox" name="choix[]" value="<?php echo $res['id_ligne']; ?>" <?php if ($coche == 1) echo "checked"; ?>>
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
                                    <?php $result = $salles->fetch();
                                    }?>
                                  </div>
                                  <div class="form-group">
                                    <button type="submit" name="envoyer" value="2" class="btn btn-primary"> Modifier les salles</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Annuler </button>
                                  </div>
                                </form>
                                <?php
                                if ($valide==1)
                                {
                                  $req3=$bdd->prepare('UPDATE events SET valide=1 WHERE id=?'); // on remet le champs validé à 1 (temporairement, juste pour l'affichage des salles)
                                  $req3->execute(array($res_evt['id']));
                                }
                                ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>
                    </div>
                  </div>


  <?php
}

function creation_tmp_occupe($date,$bdd)//cree la table des creneaux occupes par des evenements a une date donnee
{
  

  $events= $bdd->prepare('SELECT * FROM events INNER JOIN salles_events WHERE events.id=salles_events.id_event AND events.date=? AND events.valide=1'); // on récupère les évenements validés à la même date
  $events->execute(array($date));
  $res2=$bdd->query('DROP TABLE IF EXISTS tmp_occupe'); // supprimer la table temporaire si existante
    $res3=$bdd->query('CREATE TABLE tmp_occupe (salle VARCHAR(255), creneau INT)');
    $events_resultat=$events->fetch();
  $insertion_tmp=$bdd->prepare('INSERT INTO tmp_occupe (salle, creneau) VALUES (:salle, :creneau)');
  while ($events_resultat!=NULL)
  {
  $insertion_tmp->execute(array(
  'salle'=> $events_resultat['salle'],
  'creneau'=>$events_resultat['creneau']
  ));
//
  $events_resultat=$events->fetch();
  }
}


  function choix_semestre($date, $debut_s1, $debut_s2) // Vérifie si la date "$date" est dans le S1 oi le S2, lorsque la date de début du premier semestre est $debut_s1 et la date début du deuxième semestre est $debut_s2 (mettre en paramètres deux dates avec l'année 2020 qui sera une année temporaire de comparaison)
  {  
    $debut1=strtotime($debut_s1); // 
    $debut2=strtotime($debut_s2);
    //$fin1=strtotime('-1 day' , $debut2);
    //$fin_s2=strtotime (‘-1 day’ , $debut_s1);
    $new_date = strtotime(date('2020-m-d',$date));  // nouvelle date avec 2020 en année
   // echo $new_date.' ';
    //echo date('2020-m-d',$date).' ';
   // echo $debut1.' ';
   // echo $debut2.' ';
    if (($new_date>=$debut1)||($new_date<$debut2))
    {
     // echo 'blablacar';
      return 1; // s1;

    }
    else
    {
      //echo 'blablacar2';
      return 2; //s2dd
    }

  }

  function dans_vacances($date, $bdd)
  {
     $vacances=$bdd->prepare('SELECT * from dates_vacances WHERE debut<=? AND fin>=?');
     $vacances->execute(array(date('Y-m-d',$date), date('Y-m-d',$date)));
     $resultat=$vacances->fetch();
     if ($resultat!=NULL) 
     {
      return 1;
     }
     else
     {
      return 0;
     }
  }

 function choix_planning($date, $bdd)
{
  global $debut_s1;
  global $debut_s2;
  $jour = date('w', $date); 

   if (($jour>4)||(dans_vacances($date, $bdd)))
   {
     return 0; //weekend ou vacances (weekend dans ce cas)
   }
   else
   {
    $deb1='2020-'.$debut_s1;
    $deb2='2020-'.$debut_s2;
      if ((choix_semestre($date, $deb1, $deb2))==1)
      {
        return 1; // Semestre 1
      }
      else
      {
        return 2; // Semestre 2
      }
   }
}



function affich_creneaux_libres($salle,$date,$bdd)
{
$jours = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
  $jour = $jours[date('w', strtotime($date))];
  $creneaux = ['08:30 - 09:30', '09:30 - 10:30', '10:30 - 11:30', '11:30 - 12:30', '12:30 - 13:30', '13:30 - 14:30', '14:30 - 15:30', '15:30 - 16:30', '16:30 - 17:30'];
  $planning=choix_planning(strtotime($date), $bdd);
  //echo $planning;
  if ($planning==0)
  {
    $requete=$bdd->prepare('SELECT * FROM planning_vacances WHERE Jour=? AND ID=?');  // Planning des weekends et de vacances
  }
  else
  {
    if ($planning==1)
    {
      $requete=$bdd->prepare('SELECT * FROM planning_s1 WHERE Jour=? AND ID=?');  //Semestre 1

    }
    else
    {
      $requete=$bdd->prepare('SELECT * FROM planning_s2 WHERE Jour=? AND ID=?');  
    }
  } 
  $requete->execute(array($jour, $salle));
  $res=$requete->fetch();
  while ($res!=NULL)
  {
    //pour chaque crenaux on verifie s'il est occupé par un evenement ou pas                                           //il suffit de verifier si la ligne existe dans la table tmp_occupé
    $recherche_dans_tmp_occupe=$bdd->prepare('SELECT * FROM tmp_occupe WHERE salle=? AND creneau=?');
    $recherche_dans_tmp_occupe->execute(array($res['ID'], $res['Creneau']));
    $resultat_recherche=$recherche_dans_tmp_occupe->fetch();
    if ($resultat_recherche==NULL)//si le creneau n'existe pas donc il est libre donc on l'affiche
      {?>
        
     <label class="customcheck" style="color: black"><?php echo " "."Séance ".$res['Creneau']." (".$creneaux[$res['Creneau']-1].")"; ?>
    <input type="checkbox" name="choix[]" value="<?php echo $res['id_ligne']; ?>">
    <span class="checkmark"></span>
    </label>
    <?php
    } // fin du if ($resultat_recherche!=NULL), donc on n'a trouvé aucune occurence dans la table des salles occupées pour la séance qui est dans $res, et celà pour la date donnée et pour tous les évenements validés seulement. (on ne s'intéressera pas à l'occupation des salles par les évenements non validés du faits que les salles resteront toujours disponibles tant que l'évenement n'est pas validé)
    $res=$requete->fetch() ;
  } 
}

function email($to, $subject, $mess)
{
  global $en_ligne;
   if ($en_ligne==1) 
   {
      require_once 'phpmailer/src/Exception.php';
      require_once 'phpmailer/src/PHPMailer.php';
      require_once 'phpmailer/src/SMTP.php';

      $mail = new PHPMailer(TRUE);


     $mail->setFrom('service@reservations-esi.com', 'Reservations ESI');
     $mail->addAddress($to); // test, à remplacer par $to à la fin
     $mail->Subject = $subject;
     $mail->IsHTML(true); 
     $mail->Body = $mess;

     // signature de l'email (pour qu'il n'arrive pas les spams), ne pas supprimer le dossier clemail
     $mail->DKIM_domain = 'reservations-esi.com';
     $mail->DKIM_private = 'clemail/privatekey.txt';
     $mail->DKIM_selector = '1553210497.esi';
     $mail->DKIM_passphrase = '';
     $mail->DKIM_identity = $mail->From;

     $mail->send();
   }

    

}

function mail_validation_rejet($val, $id_event,$bdd)
{
  $req1=$bdd->prepare('SELECT club_id, titre, date FROM events WHERE id=?');
  $req1->execute(array($id_event));
  $res1=$req1->fetch();
  $id_club=$res1['club_id'];
  $req2=$bdd->prepare('SELECT  nom, email From comptes WHERE id=?');
  $req2->execute(array($id_club));
  $res2=$req2->fetch();
  $mail=$res2['email'];
  if($val==1)
  {
    
    $subject="Validation de la demande de reservation";
    
    $message = '
    <html>
    <head>
      <title>Validation</title>
    </head>
    <body>
      <p>Bonjour <strong>'.$res2['nom'].'</strong>, le service culturel de l\'ESI a l\'honneur de vous annoncer que votre demande de r&eacute;servation de salles pour l\'&eacute;v&eacute;nement <strong>'.$res1['titre'].'</strong> du <strong>'.$res1['date'].'</strong> a &eacute;t&eacute; valid&eacute;e. 
          </p>
          <p>
     Vous pouvez acceder a l\'&eacute;v&eacute;nement via <a href="www.reservations-esi.com/gerer_event.php?id='.$id_event.'">ce lien</a></p>
    </body>
    </html>';
  }
  else
  {
   
    $subject="Rejet de demande de reservation";
    $message = '
    <html>
    <head>
      <title>Rejet</title>
    </head>
    <body>
      <p>Bonjour <strong>'.$res2['nom'].'</strong>, le service culturel de l\'ESI a le regret de vous annoncer que votre demande de reservation de salles pour l\'&eacute;v&eacute;nement <strong>'.$res1['titre'].'</strong> du <strong>'.$res1['date'].'</strong> a &eacute;t&eacute; rejet&eacute;e. 
       </p>
       <p>
       Vous pouvez acceder a l\'&eacute;v&eacute;nement via <a href="www.reservations-esi.com/gerer_event.php?id='.$id_event.'">ce lien</a></p>
    </body>
    </html>';


  }
  
  $mail=$res2['email'];
  email($mail,$subject,$message);

}
//enoyer un mail au club pour l'informer que l'admin a changé les salles
function mail_club_changement_salles($id_event,$bdd)
{
  $req1=$bdd->prepare('SELECT club_id, titre, date FROM events WHERE id=?');
  $req1->execute(array($id_event));
  $res1=$req1->fetch();
  $id_club=$res1['club_id'];
  $req2=$bdd->prepare('SELECT  nom, email From comptes WHERE id=?');
  $req2->execute(array($id_club));
  $res2=$req2->fetch();
  $subject="changement de salles";
  $message = '
    <html>
    <head>
      <title>Changement de salles</title>
    </head>
    <body>
      <p>Bonjour <strong>'.$res2['nom'].'</strong>, le service culturel de l\'ESI a effectu&eacute; des changements dans les salles de votre evenement <strong>'.$res1['titre'].'</strong> </p>
      <p>Vous pouvez acceder à l\'evenement via  <a href="www.reservations-esi.com/gerer_event.php?id='.$id_event.'"> ce lien </a></p>
    </body>
    </html>';
  $mail=$res2['email']; 
  email($mail,$subject,$message);
}

function mail_admin_changement_salles($id_event,$bdd)
{
  $req1=$bdd->prepare('SELECT club_id, titre, date FROM events WHERE id=?');
  $req1->execute(array($id_event));
  $res1=$req1->fetch();
  $id_club=$res1['club_id'];
  $req2=$bdd->prepare('SELECT  nom From comptes WHERE id=?');
  $req2->execute(array($id_club));
  $res2=$req2->fetch();
  $req3=$bdd->prepare('SELECT email FROM comptes WHERE privilege=?');
  $req3->execute(array(1));
  $res3=$req3->fetch();
  $message = '
    <html>
    <head>
      <title>Nouvelle demande de reservation</title>
    </head>
    <body>
      <p>Bonjour, Le compte <strong>'.$res2['nom'].'</strong> a effectu&eacute; un changement dans la liste des salles de sa demande de reservation pour l\'evenement <strong>'.$res1['titre'].'</strong> du <strong>'.$res1['date'].'</strong>. Veuillez donc consulter votre compte pour verrifier les changement et valider ou rejeter sa demande .  
          </p>
          <p>
     Vous pouvez acceder a l\'evenement via <a href="www.reservations-esi.com/gerer_event.php?id='.$id_event.'"> ce lien </a></p>
    </body>
    </html>';
  $subject="Changement de salles";

  while ($res3!=NULL) 
  {
    $mail=$res3['email'];
    email($mail,$subject,$message);
    $res3=$req3->fetch();

  }
}

function mail_demande_reservation($id_event,$bdd)
{
  $req1=$bdd->prepare('SELECT * FROM events WHERE id=?');
  $req1->execute(array($id_event));
  $res1=$req1->fetch();
  $id_club=$res1['club_id'];
  $req2=$bdd->prepare('SELECT  nom From comptes WHERE id=?');
  $req2->execute(array($id_club));
  $res2=$req2->fetch();
  $req3=$bdd->prepare('SELECT email FROM comptes WHERE privilege=?');
  $req3->execute(array(1));
  $res3=$req3->fetch();
  $message = '
    <html>
    <head>
      <title>Nouvelle demande de reservation</title>
    </head>
    <body>
      <p>Bonjour, Le compte <strong>'.$res2['nom'].'</strong> a fait une demande de reservation pour un evenement qui a pour titre <strong>'.$res1['titre'].'</strong> et qui se deroulera le <strong>'.$res1['date'].'</strong>. Veuillez donc consulter votre compte pour valider ou rejeter cette demande.  
          </p>
          <p>
     Vous pouvez acceder a l\'evenement via <a href="www.reservations-esi.com/gerer_event.php?id='.$id_event.'"> ce lien </a></p>
    </body>
    </html>';
  $subject="Nouvelle demande de reservation";

  while ($res3!=NULL) 
  {
    $mail=$res3['email'];
    email($mail,$subject,$message);
    $res3=$req3->fetch();

  }
}

function mail_avertir_club_collision($id_event,$bdd)
{
  $req1=$bdd->prepare('SELECT club_id, titre, date FROM events WHERE id=?');
  $req1->execute(array($id_event));
  $res1=$req1->fetch();
  $id_club=$res1['club_id'];
  $req2=$bdd->prepare('SELECT  nom, email From comptes WHERE id=?');
  $req2->execute(array($id_club));
  $res2=$req2->fetch();
  //$mail=$res2['email'];
  $message = '
    <html>
    <head>
      <title>Avertissement de collision</title>
    </head>
    <body>
      <p>Bonjour <strong>'.$res2['nom'].'</strong>, le service culturel de l\'ESI vous informe qu\'il y a une collision sur des salles que vous avez reserv&eacute;es pour l\'&eacute;venement <strong>'.$res1['titre'].'</strong> du <strong>'.$res1['date'].'</strong>. Veuillez donc changer les salles de votre &eacute;v&eacute;nement qui posent problème. 
          </p>
          <p>
     Vous pouvez acceder a l\'&eacute;v&eacute;nement via <a href="www.reservations-esi.com/gerer_event.php?id='.$id_event.'">ce lien</a></p>
    </body>
    </html>';
  $subject="Avertissement de collision";
  $mail=$res2['email'];
  email($mail, $subject, $message);


}
function mail_admin_annulation($id_event,$bdd)
{
  $req1=$bdd->prepare('SELECT * FROM events WHERE id=?');
  $req1->execute(array($id_event));
  $res1=$req1->fetch();
  $id_club=$res1['club_id'];
  $req2=$bdd->prepare('SELECT  nom From comptes WHERE id=?');
  $req2->execute(array($id_club));
  $res2=$req2->fetch();
  $req3=$bdd->prepare('SELECT email FROM comptes WHERE privilege=?');
  $req3->execute(array(1));
  $res3=$req3->fetch();
  $message = '
    <html>
    <head>
      <title>Annulation d\'une demande de reservation</title>
    </head>
    <body>
      <p>Bonjour, Le compte <strong>'.$res2['nom'].'</strong> à annul&eacute; sa demande de reservation pour l\'evenement qui a pour titre <strong>'.$res1['titre'].'</strong> du <strong>'.$res1['date'].'</p>
    </body>
    </html>';
  $subject="Annulation d'une demande de reservation";

  while ($res3!=NULL) 
  {
    $mail=$res3['email'];
    email($mail,$subject,$message);
    $res3=$req3->fetch();

  }
}

function mail_club_annulation($id_event, $bdd)
{
  $req1=$bdd->prepare('SELECT club_id, titre, date FROM events WHERE id=?');
  $req1->execute(array($id_event));
  $res1=$req1->fetch();
  $id_club=$res1['club_id'];
  $req2=$bdd->prepare('SELECT  nom, email From comptes WHERE id=?');
  $req2->execute(array($id_club));
  $res2=$req2->fetch();
  //$mail=$res2['email'];
  $message = '
    <html>
    <head>
      <title>Annulation de votre evenement</title>
    </head>
    <body>
      <p>Bonjour <strong>'.$res2['nom'].'</strong>, le service culturel de l\'ESI vous informe qu\'il a annul&eacute; votre &eacute;venement <strong>'.$res1['titre'].'</strong> du <strong>'.$res1['date'].'</strong>. 
          </p>
          
    </body>
    </html>';
  $subject="Annulation de votre evenement";
  $mail=$res2['email'];
  email($mail, $subject, $message);
}

function blablacar()
{
  return(1);
}


function creation_tmp_collision($bdd)
{
    $requete=$bdd->prepare('SELECT a.id, b.id, c.salle, c.creneau FROM events as a, events as b, salles_events as c, salles_events as d WHERE a.valide=0 AND b.valide=1 AND a.date=b.date AND a.id=c.id_event AND b.id=d.id_event AND c.creneau=d.creneau AND c.salle=d.salle'); 
    $requete->execute(array());


    $res2=$bdd->query('DROP TABLE IF EXISTS tmp_collision'); // supprimer la table temporaire si existante
    $res3=$bdd->query('CREATE TABLE tmp_collision (event_attente INT, event_valide INT, salle VARCHAR(255), creneau INT)');

    $resultat=$requete->fetch();
  $insertion_tmp=$bdd->prepare('INSERT INTO tmp_collision (event_attente, event_valide, salle, creneau) VALUES (:event_attente, :event_valide, :salle, :creneau)');
  while ($resultat!=NULL)
  {
  $insertion_tmp->execute(array(
  'event_attente'=> $resultat[0],
  'event_valide'=> $resultat[1],
  'salle'=> $resultat[2],
  'creneau'=>$resultat[3]
  ));
$resultat=$requete->fetch();

}
}


function ajouter_notification($bdd, $id_event, $action, $idConcerne, $idActionneur) 
{
  $requete=$bdd->prepare('INSERT INTO notifications (id_event, action, idConcerne, idActionneur, dateHeureNotif, vu) VALUES (:id_event, :action, :idConcerne, :idActionneur, :dateHeureNotif, :vu)');


  $requete->execute(array(
  'id_event'=> $id_event,
  'action'=> $action,
  'idConcerne' => $idConcerne,
  'idActionneur'=>  $idActionneur,
  'dateHeureNotif'=> date('Y-m-d H:i:s'),
  'vu' => 0

  ));



}
?>