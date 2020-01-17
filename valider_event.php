<?php
session_start();



if (isset($_SESSION['privilege']) && $_SESSION['privilege']==1)
{
	require_once 'config.php';
	include 'fonctions.php';
	if (!isset($_GET['id']))
	{
		header('Location: interface.php');
		exit;
	}
	$event_id=$_GET['id'];

	$requete= $bdd->prepare('SELECT * FROM events WHERE id=? AND valide=0 AND date>?');
	$requete->execute(array($event_id, date('Y-m-d')));
	$resultat=$requete->fetch();
	if ($resultat==NULL) // Donc on a tenté d'accéder à valider_event.php?id=event_id avec xx un identifiant d'un evenement non en attente , ou en attente et expiré, ou inexistant dans la base de données (contrôle de sécurité d'accès par URL)
	{
		header('Location: interface.php');
		exit;
	}

	// on vérifie que cet évenement à valider n'a pas de collision (pour empêcher tout accès à valider_event.php?id=event_id si l'event a subi une collision (contrôle de sécurité d'accès par URL)

	creation_tmp_collision($bdd);
	$req_collision=$bdd->prepare('SELECT * FROM tmp_collision WHERE event_attente=?');
    $req_collision->execute(array($event_id));
    $res_collision=$req_collision->fetch();
    if ($res_collision!=NULL)
    {
        $chemin='Location: gerer_event.php?id='.$event_id;
    	header($chemin);
    	exit;
    }

    $requete=$bdd->prepare('UPDATE events SET valide=1 WHERE id=?');
    $requete->execute(array($event_id));


    // on doit notifier le club que sa demande a été validée par l'admin
    ajouter_notification($bdd, $event_id, 5, $resultat['club_id'], 1);  
    mail_validation_rejet(1,$event_id,$bdd); // mail au club
    
    $chemin='Location: gerer_event.php?id='.$event_id;
    header($chemin);
    exit;

}
else
{
	if (!isset($_SESSION['privilege']))
    {
         $_SESSION['lien']=$_SERVER['REQUEST_URI'];
        header("Location: connexion.php");
        exit;
    }
        header('Location: interface.php');
		exit;

}
