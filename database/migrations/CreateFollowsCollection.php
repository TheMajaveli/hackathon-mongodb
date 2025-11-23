<?php
// Tâche Dev 3

require_once __DIR__ . '/../../config/database.php';

class CreateFollowsCollection {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function up() {
        echo "📝 Création de la collection Follows...\n";
        $collection = $this->db->getCollection('Follows');
        
        try {
            // Index sur follower_id (celui qui suit) pour les requêtes de filtrage
            $collection->createIndex(['follower_id' => 1]);
            echo "  ✓ Index créé sur 'follower_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index follower_id: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index sur following_id (celui qui est suivi) pour les requêtes de filtrage
            $collection->createIndex(['following_id' => 1]);
            echo "  ✓ Index créé sur 'following_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index following_id: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index unique composé pour éviter les doublons (un utilisateur ne peut suivre qu'une fois un autre utilisateur)
            $collection->createIndex(['follower_id' => 1, 'following_id' => 1], ['unique' => true]);
            echo "  ✓ Index unique composé créé sur 'follower_id' et 'following_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index unique composé: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index pour éviter qu'un utilisateur se suive lui-même (optionnel, géré au niveau applicatif)
            // Index composé pour optimiser les requêtes de comptage
            $collection->createIndex(['following_id' => 1, 'follower_id' => 1]);
            echo "  ✓ Index composé créé pour optimiser les requêtes\n";
        } catch (Exception $e) {
            echo "  ⚠ Index composé: " . $e->getMessage() . "\n";
        }
        
        echo "  ✓ Collection Follows créée\n\n";
    }
    
    public function down() {
        echo "🗑️  Suppression de la collection Follows...\n";
        $collection = $this->db->getCollection('Follows');
        $collection->drop();
        echo "  ✓ Collection Follows supprimée\n\n";
    }
}
