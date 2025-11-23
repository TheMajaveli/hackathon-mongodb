<?php
// Tâche Dev 3

require_once __DIR__ . '/../config/database.php';

class Like {
    private $collection;

    public function __construct() {
        $db = Database::getInstance();
        $this->collection = $db->getCollection('Likes');
    }

    public function create($data) {
        if (!isset($data['post_id']) || !isset($data['user_id'])) {
            return ['success' => false, 'message' => 'post_id et user_id sont requis'];
        }

        $like = [
            'user_id' => $data['user_id'],
            'post_id' => $data['post_id'],
            'date' => isset($data['date']) ? $data['date'] : date('Y-m-d H:i:s')
        ];

        try {
            $result = $this->collection->insertOne($like);
            $like['_id'] = $result->getInsertedId();
            return ['success' => true, 'data' => $like, 'message' => 'Like créé'];
        } catch (MongoDB\Driver\Exception\BulkWriteException $e) {
            // Gérer les erreurs de doublon (index unique)
            if ($e->getCode() === 11000) {
                return ['success' => false, 'message' => 'Cet utilisateur a déjà liké ce post'];
            }
            return ['success' => false, 'message' => 'Erreur lors de la création'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de la création'];
        }
    }

    public function getAll() {
        $likes = $this->collection->find()->toArray();
        return ['success' => true, 'data' => $likes];
    }

    public function getById($id) {
        try {
            $like = $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if (!$like) {
                return ['success' => false, 'message' => 'Like non trouvé'];
            }
            return ['success' => true, 'data' => $like];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function delete($id) {
        try {
            $result = $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if ($result->getDeletedCount() === 0) {
                return ['success' => false, 'message' => 'Like non trouvé'];
            }
            return ['success' => true, 'message' => 'Like supprimé'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }
}
