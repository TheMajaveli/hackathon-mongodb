<?php
// Tâche Dev 1

require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../utils/Response.php';

class CategoryController {
    private $category;

    public function __construct() {
        $this->category = new Category();
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $result = $this->category->getById($id);
                } else {
                    $result = $this->category->getAll();
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $this->category->create($data);
                break;

            case 'PUT':
                if (!$id) {
                    Response::error('ID requis', 400);
                    return;
                }
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $this->category->update($id, $data);
                break;

            case 'DELETE':
                if (!$id) {
                    Response::error('ID requis', 400);
                    return;
                }
                $result = $this->category->delete($id);
                break;

            default:
                Response::error('Méthode non autorisée', 405);
                return;
        }

        if ($result['success']) {
            Response::success($result['data'] ?? null, $result['message'] ?? 'Succès');
        } else {
            Response::error($result['message'], 400);
        }
    }
}

