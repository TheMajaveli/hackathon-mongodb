<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../Database.php';

$db = new Database();
$collection = $db->getCollection('posts'); // nom de la collection à adapter

$data = json_decode(file_get_contents('php://input'), true);

// Vérification des champs obligatoires
if (!isset($data['content'], $data['category_id'], $data['user_id'], $data['date'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

try {
    $result = $collection->insertOne([
        'content' => (string)$data['content'],
        'category_id' => (int)$data['category_id'],
        'user_id' => (int)$data['user_id'],
        'date' => (string)$data['date']
    ]);

    http_response_code(201);
    echo json_encode(['success' => true, 'inserted_id' => (string)$result->getInsertedId()]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}