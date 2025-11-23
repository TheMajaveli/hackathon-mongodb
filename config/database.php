<?php
// Tâche Dev 1

require_once __DIR__ . '/../vendor/autoload.php';

class Database {
    private static $instance = null;
    private $client;
    private $db;

    private function __construct() {
        try {
            // Connexion à MongoDB Atlas ou local
            //$uri = "mongodb+srv://baptjeux59_db_user:su4bOVyuc8cuhP9B@hackathon-mongodb.tgcipl8.mongodb.net/"; 
            $connectionString = getenv('MONGODB_URI') ?: 'mongodb://localhost:27017';
            $this->client = new MongoDB\Client($connectionString);
            $this->db = $this->client->selectDatabase('social_network');
        } catch (Exception $e) {
            die("Erreur de connexion à MongoDB: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getCollection($collectionName) {
        return $this->db->selectCollection($collectionName);
    }

    public function getClient() {
        return $this->client;
    }
}

