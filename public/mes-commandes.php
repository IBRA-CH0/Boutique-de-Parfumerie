<?php
// On charge les fichiers nécessaires
require_once "../app/init.php";
require_once "../template/header.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["utilisateur_id"])) {
    $_SESSION["message"] = ["type" => "warning", "text" => "Veuillez vous connecter pour voir vos commandes."];
    header("Location: login.php");
    exit;
}

try {
    // On se connecte à la base de données
    $pdo = \App\manager\Database::connect();

    // On prépare la requête pour récupérer les commandes de l'utilisateur
    $query = $pdo->prepare("
        SELECT c.*, p.nom as parfum_nom, p.image, c.nom, c.prenom
        FROM commandes c
        JOIN parfums p ON c.parfum_id = p.id
        WHERE c.utilisateur_id = ?
        ORDER BY c.date_commande DESC
    ");

    // On exécute la requête avec l'ID de l'utilisateur
    $query->execute([$_SESSION["utilisateur_id"]]);
    $commandes = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    // En cas d'erreur, on affiche un message
    $_SESSION["message"] = ["type" => "danger", "text" => "Erreur : " . $e->getMessage()];
    header("Location: index.php");
    exit;
}
?>

<!-- Titre de la page -->
<h2>Historique de mes commandes</h2>
<div class="container mt-4">
    <!-- Affichage des commandes -->
    <?php if (!empty($commandes)): ?>
        <div class="row">
            <?php foreach ($commandes as $commande): ?>
                <!-- Carte pour chaque commande -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <!-- En-tête de la carte avec numéro et date -->
                        <div class="card-header bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Commande #<?= $commande["id"] ?></h5>
                                <span class="badge bg-success">
                                    <?= date("d/m/Y H:i", strtotime($commande["date_commande"])) ?>
                                </span>
                            </div>
                            <!-- Ajout du nom et prénom du client -->
                            <div class="mt-2 text-muted">
                                <small>Client : <?= htmlspecialchars($commande["nom"]) ?> <?= htmlspecialchars($commande["prenom"]) ?></small>
                            </div>
                        </div>

                        <!-- Corps de la carte avec détails de la commande -->
                        <div class="card-body">
                            <!-- Informations sur le parfum -->
                            <div class="d-flex mb-3">
                                <img src="images/<?= htmlspecialchars($commande["image"]) ?>"
                                    alt="<?= htmlspecialchars($commande["parfum_nom"]) ?>"
                                    class="img-thumbnail me-3" style="width: 100px; height: 100px; object-fit: cover;">
                                <div>
                                    <h5 class="card-title"><?= htmlspecialchars($commande["parfum_nom"]) ?></h5>
                                    <p class="card-text mb-1">
                                        <strong>Quantité :</strong> <?= $commande["quantite"] ?>
                                    </p>
                                    <p class="card-text">
                                        <strong>Total :</strong> <?= number_format($commande["total"], 2) ?> €
                                    </p>
                                </div>
                            </div>

                            <hr>
                            <!-- Informations de livraison -->
                            <div class="delivery-info">
                                <h6 class="mb-3">Informations de livraison</h6>
                                <p class="mb-1">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?= htmlspecialchars($commande["adresse_livraison"]) ?>
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-phone"></i>
                                    <?= htmlspecialchars($commande["telephone"]) ?>
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-envelope"></i>
                                    <?= htmlspecialchars($commande["email"]) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- Message si aucune commande -->
        <div class="alert alert-info">
            <p class="mb-0">Vous n'avez pas encore passé de commande.</p>
            <a href="index.php" class="btn btn-primary mt-3">
                <i class="fas fa-shopping-bag"></i> Voir nos parfums
            </a>
        </div>
    <?php endif; ?>
</div>

<?php require_once "../template/footer.php"; ?>