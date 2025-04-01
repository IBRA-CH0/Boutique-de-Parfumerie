<?php
// Ce fichier contient la logique pour gérer les catégories dans notre application
namespace App\Models;

// On importe les classes dont on a besoin pour faire fonctionner notre code
use App\manager\BaseModel;
use App\manager\Database;
use PDOException;

// Cette classe hérite des fonctionnalités de BaseModel pour gérer les catégories
class Categorie extends BaseModel
{
    private $id;
    private $nom;

    // Cette fonction crée une nouvelle catégorie avec un id et un nom optionnels
    public function __construct($id = null, $nom = null)
    {
        parent::__construct();
        $this->id = $id;
        $this->nom = $nom;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    // Setters

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    // Cette fonction récupère toutes les catégories de la base de données
    public static function getAll()
    {
        // On se connecte à la base de données pour récupérer les informations des categories
        try {
            $pdo = Database::connect();
            $query = $pdo->query("SELECT * FROM categories");
            $results = $query->fetchAll();

            // On transforme les résultats en objets Categorie
            $categories = [];
            foreach ($results as $row) {
                $categories[] = new self(
                    $row['id'] ?? null,
                    $row['nom'] ?? null
                );
            }

            return $categories;
        } catch (PDOException $e) {
            // En cas d'erreur, on lance une exception avec un message explicatif
            throw new \Exception("Erreur lors de la récupération des catégories : " . $e->getMessage());
        }
    }
}
