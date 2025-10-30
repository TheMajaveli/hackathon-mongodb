<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../Database.php';

use MongoDB\BSON\ObjectId;

$db = new Database();
$collection = $db->getCollection('posts');

$id = $_GET['id'] ?? null;

try {
    if ($id) {
        // Lecture d’un document précis
        if (!preg_match('/^[a-f0-9]{24}$/i', $id)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid ID']);
            exit;
        }

        $doc = $collection->findOne(['_id' => new ObjectId($id)]);
        if (!$doc) {
            http_response_code(404);
            echo json_encode(['error' => 'Document not found']);
            exit;
        }

        $doc['_id'] = (string)$doc['_id'];
        echo json_encode($doc, JSON_UNESCAPED_SLASHES);
        exit;
    }

    // Lecture de tous les documents
    $cursor = $collection->find([], ['sort' => ['_id' => -1]]);
    $docs = [];
    foreach ($cursor as $d) {
        $d['_id'] = (string)$d['_id'];
        $docs[] = $d;
    }

    echo json_encode($docs, JSON_UNESCAPED_SLASHES);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}