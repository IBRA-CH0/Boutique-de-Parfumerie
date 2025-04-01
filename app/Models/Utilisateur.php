<?php
// Ce fichier contient la logique pour gérer les utilisateurs
namespace App\Models;

// On importe les classes nécessaires pour notre code
use App\manager\BaseModel;
use App\manager\Database;
use PDOException;

// Cette classe hérite de BaseModel pour gérer les utilisateurs
class Utilisateur extends BaseModel
{
    // Ces variables stockent les informations privées d'un utilisateur
    private $id;
    private $nom;
    private $prenom; 

    private $email;
    private $motDePasse;

    // Cette fonction crée un nouvel utilisateur avec des valeurs optionnelles
    public function __construct($id = null, $nom = null,$prenom = null, $email = null, $motDePasse = null)
    {
        parent::__construct();
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
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
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    public function getPrenom()
    {
        return $this->prenom;
    }
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }
    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;
    }

    // Cette fonction récupère tous les utilisateurs de la base de données
    public static function getAll()
    {
        try {
            // On se connecte à la base de données pour recupérer les informations de la table utilisateurs 
            $pdo = Database::connect();
            $query = $pdo->query("SELECT * FROM utilisateurs");
            $results = $query->fetchAll();

            // On transforme les résultats en objets Utilisateur
            $utilisateurs = [];
            foreach ($results as $row) {
                $utilisateurs[] = new self(
                    $row['id'] ?? null,
                    $row['nom'] ?? null,
                    $row['prenom'] ?? null,  
                    $row['email'] ?? null,
                    $row['mot_de_passe'] ?? null
                );
            }

            return $utilisateurs;
        } catch (PDOException $e) {
            // En cas d'erreur, on lance une exception
            throw new \Exception("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
        }
    }
}