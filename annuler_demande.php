<?php
session_start();
include 'fonctions.php';
if (isset($_SESSION['privilege']))
{ 
	if (isset($_GET['id']))
	{
		require_once 'config.php';
		$requete= $bdd->prepare('SELECT * FROM events WHERE id=?');
		$requete->execute(array($_GET['id']));
		$resultat=$requete->fetch();

		if ($resultat['club_id']!=$_SESSION['id']) // Cette page permet à l'utilisateur d'annuler ses PROPRES demandes en attente ou validées (n'ayant pas encore eu lieu), quelque soit son privilège (Club: dans ce cas ses events sont soit en attente soit validées;   Admin : dans ce cas ses events sont forcément validés automatiquement)
		{
			header("Location: interface.php");
           	exit;

		}
		if ($resultat!=NULL)
		{
			if (($resultat['valide']<2)&&(($resultat['date'])>date('Y-m-d')))
			{
				/*
				$req2=$bdd->prepare('DELETE FROM events WHERE id=?');
				$req3=$bdd->prepare('DELETE FROM salles_events WHERE id_event=?');
				*/
				if ( $resultat['valide']==0)   // donc c'est le club qui veut annuler une demande en attente; on met valide=4 (En attente puis annulé)
					{
						//---------- notif
						/*
						$req2->execute(array($_GET['id']));
				        $req3->execute(array($_GET['id']));
				        */
				        $req=$bdd->prepare('UPDATE events SET valide=4 WHERE id=?');
				        $req->execute(array($resultat['id']));
				        ajouter_notification($bdd, $resultat['id'], 4, 1, $_SESSION['id']); // le club annule sa demande en attente, on doit notifier l'admin
				        mail_admin_annulation($resultat['id'],$bdd);
						header("Location: demandes_attente.php");
					}
					else // donc l'event est validé (valide=1)
					{
						
						
							$req4=$bdd->prepare('UPDATE events SET valide=3 WHERE id=?'); // on marque l'event comme annulé(validé=3)
							$req4->execute(array($resultat['id']));
							if ($_SESSION['privilege']==1) // donc l'admin a annulé son propre event validé, depuis la page demandes_acceptees.php forcément, on le redirige vers celle-ci.
							{
								header("Location: demandes_acceptees.php");
							}
							else // le club ne peut pas voir les events validés et qui ont été annulés via la page events_annules.php ) mais il peut le faire sur ses propres events annulés qui sont dans demandes_acceptees.php. Seul l'admin peut accéder à events_annules.php
							{
								// notif ici---> , donc ce n'est pas un admin qui a annulé son propre event validé, mais bien un club qui l'a fait. On doit avertir l'admin <----
								ajouter_notification($bdd, $resultat['id'], 3, 1, $_SESSION['id']);  // le club annule son propre event validé
								mail_admin_annulation($resultat['id'],$bdd);
								if (isset($_GET['historique'])) // donc le club a annulé son propre event validé, soit depuis la page de l'historique (où il a l'option annuler depuis son propre event, soit depuis la page demandes_acceptees.php)
								{
									header("Location: historique_events.php");
								}
								else // donc l'admin a annulé son propre event validé, depuis la page demandes_acceptees
								{
									header("Location: demandes_acceptees.php");
								}
							}
							
						

											
					}
           	    exit;

			}
			else
			{
				header("Location: interface.php");
           	    exit;

			}
		}
		else
		{
			header("Location: interface.php");
            exit;

		}


	}
	else
	{ 
		header("Location: interface.php");
        exit;

	}
}
else
{
	 $_SESSION['lien']=$_SERVER['REQUEST_URI'];
	header("Location: connexion.php");
	exit;
	

}
?>