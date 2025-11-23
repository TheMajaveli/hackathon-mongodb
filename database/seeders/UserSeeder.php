<?php
// Tâche Dev 1

require_once __DIR__ . '/../../config/database.php';

class UserSeeder {
    private $db;
    private $collection;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->collection = $this->db->getCollection('Users');
    }

    public function run() {
        // Nettoyer la collection
        $this->collection->deleteMany([]);

        // Créer 100 utilisateurs
        $userIds = [];
        for ($i = 1; $i <= 100; $i++) {
            $user = [
                'username' => 'user' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'is_active' => $i <= 95 // 95 actifs, 5 inactifs
            ];
            $result = $this->collection->insertOne($user);
            $userIds[] = (string)$result->getInsertedId();
        }

        echo "✓ 100 utilisateurs créés.\n";
        return $userIds;
    }
}

