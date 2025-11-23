<?php
// Tâche Dev 3

require_once __DIR__ . '/../models/Follow.php';
require_once __DIR__ . '/../utils/Response.php';

class FollowController {
    private $follow;

    public function __construct() {
        $this->follow = new Follow();
    }

    public function handleRequest($method, $id = null, $action = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $result = $this->follow->getById($id);
                } else {
                    $result = $this->follow->getAll();
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $this->follow->create($data);
                break;

            case 'PUT':
                if (!$id) {
                    Response::error('ID requis', 400);
                    return;
                }
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $this->follow->update($id, $data);
                break;

            case 'DELETE':
                if (!$id) {
                    Response::error('ID requis', 400);
                    return;
                }
                $result = $this->follow->delete($id);
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
