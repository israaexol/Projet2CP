
<?php
// page qui sert à l'administrateur d'annuler les events "validés" des autres seulement (les clubs)! , les demandes en attente ne sont pas annulables par l'admin, mais sont rejetables.
session_start();
include 'fonctions.php';

if (isset($_SESSION['privilege']) && $_SESSION['privilege']==1)
{
	if (isset($_GET['id']))
	{
		require_once 'config.php';
	     $requete=$bdd->prepare('SELECT * FROM events WHERE valide=1 and id=?');
	     $requete->execute(array($_GET['id']));
	     $resultat=$requete->fetch();
	     if ($resultat!=NULL)
	     {
	     	if ($resultat['date']>date('Y-m-d'))
	     	{
	     		/*
	     		$requete2=$bdd->prepare('DELETE FROM events WHERE id=?');
	     		$requete2->execute(array($_GET['id']));

	     		$requete3=$bdd->prepare('DELETE FROM salles_events WHERE id_event=?');
	     		$requete3->execute(array($_GET['id']));
	     		
	     		header("Location: historique_events.php");
	     		*/
	     		$req=$bdd->prepare('UPDATE events SET valide=3 WHERE id=?');
	     		$req->execute(array($resultat['id']));


	     		//notif ici >---- seulement si l'admin a annulé l'event d'un club (pas son propre event ou l'event d'un autre admin (dans le cas de multiadministration) via la page historique) // l'annulation par l'admin de son PROPRE event validé depuis la page demandes_acceptees.php est traîtée dans la page annuler_demande.php et non dans celle-ci (annuler_event.php)
	     		$reqq=$bdd->prepare('SELECT * FROM comptes WHERE id=?');
	            $reqq->execute(array($resultat['club_id']));
	            $ress=$reqq->fetch();
	            if ($ress['privilege']!=1)
	     		//if ($_SESSION['id']!=$resultat['club_id']) // edit après multiadministration
	     		{
	     			ajouter_notification($bdd, $resultat['id'], 3, $resultat['club_id'], 1);  // un admin annule l'event validé d'un club donc on doit notifier le club
	     			mail_club_annulation($resultat['id'],$bdd);
				}
	     		

	     		header("Location: events_annules.php");

	            exit;

	     	}
	     	else
	     	{
	     		header("Location: historique_events.php");
	            exit;
	     	}
	     }
	     else
	     {
	     	header("Location: historique_events.php");
	        exit;
	     }
	}

	else
	{
		    header("Location: historique_events.php");
	        exit;

	}
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