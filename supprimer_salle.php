<?php
session_start();

if (isset($_SESSION['privilege']) && $_SESSION['privilege']==1)
{

	if (!isset($_GET['salle']))
	{
		header('Location: afficher_salles.php');
		exit;
	}
	

	require_once 'config.php';
	$req=$bdd->prepare('SELECT * FROM salles_id WHERE ID=?');
	$req->execute(array($_GET['salle']));
	$res=$req->fetch();

	if ($res==NULL)
	{
		header('Location: afficher_salles.php');
		exit;
	}

	$salle=$res['nom'];

	$req2=$bdd->prepare('DELETE FROM salles_events WHERE salle=?');
	$req3=$bdd->prepare('DELETE FROM planning_s1 WHERE ID=?');
	$req4=$bdd->prepare('DELETE FROM planning_s2 WHERE ID=?');
	$req5=$bdd->prepare('DELETE FROM planning_vacances WHERE ID=?');
	$req6=$bdd->prepare('DELETE FROM salles_id WHERE id=?');
	$req2->execute(array($salle));
	$req3->execute(array($salle));
	$req4->execute(array($salle));
	$req5->execute(array($salle));
	$req6->execute(array($_GET['salle']));
    
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