<?php
// Test script for Google OAuth

require_once __DIR__ . '/vendor/autoload.php';

session_start();

echo "<h1>Google OAuth Test</h1>";

// Check if Google Client library is available
if (!class_exists('Google\\Client')) {
    echo "<div style='color: red;'>Google Client library is not available. Make sure you've run 'composer require google/apiclient'.</div>";
    exit;
} else {
    echo "<div style='color: green;'>Google Client library is available.</div>";
}

// Load environment variables from .env file if available
$googleClientId = '';
$googleClientSecret = '';

// Try different paths for .env file
$envPaths = [
    __DIR__ . '/.env',
    __DIR__ . '/User/.env'
];

$envFound = false;
foreach ($envPaths as $envPath) {
    if (file_exists($envPath)) {
        echo "<div>Found .env file at: " . $envPath . "</div>";
        $envFound = true;
        
        // Check if Dotenv class exists
        if (class_exists('Dotenv\\Dotenv')) {
            try {
                $dotenv = Dotenv\Dotenv::createImmutable(dirname($envPath));
                $dotenv->load();
                $googleClientId = $_ENV['GOOGLE_CLIENT_ID'] ?? '';
                $googleClientSecret = $_ENV['GOOGLE_CLIENT_SECRET'] ?? '';
                
                echo "<div>Loaded environment variables</div>";
                
                // Check if values are set (without revealing them)
                if (!empty($googleClientId)) {
                    echo "<div style='color: green;'>GOOGLE_CLIENT_ID is set</div>";
                } else {
                    echo "<div style='color: red;'>GOOGLE_CLIENT_ID is not set</div>";
                }
                
                if (!empty($googleClientSecret)) {
                    echo "<div style='color: green;'>GOOGLE_CLIENT_SECRET is set</div>";
                } else {
                    echo "<div style='color: red;'>GOOGLE_CLIENT_SECRET is not set</div>";
                }
                
            } catch (Exception $e) {
                echo "<div style='color: red;'>Error loading .env file: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div style='color: red;'>Dotenv class not available. Make sure you've run 'composer require vlucas/phpdotenv'.</div>";
        }
    }
}

if (!$envFound) {
    echo "<div style='color: red;'>No .env file found. Please create one with your Google OAuth credentials.</div>";
    
    // Create a sample .env file
    echo "<h2>Sample .env File</h2>";
    echo "<pre>";
    echo "# Google OAuth credentials\n";
    echo "GOOGLE_CLIENT_ID=your_google_client_id\n";
    echo "GOOGLE_CLIENT_SECRET=your_google_client_secret\n";
    echo "</pre>";
}

// Test Google client setup
echo "<h2>Google Client Test</h2>";

try {
    $client = new Google\Client();
    $client->setClientId($googleClientId);
    $client->setClientSecret($googleClientSecret);
    $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/User/google_callback.php');
    $client->addScope('email');
    $client->addScope('profile');
    
    echo "<div style='color: green;'>Google Client successfully initialized</div>";
    
    // Generate test authentication URL
    $authUrl = $client->createAuthUrl();
    echo "<div>Auth URL: <a href='" . htmlspecialchars($authUrl) . "'>Login with Google</a></div>";
    echo "<div><small>Note: The auth URL only works if you've set up valid Google OAuth credentials.</small></div>";
    
} catch (Exception $e) {
    echo "<div style='color: red;'>Error initializing Google Client: " . $e->getMessage() . "</div>";
}

// Test file paths
echo "<h2>File Paths Test</h2>";
$testPaths = [
    '/User/google_callback.php',
    '/User/google.Auth/google-callback.php',
    '/User/login.php'
];

foreach ($testPaths as $path) {
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $path;
    if (file_exists($fullPath)) {
        echo "<div style='color: green;'>File exists: " . $path . "</div>";
    } else {
        echo "<div style='color: red;'>File does not exist: " . $path . " (full path: " . $fullPath . ")</div>";
    }
}
?> 