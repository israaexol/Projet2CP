<?php
session_start(); // session_start() doit être appelée dans toute page nécessitant de manipuler la variable session. "start" ne veut pas dire que la session est écrasée, ça permettra de récupérer tous les attributs du tableau $_SESSION si déjà définis dans d'autres pages pour la même session (PC), sinon ça initialisera un tableau sans aucun attribut où nous pouvons définir tous les attributs qu'on veut
// isset permet de vérifier si un attribut existe dans un tableau, ou qu'une variable existe (elle a été initialisée quelque part même si sa valeur est à NULL)

// La variable $_POST est un tableau qui contient des attributs associatifs (par nom de case, ex : 'email') exactement comme $_SESSION. $_POST contiendra les attributs du formulaire qui a appelé verif_connexion.php avec (action)="verif_connexion.php" et avec la methode "method=GET" . Dans le formulaire, ce sera les attributs 'name' des inputs qui seront transmis, par exemple il y'a input type="password" name="mdp" , et donc aura dans $_POST['mdp'] la valeur rentrée par l'utilisateur dans ce champs
// $_POST['email'] doit exister (elle l'est toujours car il existe un champ d'email en forme d'input avec name='email')
if (isset($_POST['email'])==1 && $_POST['email']!=NULL) // $_POST['email'] ne doit pas contenir NULL (c'est à dire que la variable est bien définie mais que le champs a été envoyé vide, isset renverra bien 1 car l'attribut existe) et dans ces deux cas si ce n'est pas vérifié, alors on enregistre l'erreur qui est "champs inexistant/vide" (voir le "else" de cette condition)
{
	if (isset($_POST['mdp'])==1 && $_POST['mdp']!=NULL) // Même chose pour le mot de passe, on doit tester sa présence, sinon enregistrer l'erreur.
	{
		require_once 'config.php'; // Connexion à la base de données de nom 'nouveau'
		$rechercheemail=$bdd->prepare('SELECT * from comptes WHERE email=?'); // Préparation de la requête SQL afin de rechercher l'adresse e-mail tapée par l'utilisateur dans connexion.php et récupérée dans $_POST['email']. Comme nous devons saisir dans la requête SQL la valeur d'une variable, alors on doit utiliser la méthode "prepare" et mettre des points d'interrogations là où on veut les remplacer par des variables lorsqu'on appelle ma methode execute 
		$rechercheemail->execute(array($_POST['email'])); // "execute" prends un tableau array($param1, $param2, ....) nombre de paramètres = nombres de points d'interrogations dans la méthode prepare, qui seront remplacés un par un par le paramètre dans l'ordre.
		$resultat=$rechercheemail->fetch(); // fetch() est un curseur qui permettra de parcourir les resultats stockés dans $rechercheemail après avoir appelé la méthode 'execute' qui a bien exécuté la requête SQL, son premier appel renverra dans $resultat la première ligne du résultat de la requête SELECT, qui est stocké dans $rechercheemail. L'appel à fetch() une deuxième fois permettra de mettre à jour $resultat, qui prendra la valeur de la deuxième ligne du résultat du SELECT dans la base de données. à un certain moment, on aura parcouru toutes les lignes du résultat de la recherche, et le dernier fetch() renverra NULL.
		if ($resultat!=NULL) // Si on a NULL au premier coup c'est qu'il n'y a aucun résultat, i.e aucune adresse e-mail dans la base de données, correspondant à l'email que l'utilisateur a rentré pour essayer de se connecter.
		// NB : $resultat est un tableau des attributs définis par SELECT, comme on a sélectionné tous les attributs de la table avec "*" dans la requête SQL, alors on pourra accéder au résultat champ par champ : $_resultat['email'].. ect , et ce pour la même ligne obtenue après l'appel à fetch()
		{
			// Les mots de passes sont hashés avec la fonction password_hash (voir ajouter_club.php et verif_ajout_club.php). 
			if (password_verify($_POST['mdp'], $resultat['mdp'])==1) // on compare le mdp récupéré avec le mdp hashé stocké dans la base de données avec cette fonction prédéfinie qui fonctionne avec password_hash
		    {
		    	// Si le mot de passe est correct (l'email aussi), alors on définit des variables personnalisées dans la variable $_SESSION où on stockera l'id de l'utilisateur, son nom, email, mot de passe hashé (on n'en a pas besoin) et privilege (pour voir si c'est le compte service(privilege=1)) ou un simple club (privilege=0)
		    
       		    $_SESSION['id'] = $resultat['id'];
     		    $_SESSION['nom'] = $resultat['nom'];
     		    $_SESSION['email'] = $resultat['email'];
     		    $_SESSION['mdp'] = $resultat['mdp'];
     		    $_SESSION['privilege'] = $resultat['privilege'];
     		    // en sachant qu'on pourra accéder à ces attributs depuis n'importe quelle page pour la même session (ordinateur) , dans le cas où l'utilisateur ne s'est pas déconnecté via deconnexion.php où la variable session sera détruite.

     		    if (!empty($_SESSION['lien2']))  // rediriger vers le lien qui a nécessité la connexion lorsque l'utilisateur était déconnecté.
     		    {
     		    	$chemin='Location: '.$_SESSION['lien2'];
     		    	$_SESSION['lien2']=NULL;
     		    	header($chemin);
     		    	exit;
     		    }

     		    header("Location: interface.php"); // redirection vers interface.php (après connexion et mémorisation de session)
     		    exit; 
		    }
		    else
		    {
		    	$erreur="Mot de passe incorrect";
		    }

		}
		else
		{
			$erreur="Adresse e-mail incorrecte";
		}


	}
	else
	{
		$erreur="Veuillez introduire un mot de passe.";
	}
}
else
{
	$erreur="Veuillez introduire une adresse mail";

}

if (isset($erreur)==1)
{
	// NB (les variables normales précédées d'un $ sont locales et ne sont présentes que dans la page PHP courante)
	// Si la variable d'erreur est bien définie (elle l'est toujours car si on arrive ici c'est qu'on a pas exécuté le header location interface.php donc il y'a eu une erreur quelque part, et donc elle a reçu une valeur après avoir croisé une erreur, alors on la transmet via $_SESSION['erreur'] pour la restituer à la page connexion.php qui affichera cette erreur.)

	$_SESSION['erreur']=$erreur;
	header("Location: connexion.php");
}

?>
