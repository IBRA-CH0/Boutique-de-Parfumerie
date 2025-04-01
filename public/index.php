<?php
// On inclut les fichiers nécessaires pour faire fonctionner la page
require_once "../app/init.php";
require_once "../template/header.php";

// On importe les classes dont on a besoin
use App\Models\Parfum;
use App\Models\Categorie;

try {
    // On récupère toutes les catégories et les parfums à afficher
    $categories = Categorie::getAll();
    // On vérifie si une catégorie est sélectionnée dans l'URL
    $categorieId = isset($_GET['categorie']) ? (int) $_GET['categorie'] : 0;
    // On récupère soit tous les parfums, soit ceux de la catégorie choisie
    $parfums = $categorieId > 0 ? Parfum::getByCategory($categorieId) : Parfum::getAll();
} catch (Exception $e) {
    // En cas d'erreur, on affiche un message
    die("<p>Une erreur est survenue : " . ($e->getMessage()) . "</p>");
}
?>

<!-- Menu de navigation pour choisir une catégorie -->
<nav>
    <ul>
        <!-- Lien pour voir tous les parfums -->
        <li><a href="index.php">Tous les parfums</a></li>
        <?php foreach ($categories as $categorie): ?>
            <li>
                <a href="index.php?categorie=<?php echo ($categorie->getId()); ?>">
                    <?php echo ($categorie->getNom()); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<!-- Affichage des parfums -->
<div class="container">
    <?php if (!empty($parfums)): ?>
        <!-- On affiche chaque parfum dans une carte -->
        <?php foreach ($parfums as $parfum): ?>
            <div class="product">
                <!-- Nom du parfum -->
                <h2><?php echo ($parfum->getNom()); ?></h2>
                <!-- Image du parfum si elle existe -->
                <?php if ($parfum->getImage()): ?>
                    <img src="images/<?php echo ($parfum->getImage()); ?>"
                        alt="<?php echo ($parfum->getNom()); ?>"
                        style="width: 200px; height: auto;">
                <?php endif; ?>
                <!-- Description du parfum -->
                <p><?php echo ($parfum->getDescription()); ?></p>
                <h4 class="regular-price">Prix : <?php echo ($parfum->getPrix()); ?>€</h4>
                <!-- Prix promotionnel si disponible -->
                <?php if ($parfum->getPrixPromo()): ?>
                    <h4 class="promo-price">Prix Promo : <?php echo ($parfum->getPrixPromo()); ?>€</h4>
                <?php endif; ?>

                <!-- Formulaire pour ajouter le parfum au panier -->
                <form method="POST" action="update.php" class="mt-3">
                    <input type="hidden" name="parfum_id" value="<?php echo $parfum->getId(); ?>">
                    <div class="input-group">
                        <!-- Choix de la quantité -->
                        <input type="number" id="quantite_<?php echo $parfum->getId(); ?>"
                            name="quantite" value="1" min="1" max="10" required
                            class="form-control" style="max-width: 100px">
                        <!-- Bouton d'ajout au panier -->
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-cart-plus"></i> Ajouter au panier
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Message si aucun parfum n'est trouvé -->
        <p>Aucun parfum trouvé pour cette catégorie.</p>
    <?php endif; ?>
</div>

<?php require_once "../template/footer.php"; ?>