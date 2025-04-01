<?php
// Inclusion des fichiers nécessaires
require_once "../app/init.php";  // Initialise l'application (connexion à la base de données, configuration, etc.)
require_once "../template/header.php"; // Inclut l'en-tête de la page (HTML, CSS, navigation)

// Importation de la classe Parfum depuis son namespace
use App\Models\Parfum;

// Vérifie si le panier contient des articles
if (!empty($_SESSION["panier"])) {
    echo "<div class='container mt-4'>";
    echo "<table class='table table-hover'>"; // Table avec un effet survol
    echo "<thead class='thead-light'>";
    echo "<tr>
            <th>Image</th>
            <th>Parfum</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Actions</th>
          </tr>";
    echo "</thead><tbody>";

    // Parcours des articles du panier
    foreach ($_SESSION["panier"] as $parfumId => $quantite) {
        $parfum = Parfum::getById($parfumId); // Récupération des infos du parfum depuis la base de données

        if ($parfum) {
            echo "<tr>";
            // Affichage de l'image du parfum
            echo "<td>
                    <img src='images/" . ($parfum->getImage()) . "' 
                         alt='" . ($parfum->getNom()) . "'
                         class='cart-image'>
                  </td>";
            
            // Affichage du nom et de la description du parfum
            echo "<td>
                  <h5>" . ($parfum->getNom()) . "</h5>
                  <small class='text-muted'>" . ($parfum->getDescription()) . "</small>
                </td>";

            // Gestion du prix et affichage (prix normal ou promotionnel)
            $prix = $parfum->getPrixPromo() ? $parfum->getPrixPromo() : $parfum->getPrix();
            echo "<td>";
            if ($parfum->getPrixPromo()) {
                // Affichage du prix barré et du prix promo en rouge
                echo "<del class='text-muted'>" . number_format($parfum->getPrix(), 2) . " €</del><br>";
                echo "<span class='text-danger'>" . number_format($parfum->getPrixPromo(), 2) . " €</span>";
            } else {
                echo number_format($parfum->getPrix(), 2) . " €";
            }
            echo "</td>";

            // Affichage de la quantité du parfum sélectionné
            echo "<td>$quantite</td>";

            // Affichage des actions : supprimer un article ou passer commande
            echo "<td class='d-flex'>
                    <form method='POST' action='delete.php' class='mr-2'>
                        <input type='hidden' name='parfum_id' value='$parfumId'>
                        <button type='submit' class='btn btn-danger btn-sm'>
                            <i class='fas fa-trash'></i> Supprimer
                        </button>
                    </form>
                    <a href='validation-commande.php' class='btn btn-success btn-sm'>
                        <i class='fas fa-shopping-cart'></i> Commander
                    </a>
                  </td>";
        }
    }

    echo "</tbody></table>";
    echo "</div>";
} else {
    // Si le panier est vide, affichage d'un message et d'un lien pour voir les parfums
    echo "<div class='container mt-4' style='text-align: center; margin-top: 20px;'>
            <div style='background-color: #cce5ff; color: #004085; padding: 15px; border-radius: 4px; margin-bottom: 20px;'>
                Votre panier est vide.
            </div>
            <a href='index.php' style='background-color: #007bff; color: white; text-decoration: none; padding: 12px 25px; border-radius: 4px; display: inline-block;'>
                <i class='fas fa-shopping-bag' style='margin-right: 8px;'></i> Voir les parfums
            </a>
          </div>";
}

// Inclusion du pied de page
require_once "../template/footer.php";
?>
