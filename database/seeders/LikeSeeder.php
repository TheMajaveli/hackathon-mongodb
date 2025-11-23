<?php
// Tâche Dev 3

require_once __DIR__ . '/../../config/database.php';

class LikeSeeder {
    private $db;
    private $collection;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->collection = $this->db->getCollection('Likes');
    }

    public function run($userIds = [], $postIds = []) {
        // Nettoyer la collection
        $this->collection->deleteMany([]);

        if (empty($userIds) || empty($postIds)) {
            echo "⚠️  LikeSeeder nécessite des userIds et postIds. Ignoré.\n";
            return;
        }

        // Créer 800 likes (certains utilisateurs peuvent liker plusieurs posts)
        $likesCreated = 0;
        $maxLikes = 800;

        for ($i = 0; $i < $maxLikes; $i++) {
            // Sélectionner aléatoirement un utilisateur et un post
            $randomUserId = $userIds[array_rand($userIds)];
            $randomPostId = $postIds[array_rand($postIds)];

            $like = [
                'user_id' => $randomUserId,
                'post_id' => $randomPostId,
                'date' => date('Y-m-d H:i:s', strtotime('-' . rand(0, 15) . ' days'))
            ];

            try {
                // L'index unique empêchera les doublons (même user + même post)
                $this->collection->insertOne($like);
                $likesCreated++;
            } catch (Exception $e) {
                // Ignorer les erreurs de doublons (index unique)
                // Continuer pour créer d'autres likes
            }
        }

        echo "✓ $likesCreated likes créés.\n";
    }
}
