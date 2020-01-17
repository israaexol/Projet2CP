<?php
session_start();
include 'fonctions.php';
if (isset($_SESSION['privilege']) && $_SESSION['privilege']==1)
{
	if (isset($_GET['id']))
	{
		require_once 'config.php';
	     $requete=$bdd->prepare('SELECT * FROM events WHERE valide=0 and id=?');
	     $requete->execute(array($_GET['id']));
	     $resultat=$requete->fetch();
	     if ($resultat!=NULL)
	     {
	     	if ($resultat['date']>date('Y-m-d'))
	     	{
	     		$requete2=$bdd->prepare('UPDATE events SET valide=2 WHERE id=?');
	     		$requete2->execute(array($_GET['id']));
	     		ajouter_notification($bdd, $resultat['id'], 6, $resultat['club_id'], 1);  // l'admin rejete l'event d'un club dont le club doit être notifié
	     		mail_validation_rejet(0,$resultat['id'],$bdd);
	     			header("Location: gerer_reservations.php");

	     	
	            exit;

	     	}
	     	else
	     	{
	     		
	     			header("Location: gerer_reservations.php");

	     	
	            exit;
	     	}
	     }
	     else
	     {
	     	
	     			header("Location: gerer_reservations.php");
	     	
	            exit;
	     	
	     }
	}

	else
	{
		  header("Location: gerer_reservations.php");

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