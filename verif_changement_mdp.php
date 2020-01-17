<?php
session_start(); // Partout
if (isset($_SESSION['email']) AND isset($_SESSION['mdp'])) // L'utilisateur doit être connecté sinon on le renvoie vers connexion.php dans le cas de la non-présence de la variable de session (qui est établie dans verif_connexion.php après vérification de correspondance de l'email/mdp)
{
	if (isset($_POST['ancienmdp'])==1 && $_POST['ancienmdp']!=NULL) // Le champs de l'ancien mot de passe ne doit pas être vide (dans le formulaire dans ajouter_club.php)
	{
		if (isset($_POST['nouveaumdp'])==1 && $_POST['nouveaumdp']!=NULL) // Pareil pour le nouveau mot de passe
		{
				if (password_verify($_POST['ancienmdp'], $_SESSION['mdp'])==1) // _SESSION['mdp'] contient le cryptage du mdp qu'on a stocké pour la session actuelle (l'utilisateur actuel), ça permettra de vérifier que le hash du champs "ancien mot de passe" qui est rentré par l'utilisateur, correspond bien au hash stocké dans la variable $_SESSION['mdp'].. (hash= cryptage par la fonction password_hash , et verify permet de vérifier que c'est le bon mot de passe lorsqu'on a seulement son hash)
				{
					$nouveaumdpcrypte=password_hash($_POST['nouveaumdp'], PASSWORD_DEFAULT); // On crypte le nouveau mot de passe rentré par l'utilisateut
					require_once 'config.php';
					$requete=$bdd->prepare('UPDATE comptes SET mdp=? WHERE email=?'); // On modifie l'entrée dans la base de données du compte connecté (pour changer son mot de passe), en sachant qu'on a déjà son email pour le rechercher dans la BDD (via la variable session)
					$requete->execute(array($nouveaumdpcrypte, $_SESSION['email']));
					$_SESSION['mdp']=$nouveaumdpcrypte; // Mise à jour du mot de passe dans la variable temporaire de session
					$erreur="ok";
				}
				else
				{
					$erreur="Ancien mot de passe incorrect.";
				}

		}
		else
		{
			$erreur= "Veuillez rentrer le nouveau mot de passe";
		}
	}
	else
	{
		$erreur= "Veuillez rentrer l'ancien mot de passe";
	}
	if (isset($erreur)) // On renvoie vers changer_mdp.php (dans tous les cas isset($erreur)==1 car s'il n'y a pas d'erreur alors elle contiendra la chaine "ok" pour désigner le succès du changement de mot de passe)
	{
  	  $_SESSION['erreur']=$erreur;
  	  $_SESSION['num_verif']=2;
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