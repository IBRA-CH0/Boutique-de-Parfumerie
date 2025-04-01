<?php
// Ce fichier gère toutes les opérations liées aux parfums
namespace App\Models;

// On importe les outils nécessaires pour la base de données
use App\manager\BaseModel;
use App\manager\Database;
use PDOException;
use PDO;

// Cette classe permet de gérer les parfums dans notre application
class Parfum extends BaseModel
{
    private ?int $id;
    private ?string $nom;
    private ?string $description;
    private ?float $prix;
    private ?float $prixPromo;
    private ?string $image;
    private ?int $categorieId;

    // Cette fonction crée un nouveau parfum avec des valeurs optionnelles
    public function __construct(
        ?int $id = null,
        ?string $nom = null,
        ?string $description = null,
        ?float $prix = null,
        ?float $prixPromo = null,
        ?string $image = null,
        ?int $categorieId = null
    ) {
        parent::__construct();
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
        $this->prixPromo = $prixPromo;
        $this->image = $image;
        $this->categorieId = $categorieId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    public function getPrixPromo(): ?float
    {
        return $this->prixPromo;
    }

    public function setPrixPromo(?float $prixPromo): self
    {
        $this->prixPromo = $prixPromo;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getCategorieId(): ?int
    {
        return $this->categorieId;
    }

    public function setCategorieId(?int $categorieId): self
    {
        $this->categorieId = $categorieId;
        return $this;
    }

    public static function getById(int $id): ?self
    {
        try {
            $pdo = Database::connect();
            $requete = $pdo->prepare("SELECT * FROM parfums WHERE id = :id");
            $requete->execute([':id' => $id]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);

            if (!$resultat) {
                return null;
            }

            return new self(
                $resultat['id'],
                $resultat['nom'],
                $resultat['description'],
                $resultat['prix'],
                $resultat['prix_promo'],
                $resultat['image'],
                $resultat['categorie_id']
            );
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la récupération du parfum : " . $e->getMessage());
        }
    }

    public static function getAll(): array
    {
        try {
            $pdo = Database::connect();
            $requete = $pdo->query("SELECT * FROM parfums ORDER BY nom");
            $parfums = [];

            while ($resultat = $requete->fetch(PDO::FETCH_ASSOC)) {
                $parfums[] = new self(
                    $resultat['id'],
                    $resultat['nom'],
                    $resultat['description'],
                    $resultat['prix'],
                    $resultat['prix_promo'],
                    $resultat['image'],
                    $resultat['categorie_id']
                );
            }

            return $parfums;
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la récupération des parfums : " . $e->getMessage());
        }
    }

    public static function getByCategory(int $categorieId): array
    {
        try {
            $pdo = Database::connect();
            $requete = $pdo->prepare("SELECT * FROM parfums WHERE categorie_id = :categorie_id ORDER BY nom");
            $requete->execute([':categorie_id' => $categorieId]);
            $parfums = [];

            while ($resultat = $requete->fetch(PDO::FETCH_ASSOC)) {
                $parfums[] = new self(
                    $resultat['id'],
                    $resultat['nom'],
                    $resultat['description'],
                    $resultat['prix'],
                    $resultat['prix_promo'],
                    $resultat['image'],
                    $resultat['categorie_id']
                );
            }

            return $parfums;
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la récupération des parfums par catégorie : " . $e->getMessage());
        }
    }

    public function save(): bool
    {
        try {
            $pdo = Database::connect();

            if ($this->id) {
                $requete = $pdo->prepare(
                    "UPDATE parfums 
                     SET nom = :nom,
                         description = :description,
                         prix = :prix,
                         prix_promo = :prix_promo,
                         image = :image,
                         categorie_id = :categorie_id
                     WHERE id = :id"
                );
                $requete->execute([
                    ':nom' => $this->nom,
                    ':description' => $this->description,
                    ':prix' => $this->prix,
                    ':prix_promo' => $this->prixPromo,
                    ':image' => $this->image,
                    ':categorie_id' => $this->categorieId,
                    ':id' => $this->id
                ]);
            } else {
                $requete = $pdo->prepare(
                    "INSERT INTO parfums (nom, description, prix, prix_promo, image, categorie_id)
                     VALUES (:nom, :description, :prix, :prix_promo, :image, :categorie_id)"
                );
                $requete->execute([
                    ':nom' => $this->nom,
                    ':description' => $this->description,
                    ':prix' => $this->prix,
                    ':prix_promo' => $this->prixPromo,
                    ':image' => $this->image,
                    ':categorie_id' => $this->categorieId
                ]);
                $this->id = $pdo->lastInsertId();
            }

            return true;
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la sauvegarde du parfum : " . $e->getMessage());
        }
    }

    public function delete(): bool
    {
        if (!$this->id) {
            throw new \Exception("Impossible de supprimer un parfum sans ID");
        }

        try {
            $pdo = Database::connect();
            $requete = $pdo->prepare("DELETE FROM parfums WHERE id = :id");
            return $requete->execute([':id' => $this->id]);
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la suppression du parfum : " . $e->getMessage());
        }
    }

    public static function search(string $term): array
    {
        try {
            $pdo = Database::connect();
            $requete = $pdo->prepare(
                "SELECT * FROM parfums 
                 WHERE nom LIKE :term OR description LIKE :term
                 ORDER BY nom"
            );
            $searchTerm = "%$term%";
            $requete->execute([':term' => $searchTerm]);
            $parfums = [];

            while ($resultat = $requete->fetch(PDO::FETCH_ASSOC)) {
                $parfums[] = new self(
                    $resultat['id'],
                    $resultat['nom'],
                    $resultat['description'],
                    $resultat['prix'],
                    $resultat['prix_promo'],
                    $resultat['image'],
                    $resultat['categorie_id']
                );
            }

            return $parfums;
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la recherche des parfums : " . $e->getMessage());
        }
    }
}
