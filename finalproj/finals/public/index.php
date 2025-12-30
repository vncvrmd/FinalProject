<?php

// --- 🔴 START OF MIGRATION BACKDOOR ---
// This block runs before Laravel loads. It bypasses all routing/caching issues.
if (isset($_GET['migrate_now'])) {
    echo "<h1>Starting Migration (Nuclear Option)...</h1>";
    echo "<pre style='background: #333; color: #0f0; padding: 10px;'>";
    
    // 1. Check where we are
    echo "Current Directory: " . getcwd() . "\n";
    
    // 2. Run the migration command from the project root (one folder up)
    // The "2>&1" part forces error messages to show on screen
    passthru('cd .. && php artisan migrate --force 2>&1');
    
    echo "</pre>";
    echo "<h1>DONE! If you see 'Migration table created' above, it worked.</h1>";
    echo "<p><a href='/'>Go to Homepage</a></p>";
    exit; // Stop the script here so Laravel doesn't try to load
}
// --- 🔴 END OF MIGRATION BACKDOOR ---


use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());