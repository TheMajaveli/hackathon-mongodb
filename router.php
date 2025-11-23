<?php

require_once __DIR__ . '/config/cors.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/PostController.php';
require_once __DIR__ . '/controllers/CategoryController.php';
require_once __DIR__ . '/controllers/CommentController.php';
require_once __DIR__ . '/controllers/LikeController.php';
require_once __DIR__ . '/controllers/FollowController.php';
require_once __DIR__ . '/utils/Response.php';

// Récupérer l'URL et la méthode
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// Supprimer le préfixe si présent (ex: /api)
$uri = str_replace('api/', '', $uri);
$uri = str_replace('index.php/', '', $uri);

// Diviser l'URI en segments
$segments = explode('/', $uri);

// Routeur simple
$resource = $segments[0] ?? '';
$id = null;
$action = null;

// Détecter les routes spéciales (ex: /users/count, /posts/last-five)
if (isset($segments[1])) {
    // Si le deuxième segment est une action (pas un ID)
    $specialActions = ['count', 'usernames', 'last-five', 'without-comments', 'search', 'before-date', 'after-date', 'comments', 'average', 'following-count', 'followers-count', 'top-three'];
    if (in_array($segments[1], $specialActions)) {
        $action = $segments[1];
    } else {
        $id = $segments[1];
        // Vérifier si le troisième segment est une action
        if (isset($segments[2]) && in_array($segments[2], $specialActions)) {
            $action = $segments[2];
        }
    }
}

// Si l'action est dans les query params pour certaines routes
if (empty($action) && isset($_GET['action'])) {
    $action = $_GET['action'];
}

try {
    switch ($resource) {
        case 'users':
            $controller = new UserController();
            $controller->handleRequest($method, $id, $action);
            break;

        case 'posts':
            $controller = new PostController();
            $controller->handleRequest($method, $id, $action);
            break;

        case 'categories':
            $controller = new CategoryController();
            $controller->handleRequest($method, $id);
            break;

        case 'comments':
            $controller = new CommentController();
            $controller->handleRequest($method, $id, $action);
            break;

        case 'likes':
            $controller = new LikeController();
            $controller->handleRequest($method, $id, $action);
            break;

        case 'follows':
            $controller = new FollowController();
            $controller->handleRequest($method, $id, $action);
            break;

        case '':
        case 'index.php':
            Response::success(['message' => 'API Social Network - Documentation disponible dans README.md']);
            break;

        default:
            Response::error('Ressource non trouvée', 404);
    }
} catch (Exception $e) {
    Response::error('Erreur serveur: ' . $e->getMessage(), 500);
}

