<?php
// On charge les fichiers dont on a besoin pour faire marcher la page
require_once "../app/init.php";
require_once "../template/header.php";

// On vérifie si l'utilisateur est connecté à son compte
if (!isset($_SESSION["utilisateur_id"])) {
    $_SESSION["message"] = ["type" => "warning", "text" => "Veuillez vous connecter pour finaliser votre commande."];
    header("Location: login.php");
    exit;
}

// On vérifie si le panier contient des articles
if (empty($_SESSION["panier"])) {
    $_SESSION["message"] = ["type" => "warning", "text" => "Votre panier est vide."];
    header("Location: panier.php");
    exit;
}

// On prépare une variable pour calculer le total de la commande
$total_commande = 0;
?>

<!-- La page commence ici -->
<h2>Renseignez vos coordonnées</h2>
<div class="container mt-4">
    <div class="row">
        <!-- Formulaire pour les informations de livraison -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Informations de livraison</h3>
                </div>
                <div class="card-body">
                    <!-- Le formulaire envoie les données vers la page commander.php -->
                    <form method="POST" action="commander.php">
                        <!-- Zone pour entrer le nom et le prénom -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Nom</label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Prénom</label>
                                <input type="text" name="prenom" class="form-control" required>
                            </div>
                        </div>

                        <!-- Zone pour entrer l'adresse -->
                        <div class="form-group mb-3">
                            <label>Adresse de livraison</label>
                            <input name="adresse" class="form-control" rows="3" required></input>
                        </div>

                        <!-- Zone pour le téléphone et l'email -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Téléphone</label>
                                <input type="tel" name="telephone" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="<?= isset($_SESSION['utilisateur_email']) ? htmlspecialchars($_SESSION['utilisateur_email']) : '' ?>"
                                    required>
                            </div>
                        </div>

                        <!-- Boutons pour revenir au panier ou valider la commande -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="panier.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour au panier
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Valider la commande
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Résumé du panier -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Récapitulatif</h3>
                </div>
                <div class="card-body">
                    <!-- On affiche chaque parfum du panier -->
                    <?php foreach ($_SESSION["panier"] as $parfumId => $quantite):
                        $parfum = \App\Models\Parfum::getById($parfumId);
                        if ($parfum):
                            $prix = $parfum->getPrixPromo() ?: $parfum->getPrix();
                            $sous_total = $prix * $quantite;
                            $total_commande += $sous_total;
                    ?>
                            <!-- Ligne pour chaque parfum -->
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <?= htmlspecialchars($parfum->getNom()) ?> x <?= $quantite ?>
                                </div>
                                <div>
                                    <?= number_format($sous_total, 2) ?> €
                                </div>
                            </div>
                    <?php
                        endif;
                    endforeach; ?>
                    <hr>
                    <!-- Affichage du total final -->
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong><?= number_format($total_commande, 2) ?> €</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../template/footer.php"; ?>