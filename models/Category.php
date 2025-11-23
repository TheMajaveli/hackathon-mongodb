<?php
// Tâche Dev 1

require_once __DIR__ . '/../config/database.php';

class Category {
    private $collection;

    public function __construct() {
        $db = Database::getInstance();
        $this->collection = $db->getCollection('Categories');
    }

    public function create($data) {
        if (empty($data['name'])) {
            return ['success' => false, 'message' => 'Le nom de la catégorie est requis'];
        }

        $category = [
            'name' => $data['name']
        ];

        $result = $this->collection->insertOne($category);
        $category['_id'] = $result->getInsertedId();

        return ['success' => true, 'data' => $category];
    }

    public function getAll() {
        $categories = $this->collection->find()->toArray();
        return ['success' => true, 'data' => $categories];
    }

    public function getById($id) {
        try {
            $category = $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if (!$category) {
                return ['success' => false, 'message' => 'Catégorie non trouvée'];
            }
            return ['success' => true, 'data' => $category];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function update($id, $data) {
        try {
            if (empty($data['name'])) {
                return ['success' => false, 'message' => 'Le nom de la catégorie est requis'];
            }

            $result = $this->collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($id)],
                ['$set' => ['name' => $data['name']]]
            );

            if ($result->getMatchedCount() === 0) {
                return ['success' => false, 'message' => 'Catégorie non trouvée'];
            }

            return ['success' => true, 'message' => 'Catégorie mise à jour'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function delete($id) {
        try {
            $result = $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if ($result->getDeletedCount() === 0) {
                return ['success' => false, 'message' => 'Catégorie non trouvée'];
            }
            return ['success' => true, 'message' => 'Catégorie supprimée'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function getAverageLikesByCategory($categoryId) {
        try {
            $db = Database::getInstance();
            $postsCollection = $db->getCollection('Posts');
            $likesCollection = $db->getCollection('Likes');

            // Récupérer tous les posts de cette catégorie
            $posts = $postsCollection->find(['category_id' => (int)$categoryId])->toArray();
            
            if (empty($posts)) {
                return ['success' => true, 'data' => ['average' => 0, 'category_id' => $categoryId]];
            }

            $totalLikes = 0;
            $postsWithLikes = 0;

            foreach ($posts as $post) {
                $postId = (string)$post['_id'];
                $likesCount = $likesCollection->countDocuments(['post_id' => $postId]);
                $totalLikes += $likesCount;
                if ($likesCount > 0) {
                    $postsWithLikes++;
                }
            }

            $average = count($posts) > 0 ? $totalLikes / count($posts) : 0;

            return [
                'success' => true,
                'data' => [
                    'average' => round($average, 2),
                    'category_id' => $categoryId,
                    'total_posts' => count($posts),
                    'total_likes' => $totalLikes
                ]
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors du calcul'];
        }
    }
}

