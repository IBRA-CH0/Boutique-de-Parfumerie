<?php
require_once "../app/init.php";

// Debug temporaire
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérification de la connexion
if (!isset($_SESSION["utilisateur_id"])) {
    $_SESSION["message"] = ["type" => "warning", "text" => "Veuillez vous connecter pour ajouter au panier."];
    header("Location: login.php");
    exit;
}

// Traitement de l'ajout au panier
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["parfum_id"])) {
    $parfumId = (int) $_POST["parfum_id"];
    $quantite = isset($_POST["quantite"]) ? min(max((int) $_POST["quantite"], 1), 10) : 1;

    // Debug - À retirer après tests
    var_dump($_POST);
    var_dump($_SESSION);

    // Initialisation du panier si nécessaire
    if (!isset($_SESSION["panier"])) {
        $_SESSION["panier"] = [];
    }

    // Ajout ou mise à jour de la quantité
    if (isset($_SESSION["panier"][$parfumId])) {
        $_SESSION["panier"][$parfumId] += $quantite;
    } else {
        $_SESSION["panier"][$parfumId] = $quantite;
    }

    $_SESSION["message"] = [
        "type" => "success",
        "text" => "Le produit a été ajouté à votre panier."
    ];
}

// Redirection vers le panier
header("Location: panier.php");
exit;