<?php 
session_start(); // Partout

// Contrôles de sécurité d'URL (impossible d'y accéder par le lien si les droits sont insuffisants: Voir la partie Sécurisation de l'application du rapport)
if (!(isset($_SESSION['email']) AND isset($_SESSION['mdp']))) 
{
	$_SESSION['lien']=$_SERVER['REQUEST_URI'];
    header("Location: connexion.php");
    exit;

}
if ($_SESSION['privilege']==0)
{
    header("Location: interface.php");
    exit;
}

if (!isset($_GET['id']))
{
    header("Location: gerer_clubs.php");
    exit;
}

 require_once 'config.php';
 $requete=$bdd->prepare('SELECT * FROM comptes WHERE id=?');
 $requete->execute(array($_GET['id']));
 $resultat=$requete->fetch();
 if ($resultat==NULL)
 {
    header("Location: gerer_clubs.php");
    exit;
 }
if ($_SESSION['id']==$_GET['id']) // le service culturel tente d'accéder au lien supprimer_club.php?id=<<L'id_du_service>> alors qu'il n'est pas listé sur la page gerer_clubs.php, il ne peut pas se supprimer <---- !  
    {
        header("Location: gerer_clubs.php");
       exit;
    }

$req1=$bdd->prepare('SELECT * FROM events WHERE club_id=?');
$req1->execute(array($_GET['id']));
$res1=$req1->fetch();
while ($res1!=NULL)
{
    $req2=$bdd->prepare('DELETE from salles_events WHERE id_event=?'); 
    $req2->execute(array($res1['id'])); 
    $req3=$bdd->prepare('DELETE FROM events WHERE id=?');
    $req3->execute(array($res1['id']));
    $res1=$req1->fetch();
}

$req4=$bdd->prepare('DELETE FROM comptes WHERE id=?');
$req4->execute(array($_GET['id']));
$req5=$bdd->prepare('DELETE FROM notifications WHERE idConcerne=? OR idActionneur=?'); // on supprime toutes les notifications destinées ou actionnées par l'utilisateur, après suppression de son compte.
$req5->execute(array($_GET['id'], $_GET['id']));
$erreur="ok3";
$_SESSION['erreur']=$erreur;


header("Location: gerer_clubs.php");
exit;


?>

