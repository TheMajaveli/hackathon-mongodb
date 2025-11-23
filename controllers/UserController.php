<?php
// Tâche Dev 1

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utils/Response.php';

class UserController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function handleRequest($method, $id = null, $action = null) {
        switch ($method) {
            case 'GET':
                if ($action === 'count') {
                    $result = $this->user->getCount();
                } elseif ($action === 'usernames') {
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $result = $this->user->getUsernamesPaginated($page);
                } elseif ($id) {
                    $result = $this->user->getById($id);
                } else {
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $result = $this->user->getAll($page);
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $this->user->create($data);
                break;

            case 'PUT':
                if (!$id) {
                    Response::error('ID requis', 400);
                }
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $this->user->update($id, $data);
                break;

            case 'DELETE':
                if (!$id) {
                    Response::error('ID requis', 400);
                }
                $result = $this->user->delete($id);
                break;

            default:
                Response::error('Méthode non autorisée', 405);
        }

        if ($result['success']) {
            Response::success($result['data'] ?? null, $result['message'] ?? 'Succès');
        } else {
            Response::error($result['message'], 400);
        }
    }
}

