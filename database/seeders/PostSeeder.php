<?php

require_once __DIR__ . '/../../config/database.php';

class PostSeeder {
    private $db;
    private $collection;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->collection = $this->db->getCollection('Posts');
    }

    public function run($categoryIds = [], $userIds = []) {
        // Nettoyer la collection
        $this->collection->deleteMany([]);

        $postContents = [
            'Découvrez les dernières innovations technologiques',
            'Mon voyage incroyable en Asie',
            'Recette de lasagnes maison',
            'Entraînement matinal réussi',
            'Nouvel album de musique à écouter',
            'Les meilleurs outils de développement',
            'Plages paradisiaques de Thaïlande',
            'Gâteau au chocolat facile',
            'Course à pied dans la nature',
            'Concert de rock inoubliable',
            'Intelligence artificielle et avenir',
            'Exploration des temples bouddhistes',
            'Pâtes carbonara authentiques',
            'Yoga et méditation quotidienne',
            'Festival de musique électronique',
            'Applications mobiles révolutionnaires',
            'Randonnée en montagne',
            'Tarte aux pommes traditionnelle',
            'Natation en piscine olympique',
            'Découverte de nouveaux artistes',
            'Blockchain et cryptomonnaies',
            'Safari en Afrique',
            'Sushi fait maison',
            'Crossfit et musculation',
            'Jazz et blues',
            'Cloud computing moderne',
            'Voyage en train à travers l\'Europe',
            'Pizza italienne authentique',
            'Cyclisme en ville',
            'Opéra et musique classique',
            'Machine learning avancé',
            'Plongée sous-marine',
            'Desserts français',
            'Basketball professionnel',
            'Hip-hop et rap',
            'Sécurité informatique',
            'Road trip aux USA',
            'Cuisine méditerranéenne',
            'Tennis de compétition',
            'Rock alternatif'
        ];

        $postIds = [];
        $categoryCount = count($categoryIds);
        $userCount = count($userIds);

        for ($i = 0; $i < 40; $i++) {
            $post = [
                'content' => $postContents[$i] ?? 'Post numéro ' . ($i + 1),
                'category_id' => $categoryCount > 0 ? rand(1, min(5, $categoryCount)) : rand(1, 5),
                'user_id' => $userCount > 0 ? rand(1, min(100, $userCount)) : rand(1, 100),
                'date' => date('Y-m-d H:i:s', strtotime('-' . rand(0, 60) . ' days'))
            ];
            $result = $this->collection->insertOne($post);
            $postIds[] = (string)$result->getInsertedId();
        }

        echo "✓ 40 posts créés.\n";
        return $postIds;
    }
}

