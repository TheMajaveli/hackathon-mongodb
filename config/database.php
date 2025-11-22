<?php
// Inclure l'autochargeur de Composer
require __DIR__ . '/../vendor/autoload.php'; 

use MongoDB\Client;

class Database {
    private $client;
    private $database;

    public function __construct() {
        // Remplacez les identifiants si nécessaire
        $uri = "mongodb+srv://baptjeux59_db_user:su4bOVyuc8cuhP9B@hackathon-mongodb.tgcipl8.mongodb.net/"; 
        $dbName = "social_network"; 
        
        try {
            $this->client = new Client($uri);
            $this->database = $this->client->selectDatabase($dbName);
        } catch (Exception $e) {
            die("Erreur de connexion à MongoDB : " . $e->getMessage());
        }
    }

    // Méthode pour obtenir une collection spécifique
    public function getCollection(string $name) {
        return $this->database->selectCollection($name);
    }
}