<?php
// Tâche Dev 1

require_once __DIR__ . '/../../config/database.php';

class CreateUsersCollection {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function up() {
        echo "📝 Création de la collection Users...\n";
        $collection = $this->db->getCollection('Users');
        
        // Créer des index pour améliorer les performances
        try {
            // Index unique sur username
            $collection->createIndex(['username' => 1], ['unique' => true, 'sparse' => true]);
            echo "  ✓ Index unique créé sur 'username'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index username: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index unique sur email
            $collection->createIndex(['email' => 1], ['unique' => true, 'sparse' => true]);
            echo "  ✓ Index unique créé sur 'email'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index email: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index sur is_active pour les requêtes de filtrage
            $collection->createIndex(['is_active' => 1]);
            echo "  ✓ Index créé sur 'is_active'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index is_active: " . $e->getMessage() . "\n";
        }
        
        echo "  ✓ Collection Users créée\n\n";
    }
    
    public function down() {
        echo "🗑️  Suppression de la collection Users...\n";
        $collection = $this->db->getCollection('Users');
        $collection->drop();
        echo "  ✓ Collection Users supprimée\n\n";
    }
}

