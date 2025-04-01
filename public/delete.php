<?php
require_once "../app/init.php";

// Vérification de la connexion
if (!isset($_SESSION["utilisateur_id"])) {
    $_SESSION["message"] = ["type" => "warning", "text" => "Veuillez vous connecter pour accéder au panier."];
    header("Location: login.php");
    exit;
}

// Traitement de la suppression
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["parfum_id"])) {
    $parfumId = (int) $_POST["parfum_id"];
    
    if (isset($_SESSION["panier"][$parfumId])) {
        // Récupérer les informations du parfum pour le message
        $parfum = App\Models\Parfum::getById($parfumId);
        $nomParfum = $parfum ? $parfum->getNom() : "Le produit";
        
        // Supprimer du panier
        unset($_SESSION["panier"][$parfumId]);
        
        $_SESSION["message"] = [
            "type" => "success", 
            "text" => htmlspecialchars($nomParfum) . " a été supprimé de votre panier."
        ];
    }
}

// Redirection vers le panier
header("Location: panier.php");
exit;