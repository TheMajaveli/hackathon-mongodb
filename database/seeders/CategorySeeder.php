<?php
// Tâche Dev 1

require_once __DIR__ . '/../../config/database.php';

class CategorySeeder {
    private $db;
    private $collection;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->collection = $this->db->getCollection('Categories');
    }

    public function run() {
        // Nettoyer la collection
        $this->collection->deleteMany([]);

        // Créer 5 catégories
        $categories = [
            ['name' => 'Technologie'],
            ['name' => 'Voyage'],
            ['name' => 'Cuisine'],
            ['name' => 'Sport'],
            ['name' => 'Musique']
        ];

        $categoryIds = [];
        foreach ($categories as $category) {
            $result = $this->collection->insertOne($category);
            $categoryIds[] = (string)$result->getInsertedId();
        }

        echo "✓ 5 catégories créées.\n";
        return $categoryIds;
    }
}

