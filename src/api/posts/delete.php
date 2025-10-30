<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../Database.php';

use MongoDB\BSON\ObjectId;

if (!isset($_GET['id']) || !preg_match('/^[a-f0-9]{24}$/i', $_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid or missing id']);
    exit;
}

$db = new Database();
$collection = $db->getCollection('posts');

try {
    $res = $collection->deleteOne(['_id' => new ObjectId($_GET['id'])]);
    if ($res->getDeletedCount() === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Document not found']);
        exit;
    }

    echo json_encode(['deleted' => true]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}