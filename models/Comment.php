<?php
// Tâche Dev 3

require_once __DIR__ . '/../config/database.php';

class Comment {
    private $collection;

    public function __construct() {
        $db = Database::getInstance();
        $this->collection = $db->getCollection('Comments');
    }

    public function create($data) {
        if (empty($data['content']) || !isset($data['post_id']) || !isset($data['user_id'])) {
            return ['success' => false, 'message' => 'Content, post_id et user_id sont requis'];
        }

        $comment = [
            'user_id' => $data['user_id'],
            'post_id' => $data['post_id'],
            'content' => $data['content'],
            'date' => isset($data['date']) ? $data['date'] : date('Y-m-d H:i:s')
        ];

        $result = $this->collection->insertOne($comment);
        $comment['_id'] = $result->getInsertedId();

        return ['success' => true, 'data' => $comment, 'message' => 'Commentaire créé'];
    }

    public function getAll() {
        $comments = $this->collection->find()->toArray();
        return ['success' => true, 'data' => $comments];
    }

    public function getById($id) {
        try {
            $comment = $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if (!$comment) {
                return ['success' => false, 'message' => 'Commentaire non trouvé'];
            }
            return ['success' => true, 'data' => $comment];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function update($id, $data) {
        try {
            $updateData = [];
            if (isset($data['content'])) $updateData['content'] = $data['content'];
            if (isset($data['post_id'])) $updateData['post_id'] = $data['post_id'];
            if (isset($data['user_id'])) $updateData['user_id'] = $data['user_id'];
            if (isset($data['date'])) $updateData['date'] = $data['date'];

            if (empty($updateData)) {
                return ['success' => false, 'message' => 'Aucune donnée à mettre à jour'];
            }

            $result = $this->collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($id)],
                ['$set' => $updateData]
            );

            if ($result->getMatchedCount() === 0) {
                return ['success' => false, 'message' => 'Commentaire non trouvé'];
            }

            return ['success' => true, 'message' => 'Commentaire mis à jour'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function delete($id) {
        try {
            $result = $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if ($result->getDeletedCount() === 0) {
                return ['success' => false, 'message' => 'Commentaire non trouvé'];
            }
            return ['success' => true, 'message' => 'Commentaire supprimé'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function getCountByPostId($postId) {
        try {
            $count = $this->collection->countDocuments(['post_id' => $postId]);
            return ['success' => true, 'data' => ['count' => $count, 'post_id' => $postId]];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors du comptage'];
        }
    }
}
