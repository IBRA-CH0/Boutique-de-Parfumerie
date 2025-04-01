<?php
// Ce namespace permet d'organiser le code dans le dossier app/manager
namespace App\manager;


// Cette classe sert de modèle de base pour gérer nos données
//elle contient une propriete pdo qui est une instance de PDO
// et qui est initialisee dans le constructeur
// grace a la methode connect de la classe database
class BaseModel
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }
}
