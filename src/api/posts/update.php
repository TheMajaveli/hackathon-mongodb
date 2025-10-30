<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../Database.php';

use MongoDB\BSON\ObjectId;

if (!isset($_GET['id']) || !preg_match('/^[a-f0-9]{24}$/i', $_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid or missing id']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

$db = new Database();
$collection = $db->getCollection('posts');

$update = [];
if (isset($data['content']))     $update['content'] = (string)$data['content'];
if (isset($data['category_id'])) $update['category_id'] = (int)$data['category_id'];
if (isset($data['user_id']))     $update['user_id'] = (int)$data['user_id'];
if (isset($data['date']))        $update['date'] = (string)$data['date'];

if (!$update) {
    http_response_code(400);
    echo json_encode(['error' => 'No fields to update']);
    exit;
}

try {
    $oid = new ObjectId($_GET['id']);
    $res = $collection->updateOne(['_id' => $oid], ['$set' => $update]);

    if ($res->getMatchedCount() === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Document not found']);
        exit;
    }

    $updated = $collection->findOne(['_id' => $oid]);
    $updated['_id'] = (string)$updated['_id'];
    echo json_encode($updated);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}