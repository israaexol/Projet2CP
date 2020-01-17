<?php
session_start();

if (isset($_SESSION['privilege']) && $_SESSION['privilege']==1)
{

	if ((!isset($_POST['semestre']))||(!isset($_POST['salle'])))
	{
		header('Location: afficher_salles.php');
		exit;
	}
	if (($_POST['semestre']!=1) && ($_POST['semestre']!=2))
	{
		header('Location: afficher_salles.php');
		exit;
	}

	require_once 'config.php';
	$req1=$bdd->prepare('SELECT * FROM salles_id WHERE id=?');
	$req1->execute(array($_POST['salle']));
	$salle=$req1->fetch();
	if ($salle==NULL)
	{
		header('Location: afficher_salles.php');
		exit;	
	}

	$jours = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
	$semestre=$_POST['semestre'];
	if ($semestre==1)
	{
		$req2=$bdd->prepare('DELETE FROM planning_s1 WHERE ID=?');
	}
	else
	{
		$req2=$bdd->prepare('DELETE FROM planning_s2 WHERE ID=?');
	}
	$req2->execute(array($salle['nom'])); // On supprime le planning de la salle

	if (isset($_POST['choix'])) // Contient les choix cochés en forme "JOUR SEANCE" avec JOUR un entier entre 0 et 4 et SEANCE un entier entre 1 et 9 (l'espace est compris dans le choix, il faudra découper la chaine de caractères en deux)
	{
		if ($semestre==1)
		{	
			$req3=$bdd->prepare('INSERT INTO planning_s1 (ID, Jour, Creneau) VALUES (:ID, :Jour, :Creneau)');
		}
		else
		{
				$req3=$bdd->prepare('INSERT INTO planning_s2 (ID, Jour, Creneau) VALUES (:ID, :Jour, :Creneau)');
		}
		foreach ($_POST['choix'] as $choix)
		{
			$tmp=explode(" ", $choix);
			$jour=$tmp['0'];
			$seance=$tmp['1'];
			$req3->execute(array(
				'ID'=>$salle['nom'],
				'Jour'=>$jours[((int)$jour)],
				'Creneau'=>((int)$seance)
			));


		}
	}
	$chemin='Location: '.'gerer_planning.php?semestre='.$semestre.'&salle='.$_POST['salle'];
	header($chemin);
	

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