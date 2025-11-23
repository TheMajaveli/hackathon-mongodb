<?php
// Tâche Dev 3

require_once __DIR__ . '/../../config/database.php';

class FollowSeeder {
    private $db;
    private $collection;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->collection = $this->db->getCollection('Follows');
    }

    public function run($userIds = []) {
        // Nettoyer la collection
        $this->collection->deleteMany([]);

        if (empty($userIds) || count($userIds) < 2) {
            echo "⚠️  FollowSeeder nécessite au moins 2 userIds. Ignoré.\n";
            return;
        }

        // Créer 300 relations de suivi
        $followsCreated = 0;
        $maxFollows = 300;

        for ($i = 0; $i < $maxFollows; $i++) {
            // Sélectionner deux utilisateurs différents
            $followerId = $userIds[array_rand($userIds)];
            $followingId = $userIds[array_rand($userIds)];

            // Éviter qu'un utilisateur se suive lui-même
            if ($followerId === $followingId) {
                continue;
            }

            $follow = [
                'follower_id' => $followerId,      // Celui qui suit
                'following_id' => $followingId,    // Celui qui est suivi
                'date' => date('Y-m-d H:i:s', strtotime('-' . rand(0, 60) . ' days'))
            ];

            try {
                // L'index unique empêchera les doublons (même follower + même following)
                $this->collection->insertOne($follow);
                $followsCreated++;
            } catch (Exception $e) {
                // Ignorer les erreurs de doublons (index unique)
                // Continuer pour créer d'autres follows
            }
        }

        echo "✓ $followsCreated relations de suivi créées.\n";
    }
}
