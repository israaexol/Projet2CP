<?php
session_start(); // Partout
if (isset($_SESSION['email']) AND isset($_SESSION['mdp'])) 
{
	
		if (isset($_POST['nouvelemail'])==1 && $_POST['nouvelemail']!=NULL)
		{
			    require_once 'config.php';
			    $requete=$bdd->prepare('SELECT * FROM comptes WHERE email=?');  // On recherche si cet e-mail existe déjà et on renvoie une erreur si c'est le cas.
				$requete->execute(array($_POST['nouvelemail']));
				$resultat=$requete->fetch();
				if ($resultat!=NULL)
				{
					$erreur="Mail déjà existant."; 
				}
				
				else
				{
					$requete2=$bdd->prepare('UPDATE comptes SET email=? WHERE email=?');
					$requete2->execute(array($_POST['nouvelemail'], $_SESSION['email']));
					$_SESSION['email']=$_POST['nouvelemail'];
					$erreur="ok";
				}

		}
		else
		{
			$erreur= "Veuillez rentrer le nouvel e-mail";
		}
	
	
	if (isset($erreur)) // On renvoie vers changer_email.php (dans tous les cas isset($erreur)==1 car s'il n'y a pas d'erreur alors elle contiendra la chaine "ok" pour désigner le succès du changement de l'adresse email
	{
  	  $_SESSION['erreur']=$erreur;
  	  $_SESSION['num_verif']=1;
	  header("Location: mon_profil.php");
	}
}
else
{
	$_SESSION['lien']=$_SERVER['REQUEST_URI'];
	header("Location: connexion.php");
	exit;

}
?>