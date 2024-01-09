<?php
session_start();
// Détruire toutes les variables de session
session_destroy();

// Sauvegarder le message de déconnexion dans une variable de session
$_SESSION["logout_message"] = "Vous avez été déconnecté avec succès.";

// Rediriger vers la page de connexion
header("location: .././login-family.php");
exit;
?>
