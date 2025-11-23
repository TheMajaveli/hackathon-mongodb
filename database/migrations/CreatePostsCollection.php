<?php

require_once __DIR__ . '/../../config/database.php';

class CreatePostsCollection {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function up() {
        echo "📝 Création de la collection Posts...\n";
        $collection = $this->db->getCollection('Posts');
        
        try {
            // Index sur user_id pour les requêtes de filtrage
            $collection->createIndex(['user_id' => 1]);
            echo "  ✓ Index créé sur 'user_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index user_id: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index sur category_id pour les requêtes de filtrage
            $collection->createIndex(['category_id' => 1]);
            echo "  ✓ Index créé sur 'category_id'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index category_id: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index sur date pour le tri (last-five, before-date, after-date)
            $collection->createIndex(['date' => -1]);
            echo "  ✓ Index créé sur 'date' (tri décroissant)\n";
        } catch (Exception $e) {
            echo "  ⚠ Index date: " . $e->getMessage() . "\n";
        }
        
        try {
            // Index de texte pour la recherche (search)
            $collection->createIndex(['content' => 'text']);
            echo "  ✓ Index de texte créé sur 'content'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index texte: " . $e->getMessage() . "\n";
        }
        
        echo "  ✓ Collection Posts créée\n\n";
    }
    
    public function down() {
        echo "🗑️  Suppression de la collection Posts...\n";
        $collection = $this->db->getCollection('Posts');
        $collection->drop();
        echo "  ✓ Collection Posts supprimée\n\n";
    }
}

