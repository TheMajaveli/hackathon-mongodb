<?php

require_once __DIR__ . '/views/ViewHelper.php';

// Récupérer l'URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// Supprimer le préfixe /view et index.php
$uri = str_replace('view/', '', $uri);
$uri = str_replace('view', '', $uri);
$uri = str_replace('index.php/', '', $uri);
$uri = str_replace('index.php', '', $uri);
$uri = trim($uri, '/');

// Diviser l'URI en segments
$segments = explode('/', $uri);

// Routeur pour les vues
$resource = $segments[0] ?? 'dashboard';
$id = $segments[1] ?? null;

try {
    switch ($resource) {
        case '':
        case 'dashboard':
            ViewHelper::render('dashboard', ['title' => 'Dashboard']);
            break;

        case 'users':
            if ($id) {
                ViewHelper::render('user-detail', ['title' => 'Détails Utilisateur', 'id' => $id]);
            } else {
                ViewHelper::render('users', ['title' => 'Utilisateurs']);
            }
            break;

        case 'posts':
            if ($id) {
                ViewHelper::render('post-detail', ['title' => 'Détails Post', 'id' => $id]);
            } else {
                ViewHelper::render('posts', ['title' => 'Posts']);
            }
            break;

        case 'categories':
            if ($id) {
                ViewHelper::render('category-detail', ['title' => 'Détails Catégorie', 'id' => $id]);
            } else {
                ViewHelper::render('categories', ['title' => 'Catégories']);
            }
            break;

        case 'comments':
            ViewHelper::render('comments', ['title' => 'Commentaires']);
            break;

        case 'likes':
            ViewHelper::render('likes', ['title' => 'Likes']);
            break;

        case 'follows':
            ViewHelper::render('follows', ['title' => 'Follows']);
            break;

        default:
            ViewHelper::render('dashboard', ['title' => 'Dashboard']);
    }
} catch (Exception $e) {
    echo "<div class='empty-state'><h2>Erreur: " . htmlspecialchars($e->getMessage()) . "</h2></div>";
}

