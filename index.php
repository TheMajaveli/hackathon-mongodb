<?php

// Récupérer l'URL pour déterminer si c'est une route de vue ou API
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// Si c'est une route de vue ou la racine, charger les vues
if (strpos($uri, 'view') === 0 || $uri === '' || $uri === 'index.php') {
    require_once __DIR__ . '/views.php';
} else {
    // Sinon, charger le routeur API
    require_once __DIR__ . '/router.php';
}