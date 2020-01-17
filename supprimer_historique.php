<?php
session_start();

if (isset($_SESSION['privilege']) && $_SESSION['privilege']==1)
{
	if (isset($_GET['id']))
	{
		require_once 'config.php';
	     $requete=$bdd->prepare('SELECT * FROM events WHERE id=?');
	     $requete->execute(array($_GET['id']));
	     $resultat=$requete->fetch();
	     if ($resultat!=NULL)
	     {
	     	if (($resultat['date']<=date('Y-m-d')) || (($resultat['date']>date('Y-m-d'))&&($resultat['valide']>=2)))
	     	{
	     		$requete2=$bdd->prepare('DELETE FROM events WHERE id=?');
	     		$requete2->execute(array($_GET['id']));

	     		$requete3=$bdd->prepare('DELETE FROM salles_events WHERE id_event=?');
	     		$requete3->execute(array($_GET['id']));

	     		$requete4=$bdd->prepare('DELETE FROM notifications WHERE id_event=?'); // On supprime toutes les notifications en relation avec cet event
	     		$requete4->execute(array($_GET['id']));

	     		if (isset($_GET['gerer']))
	     		{
	     			header("Location: gerer_reservations.php");

	     		}
	     		else
	     		{
	     			if (isset($_GET['annule']))
		     		{

		     				header("Location: events_annules.php");

		     		}
		     		else
		     		{
		     			if (isset($_GET['reservationsadmin']))
		     			{
		     				header("Location: demandes_acceptees.php");
		     			}
		     		    else
			     		{
			     			header("Location: historique_events.php");
			     		}
			     	}
		     	}
	     	
	            exit;

	     	}
	     	else
	     	{
	     		
	     		if (isset($_GET['gerer']))
	     		{
	     			header("Location: gerer_reservations.php");

	     		}
	     		else
	     		{
	     				header("Location: historique_events.php");

	     		}
	     	
	            exit;
	     	}
	     }
	     else
	     {
	     	if (isset($_GET['gerer']))
	     		{
	     			header("Location: gerer_reservations.php");

	     		}
	     		else
	     		{
	     				header("Location: historique_events.php");

	     		}
	     	
	            exit;
	     	
	     }
	}

	else
	{
		    if (isset($_GET['gerer']))
	     		{
	     			header("Location: gerer_reservations.php");

	     		}
	     		else
	     		{
	     				header("Location: historique_events.php");

	     		}
	     	
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