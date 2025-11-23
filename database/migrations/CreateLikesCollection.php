<?php
// Tâche Dev 3

require_once __DIR__ . '/../../config/database.php';

class CreateLikesCollection {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function up() {
        echo "📝 Création de la collection Likes...\n";
        $collection = $this->db->getCollection('Likes');
        
        try {
            // Index sur post_id pour les requêtes de filtrage (compter les likes d'un post)
            $collection->createIndex(['post_id' => 1]);
            echo "  ✓ Index créé sur 'post_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index post_id: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index sur user_id pour les requêtes de filtrage (trouver tous les likes d'un utilisateur)
            $collection->createIndex(['user_id' => 1]);
            echo "  ✓ Index créé sur 'user_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index user_id: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index unique composé pour éviter les doublons (un utilisateur ne peut liker qu'une fois un post)
            $collection->createIndex(['user_id' => 1, 'post_id' => 1], ['unique' => true]);
            echo "  ✓ Index unique composé créé sur 'user_id' et 'post_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index unique composé: " . $e->getMessage() . "\n";
        }
        
        echo "  ✓ Collection Likes créée\n\n";
    }
    
    public function down() {
        echo "🗑️  Suppression de la collection Likes...\n";
        $collection = $this->db->getCollection('Likes');
        $collection->drop();
        echo "  ✓ Collection Likes supprimée\n\n";
    }
}
