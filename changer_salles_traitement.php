<?php
session_start();
include 'fonctions.php';

if (isset($_SESSION['privilege']) && isset($_GET['id']))
{
    $privilege=$_SESSION['privilege'];
    $event_id=$_GET['id'];
// mesure de sécurité pour empêcher les accès à cette page sans passer par changer_salles.php (pour empêcher l'accès non autorisé car toutes les vérifications se font sur changer_salles.php)
    if (!isset($_POST['verif_envoi']))
    {
        header("Location: interface.php");
        exit;
    }

    require_once 'config.php';
    $requete=$bdd->prepare('SELECT * FROM events WHERE id=?');
    $requete->execute(array($event_id));
    $res=$requete->fetch();
    $valide= $res['valide'];
    $requete2=$bdd->prepare('DELETE FROM salles_events WHERE id_event=?');
    $requete2->execute(array($event_id));
   
    

    if (isset($_POST['choix'])) 
    {
        $planning=choix_planning(strtotime($res['date']), $bdd);
     if ($planning==0)
    {
         $requete2=$bdd->prepare('SELECT * FROM planning_vacances WHERE id_ligne=?');  // Planning des weekends et de vacances
    }
    else
    {
        if ($planning==1)
        {
        $requete2=$bdd->prepare('SELECT * FROM planning_s1 WHERE id_ligne=?');  //Semestre 1

       }
      else
      {
        $requete2=$bdd->prepare('SELECT * FROM planning_s2 WHERE id_ligne=?');  
      } 
    }
         $requete3=$bdd->prepare('INSERT INTO salles_events (id_event, salle, creneau) VALUES (:id_event, :salle, :creneau)');
         foreach($_POST['choix'] as $seance)
         {
            $requete2->execute(array($seance)); // on récupère l'id_ligne choisi par l'utilisateur parmi tous ses choix ($seance)  depuis le planning (table 'salles')
            $requete2_res=$requete2->fetch();
            $requete3->execute(array(
                'id_event' =>$_GET['id'], // id de l'event concerné, transmis dans l'url
                'salle' =>$requete2_res['ID'],
                 'creneau' =>$requete2_res['Creneau']
                ));
         }
            
     }
         if ($privilege==0)
         {
            $requete4=$bdd->prepare('UPDATE events SET valide=0 WHERE id=?'); // on remet l'évenement en attente
            $requete4->execute(array($event_id));
            ajouter_notification($bdd, $event_id, 2, 1, $_SESSION['id']); // c'est le club qui a modifié des salles de sa demande en attente ou validée, donc l'admin doit être notifié
            mail_admin_changement_salles($event_id, $bdd); // on envoie un email à l'admin

         }
         else // privilège=1, donc l'admin modifie les salles de son event ou pas, si ce n'est pas son event on doit avertir le club ///////// edit après l'ajout de la multiadministration : si un admin modifie l'event d'un autre admin (même son propre event), on n'avertit personne
         {
            $reqq=$bdd->prepare('SELECT * FROM comptes WHERE id=?');
            $reqq->execute(array($res['club_id']));
            $ress=$reqq->fetch();
            if ($ress['privilege']!=1)
            //if ($_SESSION['id']!=$res['club_id']) // edit
            {
                ajouter_notification($bdd, $event_id, 2, $res['club_id'], 1); // c'est l'admin qui a modifié les salles d'un event d'un club
                mail_club_changement_salles($event_id,$bdd); // on envoie un email au club


            }


         }
         $redirection='Location: gerer_event.php?id='.$_GET['id'];      
         header($redirection);  
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
