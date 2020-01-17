<?php
session_start();

if (isset($_SESSION['privilege']) && $_SESSION['privilege']==1) // on n'autorise que l'administrateur avec le privilège 1 à accéder à ce traitement. En cas où l'administrateur lance directement l'URL verif_ajout_club.php depuis son navigateur, alors il n'y aura aucun champs dans $_POST et donc ce sera traîté comme si il n'y avait aucun champs renseigné dans le formulaire.
{
	$necessaire=array('nom', 'email', 'mdp'); 
	foreach($necessaire as $champs) 
	{
		if (empty($_POST[$champs]))  // On vérifie que tous les champs ont été remplis en une boucle qui parcourt le tableau des champs de la variable $_POST dont ses attributs ont été définis dans le formulaire présent dans ajouter_club.php
		{
   		    $erreur = "Tous les champs doivent être renseignés.";
  		}
	}
	if (isset($erreur)==0) // S'il n'y a eu aucune erreur ci-dessus (à aucun moment on a procédé à une affectation $erreur= .. dans la variable $erreur n'existe toujours pas dans cette page, donc son isset est à 0), alors procéder au traitement des champs
	{
		$mdpcrypte=password_hash($_POST['mdp'], PASSWORD_DEFAULT); // Crypter le mot de passe
		require_once 'config.php'; // Connexion à la base de données dans chaque page nécessitant sa manipulation
		$requete=$bdd->prepare('SELECT * FROM comptes WHERE email=?');  // On recherche si cet e-mail existe déjà et on renvoie une erreur si c'est le cas.
		$requete->execute(array($_POST['email']));
		$resultat=$requete->fetch();
		if ($resultat!=NULL)
		{
			$erreur="Mail déjà existant."; 
		}
		else
		{
			$privilege=0;
			if (isset($_POST['choix_privilege']))
			{
				if (($_SESSION['privilege']==1) &&($_POST['choix_privilege']==1)) // Donc c'est un administrateur qui ajoute un compte administrateur
				{
					$privilege=1;
				}
			}
			$requete2=$bdd->prepare('INSERT INTO comptes (nom, email, mdp, privilege) VALUES (:nom, :email, :mdp, :privilege)'); // Le privilège du compte à insérer est 0 (4ème paramètre de VALUES car le compte service insère toujours un compte club)
			$requete2->execute(array(
				'nom'=>$_POST['nom'],
				'email'=>$_POST['email'],
				'mdp'=>$mdpcrypte,
				'privilege'=>$privilege
			));
			$erreur="ok"; // pas d'erreur, on traîte ce cas de façon particulière dans ajouter_club.php pour afficher un message vert de succès d'ajout.
			
		}

	}
	if (isset($erreur))
	{
		$_SESSION['erreur']=$erreur;
	    header("Location: gerer_clubs.php"); // S'il y'a une erreur on la stocke dans la variable globale de session, et on y accède depuis ajouter_club.php pour l'afficher
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
	header("Location: interface.php"); // donc pas de privilège d'administrateur, on renvoie à l'interface. et si l'utilisateur est carrément déconnecté alors l'interface se chargera de le renvoyer vers la page de connexion
    exit;
}


?>