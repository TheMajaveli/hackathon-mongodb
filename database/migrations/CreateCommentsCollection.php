<?php
// Tâche Dev 3

require_once __DIR__ . '/../../config/database.php';

class CreateCommentsCollection {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function up() {
        echo "📝 Création de la collection Comments...\n";
        $collection = $this->db->getCollection('Comments');
        
        try {
            // Index sur post_id pour les requêtes de filtrage (trouver tous les commentaires d'un post)
            $collection->createIndex(['post_id' => 1]);
            echo "  ✓ Index créé sur 'post_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index post_id: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index sur user_id pour les requêtes de filtrage (trouver tous les commentaires d'un utilisateur)
            $collection->createIndex(['user_id' => 1]);
            echo "  ✓ Index créé sur 'user_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index user_id: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index composé sur post_id et date pour optimiser les requêtes de tri
            $collection->createIndex(['post_id' => 1, 'date' => 1]);
            echo "  ✓ Index composé créé sur 'post_id' et 'date'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index composé: " . $e->getMessage() . "\n";
        }
        
        echo "  ✓ Collection Comments créée\n\n";
    }
    
    public function down() {
        echo "🗑️  Suppression de la collection Comments...\n";
        $collection = $this->db->getCollection('Comments');
        $collection->drop();
        echo "  ✓ Collection Comments supprimée\n\n";
    }
}
