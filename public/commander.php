<?php
require_once "../app/init.php";

// On vérifie si l'utilisateur est connecté
if (!isset($_SESSION["utilisateur_id"])) {
    $_SESSION["message"] = ["type" => "warning", "text" => "Veuillez vous connecter pour finaliser votre commande."];
    header("Location: login.php");
    exit;
}

// On traite le formulaire quand il est envoyé
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // On récupère les informations du formulaire
    $nom = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]);
    $adresse = trim($_POST["adresse"]);
    $telephone = trim($_POST["telephone"]);
    $email = trim($_POST["email"]);

    // On vérifie que tous les champs sont remplis
    if (empty($nom) || empty($prenom) || empty($adresse) || empty($telephone) || empty($email)) {
        $_SESSION["message"] = ["type" => "danger", "text" => "Tous les champs sont obligatoires."];
        header("Location: validation-commande.php");
        exit;
    }

    // On démarre une transaction dans la base de données
    try {
        $pdo = \App\manager\Database::connect();
        $pdo->beginTransaction();

        $utilisateurId = $_SESSION["utilisateur_id"];

        // Pour chaque parfum dans le panier
        foreach ($_SESSION["panier"] as $parfumId => $quantite) {
            $parfum = \App\Models\Parfum::getById($parfumId);
            if ($parfum) {
                $prix = $parfum->getPrixPromo() ?: $parfum->getPrix();
                $total = $prix * $quantite;

                // On prépare la requête pour enregistrer la commande avec nom et prénom
                $query = $pdo->prepare("
                    INSERT INTO commandes (
                        utilisateur_id, parfum_id, quantite, total, 
                        nom, prenom, adresse_livraison, telephone, email
                    ) VALUES (
                        :utilisateur_id, :parfum_id, :quantite, :total,
                        :nom, :prenom, :adresse, :telephone, :email
                    )
                ");

                // On exécute la requête avec les données
                $query->execute([
                    ':utilisateur_id' => $utilisateurId,
                    ':parfum_id' => $parfumId,
                    ':quantite' => $quantite,
                    ':total' => $total,
                    ':nom' => $nom,
                    ':prenom' => $prenom,
                    ':adresse' => $adresse,
                    ':telephone' => $telephone,
                    ':email' => $email
                ]);
            }
        }

        // Si tout se passe bien, on valide la transaction
        $pdo->commit();
        $_SESSION["panier"] = []; // Vider le panier
        $_SESSION["message"] = ["type" => "success", "text" => "Votre commande a été validée avec succès !"];
        header("Location: mes-commandes.php");
        exit;
    } catch (\PDOException $e) {
        // En cas d'erreur, on annule la transaction
        $pdo->rollBack();
        $_SESSION["message"] = ["type" => "danger", "text" => "Erreur lors de la validation de la commande : " . $e->getMessage()];
        header("Location: validation-commande.php");
        exit;
    }
}

header("Location: panier.php");
exit;
