<?php

require_once __DIR__ . '/../config/database.php';

class Post {
    private $collection;
    private $commentsCollection;
    private $likesCollection;

    public function __construct() {
        $db = Database::getInstance();
        $this->collection = $db->getCollection('Posts');
        $this->commentsCollection = $db->getCollection('Comments');
        $this->likesCollection = $db->getCollection('Likes');
    }

    public function create($data) {
        if (empty($data['content']) || !isset($data['category_id']) || !isset($data['user_id'])) {
            return ['success' => false, 'message' => 'Content, category_id et user_id sont requis'];
        }

        $post = [
            'content' => $data['content'],
            'category_id' => (int)$data['category_id'],
            'user_id' => (int)$data['user_id'],
            'date' => isset($data['date']) ? $data['date'] : date('Y-m-d H:i:s')
        ];

        $result = $this->collection->insertOne($post);
        $post['_id'] = $result->getInsertedId();

        return ['success' => true, 'data' => $post];
    }

    public function getAll() {
        $posts = $this->collection->find()->toArray();
        return ['success' => true, 'data' => $posts];
    }

    public function getById($id) {
        try {
            $post = $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if (!$post) {
                return ['success' => false, 'message' => 'Post non trouvé'];
            }
            return ['success' => true, 'data' => $post];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function update($id, $data) {
        try {
            $updateData = [];
            if (isset($data['content'])) $updateData['content'] = $data['content'];
            if (isset($data['category_id'])) $updateData['category_id'] = (int)$data['category_id'];
            if (isset($data['user_id'])) $updateData['user_id'] = (int)$data['user_id'];
            if (isset($data['date'])) $updateData['date'] = $data['date'];

            if (empty($updateData)) {
                return ['success' => false, 'message' => 'Aucune donnée à mettre à jour'];
            }

            $result = $this->collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($id)],
                ['$set' => $updateData]
            );

            if ($result->getMatchedCount() === 0) {
                return ['success' => false, 'message' => 'Post non trouvé'];
            }

            return ['success' => true, 'message' => 'Post mis à jour'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function delete($id) {
        try {
            $result = $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if ($result->getDeletedCount() === 0) {
                return ['success' => false, 'message' => 'Post non trouvé'];
            }
            return ['success' => true, 'message' => 'Post supprimé'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function getCount() {
        $count = $this->collection->countDocuments();
        return ['success' => true, 'data' => ['count' => $count]];
    }

    public function getLastFive() {
        $posts = $this->collection->find(
            [],
            ['sort' => ['date' => -1], 'limit' => 5]
        )->toArray();
        return ['success' => true, 'data' => $posts];
    }

    public function getPostWithComments($id) {
        try {
            $post = $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if (!$post) {
                return ['success' => false, 'message' => 'Post non trouvé'];
            }

            $postIdString = (string)$post['_id'];
            $comments = $this->commentsCollection->find(['post_id' => $postIdString])->toArray();
            $post['comments'] = $comments;

            return ['success' => true, 'data' => $post];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function getPostsWithoutComments() {
        $allPosts = $this->collection->find()->toArray();
        $postsWithoutComments = [];
        
        foreach ($allPosts as $post) {
            $postId = (string)$post['_id'];
            $hasComments = $this->commentsCollection->countDocuments(['post_id' => $postId]) > 0;
            if (!$hasComments) {
                $postsWithoutComments[] = $post;
            }
        }

        return ['success' => true, 'data' => $postsWithoutComments];
    }

    public function searchByWord($word) {
        $posts = $this->collection->find([
            'content' => ['$regex' => $word, '$options' => 'i']
        ])->toArray();
        return ['success' => true, 'data' => $posts];
    }

    public function getPostsBeforeDate($date) {
        $posts = $this->collection->find([
            'date' => ['$lt' => $date]
        ])->toArray();
        return ['success' => true, 'data' => $posts];
    }

    public function getPostsAfterDate($date) {
        $posts = $this->collection->find([
            'date' => ['$gt' => $date]
        ])->toArray();
        return ['success' => true, 'data' => $posts];
    }
}

