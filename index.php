<?php
// index.php

// Inclure l'autochargeur de Composer
require __DIR__ . '/vendor/autoload.php'; 
require 'src/Database.php'; 

// 1. ANALYSER LA REQUÊTE
// Nettoyer l'URI (supprimer les paramètres de requête si il y en a)
$uri = strtok($_SERVER['REQUEST_URI'], '?');

// 2. DÉFINIR LE SYSTÈME DE ROUTAGE

$db = new Database(); // Initialiser la connexion une seule fois

// Un simple 'switch' pour gérer les routes
switch ($uri) {
    case '/':
        // Route : / (Page d'accueil)
        echo "<h1>Bienvenue sur l'Accueil !</h1>";
        break;

    case '/users':
    case '/users/list':
        // Route : /users ou /users/list
        $usersCollection = $db->getCollection('Users');
        $count = $usersCollection->countDocuments();
        echo "<h1>Liste des utilisateurs</h1>";
        echo "Total d'utilisateurs: " . $count;
        // Vous pouvez ajouter ici la logique pour afficher tous les utilisateurs (find())
        break;

    case '/login':
        // Route : /login
        echo "<h1>Page de Connexion</h1>";
        // Logique de connexion ici...
        break;

    default:
        // Route par défaut (404)
        http_response_code(404);
        echo "<h1>404 - Page non trouvée</h1>";
        break;
}

?>