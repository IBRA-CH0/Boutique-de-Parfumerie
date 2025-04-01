<?php
// On démarre la session pour accéder aux variables de session
session_start();

// On supprime toutes les données de la session (déconnexion)
session_destroy();

// On redirige l'utilisateur vers la page d'accueil
header("Location: index.php");
exit;
?>