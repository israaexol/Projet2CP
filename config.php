<?php 
$en_ligne=0;   // VARIABLE GLOBALE A DEFINIR SI L'APPLICATION EST EN LOCAL OU EN LIGNE /// 0 Pour LOCAL, 1 pour EN LIGNE
// Si l'application est en LOCAL alors il n'y a pas d'envoi d'emails (la fonction d'email est empêchée de s'exécuter)
$debut_s1="09-01"; // mm-jj // Début du S1 quelque soit l'année
$debut_s2="02-01"; // mm-jj // Début du S2 quelque soit l'année

if ($en_ligne==0)
{
	$bdd = new PDO('mysql:host=localhost;dbname=projet;', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
else
{
	$bdd = new PDO('mysql:host=185.98.131.91;dbname=reser1132111;', 'reser1132111', 'okwydurufe', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}


?>