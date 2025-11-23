<?php
// Tâche Dev 3

require_once __DIR__ . '/../models/Like.php';
require_once __DIR__ . '/../utils/Response.php';

class LikeController {
    private $like;

    public function __construct() {
        $this->like = new Like();
    }

    public function handleRequest($method, $id = null, $action = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $result = $this->like->getById($id);
                } else {
                    $result = $this->like->getAll();
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $this->like->create($data);
                break;

            case 'DELETE':
                if (!$id) {
                    Response::error('ID requis', 400);
                    return;
                }
                $result = $this->like->delete($id);
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
