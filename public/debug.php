<?php
// Debug version to check what's happening
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Laravel Music Platform Debug</h1>";
echo "<h2>Environment Check</h2>";

// Check PHP version
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";

// Check if vendor autoload exists
$autoload_path = __DIR__ . '/../vendor/autoload.php';
echo "<p><strong>Autoload Path:</strong> " . $autoload_path . "</p>";

if (file_exists($autoload_path)) {
    echo "<p style='color: green;'>✓ Autoload file exists</p>";
    
    try {
        require $autoload_path;
        echo "<p style='color: green;'>✓ Autoload loaded successfully</p>";
        
        // Check if Laravel classes are available
        if (class_exists('Illuminate\Foundation\Application')) {
            echo "<p style='color: green;'>✓ Laravel Framework classes available</p>";
            
            try {
                // Try to load the bootstrap
                $bootstrap_path = __DIR__ . '/../bootstrap/app.php';
                if (file_exists($bootstrap_path)) {
                    echo "<p style='color: green;'>✓ Bootstrap file exists</p>";
                    $app = require_once $bootstrap_path;
                    echo "<p style='color: green;'>✓ Bootstrap loaded successfully</p>";
                    echo "<p>Laravel application type: " . get_class($app) . "</p>";
                    
                    // Try to handle a basic request
                    $kernel = $app->make('Illuminate\Contracts\Http\Kernel');
                    $request = Illuminate\Http\Request::capture();
                    echo "<p style='color: green;'>✓ Request captured successfully</p>";
                    
                } else {
                    echo "<p style='color: red;'>✗ Bootstrap file missing: " . $bootstrap_path . "</p>";
                }
                
            } catch (Exception $e) {
                echo "<p style='color: red;'>✗ Bootstrap Error: " . $e->getMessage() . "</p>";
                echo "<pre>" . $e->getTraceAsString() . "</pre>";
            }
            
        } else {
            echo "<p style='color: red;'>✗ Laravel Framework classes not available</p>";
            echo "<p>Available classes:</p>";
            $classes = get_declared_classes();
            $illuminate_classes = array_filter($classes, function($class) {
                return strpos($class, 'Illuminate') === 0;
            });
            echo "<pre>" . print_r(array_slice($illuminate_classes, 0, 10), true) . "</pre>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Autoload Error: " . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
    
} else {
    echo "<p style='color: red;'>✗ Autoload file missing</p>";
}

// Check environment file
$env_path = __DIR__ . '/../.env';
echo "<p><strong>.env file:</strong> " . (file_exists($env_path) ? 'exists' : 'missing') . "</p>";

// Check database file
if (isset($_ENV['DB_DATABASE'])) {
    echo "<p><strong>Database:</strong> " . $_ENV['DB_DATABASE'] . " (" . (file_exists($_ENV['DB_DATABASE']) ? 'exists' : 'missing') . ")</p>";
}

echo "<h2>Directory Structure</h2>";
$dirs = ['app', 'bootstrap', 'config', 'database', 'resources', 'routes', 'storage', 'vendor'];
foreach ($dirs as $dir) {
    $dir_path = __DIR__ . '/../' . $dir;
    echo "<p><strong>$dir:</strong> " . (path_exists($dir_path) ? 'exists' : 'missing') . "</p>";
}

function path_exists($path) {
    return file_exists($path) || is_dir($path);
}
?>