<?php
// Tâche Dev 3

require_once __DIR__ . '/../config/database.php';

class Follow {
    private $collection;

    public function __construct() {
        $db = Database::getInstance();
        $this->collection = $db->getCollection('Follows');
    }

    public function create($data) {
        if (!isset($data['follower_id']) || !isset($data['following_id'])) {
            return ['success' => false, 'message' => 'follower_id et following_id sont requis'];
        }

        // Éviter qu'un utilisateur se suive lui-même
        if ($data['follower_id'] === $data['following_id']) {
            return ['success' => false, 'message' => 'Un utilisateur ne peut pas se suivre lui-même'];
        }

        $follow = [
            'follower_id' => $data['follower_id'],
            'following_id' => $data['following_id'],
            'date' => isset($data['date']) ? $data['date'] : date('Y-m-d H:i:s')
        ];

        try {
            $result = $this->collection->insertOne($follow);
            $follow['_id'] = $result->getInsertedId();
            return ['success' => true, 'data' => $follow, 'message' => 'Relation de suivi créée'];
        } catch (MongoDB\Driver\Exception\BulkWriteException $e) {
            // Gérer les erreurs de doublon (index unique)
            if ($e->getCode() === 11000) {
                return ['success' => false, 'message' => 'Cette relation de suivi existe déjà'];
            }
            return ['success' => false, 'message' => 'Erreur lors de la création'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de la création'];
        }
    }

    public function getAll() {
        $follows = $this->collection->find()->toArray();
        return ['success' => true, 'data' => $follows];
    }

    public function getById($id) {
        try {
            $follow = $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if (!$follow) {
                return ['success' => false, 'message' => 'Relation de suivi non trouvée'];
            }
            return ['success' => true, 'data' => $follow];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function update($id, $data) {
        try {
            $updateData = [];
            if (isset($data['follower_id'])) $updateData['follower_id'] = $data['follower_id'];
            if (isset($data['following_id'])) $updateData['following_id'] = $data['following_id'];
            if (isset($data['date'])) $updateData['date'] = $data['date'];

            if (empty($updateData)) {
                return ['success' => false, 'message' => 'Aucune donnée à mettre à jour'];
            }

            // Vérifier qu'on ne se suit pas soi-même si les deux IDs sont présents
            if (isset($updateData['follower_id']) && isset($updateData['following_id'])) {
                if ($updateData['follower_id'] === $updateData['following_id']) {
                    return ['success' => false, 'message' => 'Un utilisateur ne peut pas se suivre lui-même'];
                }
            }

            $result = $this->collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($id)],
                ['$set' => $updateData]
            );

            if ($result->getMatchedCount() === 0) {
                return ['success' => false, 'message' => 'Relation de suivi non trouvée'];
            }

            return ['success' => true, 'message' => 'Relation de suivi mise à jour'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function delete($id) {
        try {
            $result = $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if ($result->getDeletedCount() === 0) {
                return ['success' => false, 'message' => 'Relation de suivi non trouvée'];
            }
            return ['success' => true, 'message' => 'Relation de suivi supprimée'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'ID invalide'];
        }
    }

    public function getFollowingCount($userId) {
        try {
            $count = $this->collection->countDocuments(['follower_id' => $userId]);
            return ['success' => true, 'data' => ['count' => $count, 'user_id' => $userId]];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors du comptage'];
        }
    }

    public function getFollowersCount($userId) {
        try {
            $count = $this->collection->countDocuments(['following_id' => $userId]);
            return ['success' => true, 'data' => ['count' => $count, 'user_id' => $userId]];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors du comptage'];
        }
    }

    public function getTopThreeMostFollowed() {
        try {
            $pipeline = [
                [
                    '$group' => [
                        '_id' => '$following_id',
                        'followers_count' => ['$sum' => 1]
                    ]
                ],
                [
                    '$sort' => ['followers_count' => -1]
                ],
                [
                    '$limit' => 3
                ]
            ];

            $results = $this->collection->aggregate($pipeline)->toArray();
            
            $topThree = [];
            foreach ($results as $result) {
                $topThree[] = [
                    'user_id' => $result['_id'],
                    'followers_count' => $result['followers_count']
                ];
            }

            return ['success' => true, 'data' => $topThree];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de la récupération'];
        }
    }
}
