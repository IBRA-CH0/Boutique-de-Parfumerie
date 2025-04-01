<?php
// Déclaration du namespace pour organiser le code
namespace App\manager;

// Importation des classes nécessaires
use PDO;
use PDOException;

class Database
{
    // Définition des paramètres de connexion à la base de données
    private static $host = 'localhost';   
    private static $dbName = 'ecommerce'; 
    private static $username = 'root';    
    private static $password = '';

    /**
     * Méthode pour établir une connexion à la base de données
     * @return PDO
     * @throws \Exception
     */
    public static function connect()
    {
        try {
            // Création d'une nouvelle instance de PDO pour la connexion à la base de données
            $pdo = new PDO(
                "mysql:host=" . self::$host . ";dbname=" . self::$dbName . ";charset=utf8",
                self::$username,
                self::$password
            );
            // Configuration du mode d'affichage des erreurs pour lever des exceptions en cas de problème
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Retourne l'objet PDO pour exécuter des requêtes SQL
            return $pdo;
        } catch (PDOException $e) {
            // En cas d'erreur, une exception est levée avec un message personnalisé
            throw new \Exception("Erreur de connexion : " . $e->getMessage());
        }
    }
}