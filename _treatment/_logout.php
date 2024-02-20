<?php
session_start();
// Stocker la notification dans une variable
$notification = '<p class="text-align success">Vous avez été déconnecté avec succès.</p>';
// Détruire toutes les variables de session
session_destroy();

// Rediriger vers la page de connexion
header("location: .././login-family.php?notif=" . urlencode($notification));

exit;
?>
