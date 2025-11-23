<?php
// Tâche Dev 3

require_once __DIR__ . '/../../config/database.php';

class CommentSeeder {
    private $db;
    private $collection;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->collection = $this->db->getCollection('Comments');
    }

    public function run($userIds = [], $postIds = []) {
        // Nettoyer la collection
        $this->collection->deleteMany([]);

        if (empty($userIds) || empty($postIds)) {
            echo "⚠️  CommentSeeder nécessite des userIds et postIds. Ignoré.\n";
            return;
        }

        // Créer 500 commentaires
        $comments = [
            'Excellent article !',
            'Je suis totalement d\'accord.',
            'Merci pour ce partage.',
            'Très intéressant, merci !',
            'Je vais essayer ça.',
            'Super contenu !',
            'Bravo pour ce travail.',
            'C\'est vraiment utile.',
            'J\'adore cette approche.',
            'Merci pour les conseils.'
        ];

        for ($i = 1; $i <= 500; $i++) {
            // Sélectionner aléatoirement un utilisateur et un post
            $randomUserId = $userIds[array_rand($userIds)];
            $randomPostId = $postIds[array_rand($postIds)];
            $randomComment = $comments[array_rand($comments)];

            $comment = [
                'user_id' => $randomUserId,
                'post_id' => $randomPostId,
                'content' => $randomComment,
                'date' => date('Y-m-d H:i:s', strtotime('-' . rand(0, 20) . ' days'))
            ];

            $this->collection->insertOne($comment);
        }

        echo "✓ 500 commentaires créés.\n";
    }
}
