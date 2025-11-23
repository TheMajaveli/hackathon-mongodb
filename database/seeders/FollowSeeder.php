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

        // Créer exactement 250 relations de suivi
        $followsCreated = 0;
        $maxFollows = 250;
        $maxAttempts = 10000; // Limite de sécurité pour éviter les boucles infinies
        $attempts = 0;

        while ($followsCreated < $maxFollows && $attempts < $maxAttempts) {
            // Sélectionner deux utilisateurs différents
            $followerId = $userIds[array_rand($userIds)];
            $followingId = $userIds[array_rand($userIds)];

            // Éviter qu'un utilisateur se suive lui-même
            if ($followerId === $followingId) {
                $attempts++;
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
            
            $attempts++;
        }

        if ($followsCreated < $maxFollows) {
            echo "⚠️  Seulement $followsCreated relations de suivi créées sur $maxFollows demandées (trop de doublons après $attempts tentatives).\n";
        } else {
            echo "✓ $followsCreated relations de suivi créées.\n";
        }
    }
}
