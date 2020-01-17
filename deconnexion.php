<?php
session_start(); // Partout où la variable session est utilisée, on doit faire session_start();
$_SESSION = array(); // On vide la variable session
session_destroy(); // Destruction
header("Location: connexion.php"); // Retour à la page de connexion
exit;
?>
