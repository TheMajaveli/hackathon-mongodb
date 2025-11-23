<?php

require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../utils/Response.php';

class PostController {
    private $post;

    public function __construct() {
        $this->post = new Post();
    }

    public function handleRequest($method, $id = null, $action = null) {
        switch ($method) {
            case 'GET':
                if ($action === 'count') {
                    $result = $this->post->getCount();
                } elseif ($action === 'last-five') {
                    $result = $this->post->getLastFive();
                } elseif ($action === 'without-comments') {
                    $result = $this->post->getPostsWithoutComments();
                } elseif ($action === 'search') {
                    $word = $_GET['word'] ?? '';
                    if (empty($word)) {
                        Response::error('Paramètre word requis', 400);
                    }
                    $result = $this->post->searchByWord($word);
                } elseif ($action === 'before-date') {
                    $date = $_GET['date'] ?? '';
                    if (empty($date)) {
                        Response::error('Paramètre date requis', 400);
                    }
                    $result = $this->post->getPostsBeforeDate($date);
                } elseif ($action === 'after-date') {
                    $date = $_GET['date'] ?? '';
                    if (empty($date)) {
                        Response::error('Paramètre date requis', 400);
                    }
                    $result = $this->post->getPostsAfterDate($date);
                } elseif ($id && $action === 'comments') {
                    $result = $this->post->getPostWithComments($id);
                } elseif ($id) {
                    $result = $this->post->getById($id);
                } else {
                    $result = $this->post->getAll();
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $this->post->create($data);
                break;

            case 'PUT':
                if (!$id) {
                    Response::error('ID requis', 400);
                }
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $this->post->update($id, $data);
                break;

            case 'DELETE':
                if (!$id) {
                    Response::error('ID requis', 400);
                }
                $result = $this->post->delete($id);
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

