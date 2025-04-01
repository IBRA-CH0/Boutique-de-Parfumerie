<?php

// On active l'affichage de toutes les erreurs pour le développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// On charge les fichiers nécessaires pour faire fonctionner l'application
require_once __DIR__ . "/manager/Database.php";
require_once __DIR__ . "/manager/BaseModel.php";
require_once __DIR__ . "/Models/Utilisateur.php";
require_once __DIR__ . "/Models/Parfum.php";
require_once __DIR__ . "/Models/Categorie.php";
require_once __DIR__ . "/Models/Commande.php";
require_once __DIR__ . '/../vendor/autoload.php';

// On démarre une session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>