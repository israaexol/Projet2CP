<?php
session_start();

if (isset($_SESSION['privilege']) && $_SESSION['privilege']==1)
{

	if (!isset($_POST['salle']))
	{
		$_SESSION['erreur']="Vous devez rentrer le nom d'une salle";
		header('Location: afficher_salles.php');
		exit;
	}
	require_once 'config.php';
	$salle=strtoupper($_POST['salle']); //nom de la salle en majuscules


    /// Les requêtes MYSQL ne sont pas case-sensitive(si on cherche des majuscules alors dans les résultats on peut trouver majuscules et miniscules par exemple, les majuscles ne sont pas considérés dans la recherche sql dans un attribut chaine de caracteres)
	$req1=$bdd->prepare('SELECT * FROM salles_id WHERE nom=?');
	$req1->execute(array($salle));
	$res1=$req1->fetch();
	if ($res1!=NULL)
	{
		$_SESSION['erreur']="Salle déjà existante, entrez le nom d'une autre salle.";
		header('Location: afficher_salles.php');
		exit;
	}
	 

	$jours = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];

	$req2=$bdd->prepare('INSERT INTO salles_id (nom) VALUES (:nom)');
	$req3=$bdd->prepare('INSERT INTO planning_vacances (ID, Jour, Creneau) VALUES (:ID, :Jour, :Creneau)');

	$req2->execute(array(
		'nom'=>$salle
	));

	for ($i=0; $i<=6; $i++)
	{
		for ($j=1; $j<=9; $j++)
		{
			$req3->execute(array(
				'ID'=>$salle,
				'Jour'=>$jours[$i],
				'Creneau'=>$j
			));
		}
	}
	$_SESSION['erreur']="ok";
		header('Location: afficher_salles.php');
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
    header("Location: interface.php");
    exit;
}