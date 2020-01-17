<?php
session_start(); // Partout
if (isset($_SESSION['email']) AND isset($_SESSION['mdp'])) 
{
    if ($_SESSION['privilege']==0)
	{
	    header("Location: interface.php");
	    exit;
	}

	if (!isset($_POST['nouveaumdp']))
	{
	    header("Location: gerer_clubs.php");
	    exit;
	}
	
		if (isset($_POST['nouveaumdp'])==1 && $_POST['nouveaumdp']!=NULL)
		{
			    require_once 'config.php';

			     $nouveaumdpcrypte=password_hash($_POST['nouveaumdp'], PASSWORD_DEFAULT);
			    $requete=$bdd->prepare('UPDATE comptes SET mdp=? WHERE id=?');  
			 
				$requete->execute(array($nouveaumdpcrypte, $_POST['id']));
				$erreur="ok2";
		}
		else
		{
			$erreur= "Veuillez rentrer le nouveau mot de passe";
		}
	
	
	if (isset($erreur)) // On renvoie vers changer_email_par_admin.php (dans tous les cas isset($erreur)==1 car s'il n'y a pas d'erreur alors elle contiendra la chaine "ok" pour désigner le succès du changement de l'adresse email
	{
  	  $_SESSION['erreur']=$erreur;
  	  $chemin='Location: gerer_clubs.php';
	  header($chemin);
	}
}
else
{
	$_SESSION['lien']=$_SERVER['REQUEST_URI'];
	header("Location: connexion.php");
	exit;

}
?>