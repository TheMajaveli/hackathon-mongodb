<?php
// Tâche Dev 1


require_once __DIR__ . '/../../config/database.php';

class CreateCategoriesCollection {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function up() {
        echo "📝 Création de la collection Categories...\n";
        $collection = $this->db->getCollection('Categories');
        
        try {
            // Index unique sur name
            $collection->createIndex(['name' => 1], ['unique' => true, 'sparse' => true]);
            echo "  ✓ Index unique créé sur 'name'\n";
        } catch (Exception $e) {
            echo "  ⚠ Index name: " . $e->getMessage() . "\n";
        }
        
        echo "  ✓ Collection Categories créée\n\n";
    }
    
    public function down() {
        echo "🗑️  Suppression de la collection Categories...\n";
        $collection = $this->db->getCollection('Categories');
        $collection->drop();
        echo "  ✓ Collection Categories supprimée\n\n";
    }
}

