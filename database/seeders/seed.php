<?php
// Tâche Dev 1

/**
 * Seeder Runner
 * 
 * Ce script exécute tous les seeders dans le bon ordre
 * 
 * Usage:
 *   php database/seeders/seed.php
 */

require_once __DIR__ . '/DatabaseSeeder.php';

$seeder = new DatabaseSeeder();
$seeder->run();

echo "✅ Tous les seeders ont été exécutés avec succès !\n";
