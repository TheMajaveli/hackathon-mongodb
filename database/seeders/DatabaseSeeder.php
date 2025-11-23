<?php
// Tâche Dev 1

require_once __DIR__ . '/UserSeeder.php';
require_once __DIR__ . '/CategorySeeder.php';
require_once __DIR__ . '/PostSeeder.php';
require_once __DIR__ . '/CommentSeeder.php';
require_once __DIR__ . '/LikeSeeder.php';
require_once __DIR__ . '/FollowSeeder.php';

class DatabaseSeeder {
    
    public function run() {
        echo "========================================\n";
        echo "  Database Seeder\n";
        echo "========================================\n\n";
        
        // Étape 1 : Users (indépendant)
        echo "📝 Étape 1 : Seeding Users...\n";
        $userSeeder = new UserSeeder();
        $userIds = $userSeeder->run();
        echo "\n";
        
        // Étape 2 : Categories (indépendant)
        echo "📝 Étape 2 : Seeding Categories...\n";
        $categorySeeder = new CategorySeeder();
        $categoryIds = $categorySeeder->run();
        echo "\n";
        
        // Étape 3 : Posts (dépend de Users et Categories)
        $postIds = [];
        if (class_exists('PostSeeder') && method_exists('PostSeeder', 'run')) {
            echo "📝 Étape 3 : Seeding Posts...\n";
            $postSeeder = new PostSeeder();
            $postIds = $postSeeder->run($userIds, $categoryIds) ?: [];
            echo "\n";
        } else {
            echo "⚠️  PostSeeder non implémenté, ignoré.\n\n";
        }
        
        // Étape 4 : Comments (dépend de Posts et Users)
        if (class_exists('CommentSeeder') && method_exists('CommentSeeder', 'run')) {
            echo "📝 Étape 4 : Seeding Comments...\n";
            $commentSeeder = new CommentSeeder();
            $commentSeeder->run($userIds, $postIds);
            echo "\n";
        } else {
            echo "⚠️  CommentSeeder non implémenté, ignoré.\n\n";
        }
        
        // Étape 5 : Likes (dépend de Posts et Users)
        if (class_exists('LikeSeeder') && method_exists('LikeSeeder', 'run')) {
            echo "📝 Étape 5 : Seeding Likes...\n";
            $likeSeeder = new LikeSeeder();
            $likeSeeder->run($userIds, $postIds);
            echo "\n";
        } else {
            echo "⚠️  LikeSeeder non implémenté, ignoré.\n\n";
        }
        
        // Étape 6 : Follows (dépend de Users)
        if (class_exists('FollowSeeder') && method_exists('FollowSeeder', 'run')) {
            echo "📝 Étape 6 : Seeding Follows...\n";
            $followSeeder = new FollowSeeder();
            $followSeeder->run($userIds);
            echo "\n";
        } else {
            echo "⚠️  FollowSeeder non implémenté, ignoré.\n\n";
        }
        
        echo "========================================\n";
        echo "  Seeding terminé avec succès !\n";
        echo "========================================\n\n";
    }
}
