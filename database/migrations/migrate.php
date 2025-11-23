<?php
// Tâche Dev 1


/**
 * Migration Runner
 * 
 * This script runs all migrations in the correct order:
 * 1. Create collections and indexes
 * 2. (Optional) Seed the database
 * 
 * Usage:
 *   php database/migrations/migrate.php              - Run migrations only
 *   php database/migrations/migrate.php --seed       - Run migrations and seed
 *   php database/migrations/migrate.php --down       - Rollback all migrations
 */

require_once __DIR__ . '/CreateUsersCollection.php';
require_once __DIR__ . '/CreateCategoriesCollection.php';
require_once __DIR__ . '/CreatePostsCollection.php';
require_once __DIR__ . '/CreateCommentsCollection.php';
require_once __DIR__ . '/CreateLikesCollection.php';
require_once __DIR__ . '/CreateFollowsCollection.php';
require_once __DIR__ . '/../seeders/DatabaseSeeder.php';

echo "========================================\n";
echo "  Migration Runner\n";
echo "========================================\n\n";

// Check if we're rolling back
$isRollback = isset($argv[1]) && $argv[1] === '--down';

if ($isRollback) {
    echo "Step 1: Rolling back migrations...\n\n";
    
    // Rollback in reverse order
    $migrations = [
        new CreateFollowsCollection(),
        new CreateLikesCollection(),
        new CreateCommentsCollection(),
        new CreatePostsCollection(),
        new CreateCategoriesCollection(),
        new CreateUsersCollection(),
    ];
    
    foreach ($migrations as $migration) {
        $migration->down();
    }
    
    echo "\n✅ All migrations rolled back!\n";
    exit(0);
}

// Step 1: Run migrations in order
echo "Step 1: Running migrations...\n\n";

$migrations = [
    new CreateUsersCollection(),
    new CreateCategoriesCollection(),
    new CreatePostsCollection(),
    new CreateCommentsCollection(),
    new CreateLikesCollection(),
    new CreateFollowsCollection(),
];

foreach ($migrations as $migration) {
    $migration->up();
}

echo "========================================\n";
echo "  Migrations terminées avec succès !\n";
echo "========================================\n\n";

echo "\n✅ All migrations completed!\n";
