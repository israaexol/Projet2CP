<?php
session_start();
include 'fonctions.php';

if (isset($_SESSION['nom'])==1) 
{
	if (isset($_POST['afficher']) || isset($_POST['envoyer']))
	{
			$_SESSION['temp_titre']=$_POST['titre'];
		    $_SESSION['temp_type']=$_POST['type'];
		    $_SESSION['temp_nb_participants']=$_POST['nb_participants'];
			 if (!empty($_POST['date']))
			 {
			 	   $_POST['date'] = str_replace('/', '-', $_POST['date']);
			 $_POST['date']= date('Y-m-d', strtotime($_POST['date']));
			             $_SESSION['temp_date']=$_POST['date'];

			 }
			 else
			 {
			 	$_SESSION['temp_date']=NULL;
			 }
		    $_SESSION['temp_description']=$_POST['description'];
			$_SESSION['temp_sponsor']=$_POST['sponsor'];
			if ($_SESSION['privilege']==0) $_SESSION['temp_responsable']=$_POST['responsable'];

		if (isset($_POST['envoyer']))
		{
			if ($_SESSION['privilege']==0)
			{
				$necessaire=array('titre', 'type', 'date', 'description', 'responsable'); // edit : sponsor est facultatif
			}
			else
			{
				$necessaire=array('titre', 'type', 'date', 'description'); // edit : sponsor est facultatif
			}
			foreach($necessaire as $champs) 
			{
				if (empty($_POST[$champs]))  
				{
		   		    $erreur = "Tous les champs marqués d'une étoile doivent être renseignés.";
		  		}
			}

			if (isset($erreur)==0)
			{
				
				if (!empty($_SESSION['date_afficher']))
				{
					if ($_SESSION['date_afficher']==$_POST['date']) // partie traitement
					{
						$_SESSION['date_afficher']=NULL;

						require_once 'config.php';
						$bdd->query('SET NAMES UTF8');

						$requete=$bdd->prepare('INSERT INTO events (titre, type, nb_participants, date, club_id, descriptif, sponsor, responsable, valide) VALUES (:titre, :type, :nb_participants, :date, :club_id, :descriptif, :sponsor, :responsable, :valide)');

						if ($_SESSION['privilege']==0)
						{	
								$requete->execute(array(
								'titre' => $_POST['titre'],
								'type' => $_POST['type'],
								'nb_participants' =>  $_POST['nb_participants'],
								'date' =>  $_POST['date'],
								'club_id' =>  $_SESSION['id'],
								'descriptif' => $_POST['description'],
								'sponsor' => $_POST['sponsor'],
								'responsable' => $_POST['responsable'],
								'valide' => $_SESSION['privilege'] // l'event est directement validé si le privilège est à 1 (c'est le service culturel qui est connecté)
							));

						}
						else
						{
								$requete->execute(array(
								'titre' => $_POST['titre'],
								'type' => $_POST['type'],
								'nb_participants' =>  $_POST['nb_participants'],
								'date' =>  $_POST['date'],
								'club_id' =>  $_SESSION['id'],
								'descriptif' => $_POST['description'],
								'sponsor' => $_POST['sponsor'],
								'responsable' => NULL,
								'valide' => $_SESSION['privilege'] // l'event est directement validé si le privilège est à 1 (c'est le service culturel qui est connecté)
							));
						}
						
						$tmp_eventid=$bdd->lastInsertId();
						if ($_SESSION['privilege']==0)
						{
							ajouter_notification($bdd, $tmp_eventid, 1, 1, $_SESSION['id']); 
							mail_demande_reservation($tmp_eventid,$bdd);
						} 
                        /*
						$dernier_id_requete=$bdd->query('SELECT LAST_INSERT_ID()'); // id attribué à l'évenement
						$dernier_id=$dernier_id_requete->fetchColumn();
						*/
						if (isset($_POST['choix'])) // au moins une seance a été selectionnée
						{
							$planning=choix_planning(strtotime($_POST['date']), $bdd);
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
									'id_event' =>$tmp_eventid,
									'salle' =>$requete2_res['ID'],
									'creneau' =>$requete2_res['Creneau']
								));


							}

						}
						else // aucune séaance n'a été sélectionnée
						{
							// normalement y'a rien à mettre ici

						}
						       $_SESSION['temp_titre']=NULL;
						    	$_SESSION['temp_type']=NULL;
                                $_SESSION['temp_nb_participants']=NULL;
						    	$_SESSION['temp_date']=NULL;
						    	$_SESSION['temp_description']=NULL;
						    	$_SESSION['temp_sponsor']=NULL;
						    	$_SESSION['temp_responsable']=NULL;

						$_SESSION['verif_envoi']=1;
						header("Location: reserver.php");
						exit();





					}
					else
					{
					
							$erreur="Vous ne pouvez pas changer la date après avoir affiché les salles puis cliqué sur envoyer, réaffichez à nouveau. <br>"."La date précédemment affichée est : ".$_SESSION['date_afficher'];
							$_SESSION['date_afficher']=NULL;
					}

				}
				else
				{
					$erreur="Vous devez afficher les salles libres avant d'envoyer la demande.";
				}
				
			}
		
			if (isset($erreur))
			{
				$_SESSION['erreur']=$erreur;

			    header("Location: reserver.php");
			}
		}
		else // Donc c'est $_POST['afficher'] qui est définie et l'utilisateur a commandé un affichage
		{

            if ($_POST['date']!=NULL)
            {
            	$_SESSION['date_afficher']=$_POST['date']; // Pour mémoriser la date qui a servi a l'affichage des salles afin de la comparer avec celle qui a été envoyée (mesure de sécurité car l'utilisateur peut changer la date après avoir affiché les salles et avant d'avoir envoyé le formulaire, tout en ayant sélectionné les salles qu'il désire)
				
				//	if ($_POST['date']> date('Y-m-d', strtotime("+15 days")))
				if ($_POST['date']> date('Y-m-d'))
					{
						$_SESSION['procederaffichage']=1;
						header("Location: reserver.php");

					}
					else
					{
						$erreur="Vous devez réserver au moins un jour à l'avance.";
						$_SESSION['date_afficher']=NULL;

					}
            }
            else
            {
      
            	$erreur="Indiquez une date avant d'afficher les salles";
            }

            if (isset($erreur))
			{
				$_SESSION['erreur']=$erreur;
			    header("Location: reserver.php");
			}		
		}
		
	}
	else
	{
            header("Location: reserver.php");

	}

}
else
{
	$_SESSION['lien']=$_SERVER['REQUEST_URI'];
	header("Location: connexion.php");
	exit;


}



?>