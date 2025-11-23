<?php
// Tâche Dev 1

require_once __DIR__ . '/../config/database.php';

class User {
    private $collection;

    public function __construct() {
        $db = Database::getInstance();
        $this->collection = $db->getCollection('Users');
    }

    public function create($data) {
        // Validation
        if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            return ['success' => false, 'message' => 'Username, email et password sont requis'];
        }

        // Vérifier si l'utilisateur existe déjà
        $existing = $this->collection->findOne([
            '$or' => [
                ['username' => $data['username']],
                ['email' => $data['email']]
            ]
        ]);

        if ($existing) {
            return ['success' => false, 'message' => 'Username ou email déjà utilisé'];
        }

        $user = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'is_active' => isset($data['is_active']) ? (bool)$data['is_active'] : true
        ];

        $result = $this->collection->insertOne($user);
        $user['_id'] = $result->getInsertedId();
        unset($user['password']);

        return ['success' => true, 'data' => $user];
    }

    public function getAll($page = 1, $limit = 10) {
        $skip = ($page - 1) * $limit;
        $users = $this->collection->find(
            [],
            [
                'projection' => ['password' => 0],
                'skip' => $skip,
                'limit' => $limit
            ]
        )->toArray();

        return ['success' => true, 'data' => $users];
    }

    public function getById($id) {
        try {
            $user = $this->collection->findOne(
                ['_id' => new MongoDB\BSON\ObjectId($id)],
                ['projection' => ['password' => 0]]
            );
            if (!$user) {
                return ['success' => false, 'message' => 'Utilisateur non trouvé'];
            }
            return ['success' => true, 'data' => $user];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function update($id, $data) {
        try {
            $updateData = [];
            if (isset($data['username'])) $updateData['username'] = $data['username'];
            if (isset($data['email'])) $updateData['email'] = $data['email'];
            if (isset($data['password'])) $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            if (isset($data['is_active'])) $updateData['is_active'] = (bool)$data['is_active'];

            if (empty($updateData)) {
                return ['success' => false, 'message' => 'Aucune donnée à mettre à jour'];
            }

            $result = $this->collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($id)],
                ['$set' => $updateData]
            );

            if ($result->getMatchedCount() === 0) {
                return ['success' => false, 'message' => 'Utilisateur non trouvé'];
            }

            return ['success' => true, 'message' => 'Utilisateur mis à jour'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function delete($id) {
        try {
            $result = $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if ($result->getDeletedCount() === 0) {
                return ['success' => false, 'message' => 'Utilisateur non trouvé'];
            }
            return ['success' => true, 'message' => 'Utilisateur supprimé'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function getUsernamesPaginated($page = 1, $limit = 3) {
        $skip = ($page - 1) * $limit;
        $users = $this->collection->find(
            [],
            [
                'projection' => ['username' => 1, '_id' => 0],
                'skip' => $skip,
                'limit' => $limit
            ]
        )->toArray();

        return ['success' => true, 'data' => $users];
    }

    public function getCount() {
        $count = $this->collection->countDocuments();
        return ['success' => true, 'data' => ['count' => $count]];
    }
}

