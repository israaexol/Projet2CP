<?php
session_start();

if (isset($_SESSION['privilege']) && $_SESSION['privilege']==1)
{
	if ((!isset($_POST['debut']))||(!isset($_POST['fin']))||(!isset($_POST['description'])))
	{
		$_SESSION['erreur']="Tous les champs sont obligatoires.";
	}
	else
	{
				$_POST['debut'] = str_replace('/', '-', $_POST['debut']);
           			 $_POST['debut']= date('Y-m-d', strtotime($_POST['debut']));

           			 $_POST['fin'] = str_replace('/', '-', $_POST['fin']);
           			 $_POST['fin']= date('Y-m-d', strtotime($_POST['fin']));
		if ($_POST['debut']>$_POST['fin'])
		{
			$_SESSION['erreur']="La date de début des vacances doit être inférieure à la date de leur fin.";
		}
		else
		{
			require_once 'config.php';
			$bdd->query('SET NAMES UTF8');
			$debut=$_POST['debut'];
			$fin=$_POST['fin'];
			$vacances=$bdd->prepare('SELECT * from dates_vacances WHERE ((?>=debut) AND (?<=fin)) OR ((?<=debut) AND (?<=fin) AND (?>=debut)) OR ((?>=debut) AND (?>=fin) AND (?<=fin)) OR ((?<=debut) AND (?>=fin))');
			$vacances->execute(array($debut, $fin, $debut, $fin, $fin, $debut, $fin, $debut, $debut, $fin));
			$resultat=$vacances->fetch();
			if ($resultat!=NULL)
			{
				$_SESSION['erreur']="Cet intervalle de date (ou en partie) conïncide avec une période de vacances déjà existantes, veuillez le modifier";
			}
			else
			{
				$requete=$bdd->prepare('INSERT INTO dates_vacances (debut, fin, description) VALUES (:debut, :fin, :description)');
				$requete->execute(array(
					'debut'=>$_POST['debut'],
					'fin'=>$_POST['fin'],
					'description'=>$_POST['description']
				));
				$_SESSION['erreur']='ok';
			}
		}

	}

	header("Location: gerer_vacances.php");
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