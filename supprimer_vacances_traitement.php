<?php
session_start();

if (isset($_SESSION['privilege']) && $_SESSION['privilege']==1)
{
	if (!empty($_GET['id']))
	{
		require_once 'config.php';
		$requete=$bdd->prepare('DELETE FROM dates_vacances WHERE id=?');
		$requete->execute(array($_GET['id']));
		header('Location: gerer_vacances.php');
		
	}
	else
	{
		header('Location: gerer_vacances.php');
		
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

