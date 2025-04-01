<?php
// Ce fichier contient la logique pour gérer les commandes dans notre application
namespace App\Models;

// On importe les classes dont on a besoin pour faire fonctionner notre code
use App\manager\BaseModel;
use App\manager\Database;
use PDOException;

// Cette classe hérite des fonctionnalités de BaseModel pour gérer les commandes
class Commande extends BaseModel
{
    private $id;
    private $utilisateurId;
    private $parfumId;
    private $quantite;
    private $total;
    private $dateCommande;
    private $adresseLivraison;
    private $telephone;
    private $email;
    // On appelle le constructeur parent pour initialiser la connexion
    public function __construct(
        $id = null,
        $utilisateurId = null,
        $parfumId = null,
        $quantite = null,
        $total = null,
        $dateCommande = null,
        $adresseLivraison = null,
        $telephone = null,
        $email = null
    ) {
        parent::__construct();
        $this->id = $id;
        $this->utilisateurId = $utilisateurId;
        $this->parfumId = $parfumId;
        $this->quantite = $quantite;
        $this->total = $total;
        $this->dateCommande = $dateCommande;
        $this->adresseLivraison = $adresseLivraison;
        $this->telephone = $telephone;
        $this->email = $email;
    }
    //getters

    public function getId()
    {
        return $this->id;
    }
    /**
     * Get the value of utilisateurId
     */
    public function getUtilisateurId()
    {
        return $this->utilisateurId;
    }

    /**
     * Set the value of utilisateurId
     *
     * @return  self
     */
    public function setUtilisateurId($utilisateurId)
    {
        $this->utilisateurId = $utilisateurId;

        return $this;
    }

    /**
     * Get the value of parfumId
     */
    public function getParfumId()
    {
        return $this->parfumId;
    }

    /**
     * Set the value of parfumId
     *
     * @return  self
     */
    public function setParfumId($parfumId)
    {
        $this->parfumId = $parfumId;

        return $this;
    }

    /**
     * Get the value of quantite
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set the value of quantite
     *
     * @return  self
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get the value of total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the value of total
     *
     * @return  self
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get the value of dateCommande
     */
    public function getDateCommande()
    {
        return $this->dateCommande;
    }

    /**
     * Set the value of dateCommande
     *
     * @return  self
     */
    public function setDateCommande($dateCommande)
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    /**
     * Get the value of adresseLivraison
     */
    public function getAdresseLivraison()
    {
        return $this->adresseLivraison;
    }

    /**
     * Set the value of adresseLivraison
     *
     * @return  self
     */
    public function setAdresseLivraison($adresseLivraison)
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    /**
     * Get the value of telephone
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     *
     * @return  self
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    // Cette fonction récupère toutes les commandes de la base de données
    public static function getAll()
    {
        try {
            $pdo = Database::connect();
            $query = $pdo->query("SELECT * FROM commandes");
            $results = $query->fetchAll();

            // On transforme les résultats en objets Commande
            $commandes = [];
            foreach ($results as $row) {
                $commandes[] = new self(
                    $row['id'] ?? null,
                    $row['utilisateur_id'] ?? null,
                    $row['parfum_id'] ?? null,
                    $row['quantite'] ?? null,
                    $row['total'] ?? null,
                    $row['date_commande'] ?? null,
                    $row['adresse_livraison'] ?? null,
                    $row['telephone'] ?? null,
                    $row['email'] ?? null
                );
            }

            return $commandes;
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la récupération des commandes : " . $e->getMessage());
        }
    }

    // Nouvelle méthode pour sauvegarder une commande
    public function save()
    {
        try {
            $pdo = Database::connect();
            $query = $pdo->prepare("
                INSERT INTO commandes (
                    utilisateur_id, parfum_id, quantite, total,
                    adresse_livraison, telephone, email
                ) VALUES (
                    :utilisateur_id, :parfum_id, :quantite, :total,
                    :adresse_livraison, :telephone, :email
                )
            ");

            return $query->execute([
                ':utilisateur_id' => $this->utilisateurId,
                ':parfum_id' => $this->parfumId,
                ':quantite' => $this->quantite,
                ':total' => $this->total,
                ':adresse_livraison' => $this->adresseLivraison,
                ':telephone' => $this->telephone,
                ':email' => $this->email
            ]);
        } catch (PDOException $e) {
            throw new \Exception("Erreur lors de la création de la commande : " . $e->getMessage());
        }
    }
}
