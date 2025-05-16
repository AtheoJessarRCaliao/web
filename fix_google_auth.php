<?php
// This script will help diagnose and fix Google Auth issues

echo "<h1>Google Auth Configuration Check</h1>";

// Check for .env file
echo "<h2>Environment File Check</h2>";
$rootEnvPath = __DIR__ . '/.env';
if (file_exists($rootEnvPath)) {
    echo "Root .env file exists at: " . $rootEnvPath . "<br>";
    
    // Optional: Display contents (warning: contains sensitive data)
    // echo "Contents:<pre>" . htmlspecialchars(file_get_contents($rootEnvPath)) . "</pre>";
} else {
    echo "Root .env file NOT FOUND at: " . $rootEnvPath . "<br>";
}

// Check for Google Auth files
echo "<h2>Google Auth Files Check</h2>";
$files = [
    'User/login.php',
    'User/google_callback.php',
    'User/google.Auth/google-login.php',
    'User/google.Auth/google-callback.php'
];

foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        echo "✅ " . $file . " exists<br>";
    } else {
        echo "❌ " . $file . " does NOT exist<br>";
    }
}

// Display current server info
echo "<h2>Server Information</h2>";
echo "Server name: " . $_SERVER['SERVER_NAME'] . "<br>";
echo "Host: " . $_SERVER['HTTP_HOST'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";

// Check redirect URIs in both files
echo "<h2>Redirect URIs</h2>";

// Function to extract redirect URI from a file
function extractRedirectUri($filePath) {
    if (!file_exists($filePath)) {
        return "File not found";
    }
    
    $content = file_get_contents($filePath);
    if (preg_match('/setRedirectUri\([\'"](.+?)[\'"]\)/s', $content, $matches)) {
        return $matches[1];
    }
    
    return "Could not find redirect URI";
}

$loginFile = __DIR__ . '/User/login.php';
$googleLoginFile = __DIR__ . '/User/google.Auth/google-login.php';

echo "Redirect URI in login.php: " . extractRedirectUri($loginFile) . "<br>";
echo "Redirect URI in google-login.php: " . extractRedirectUri($googleLoginFile) . "<br>";

// Suggest fixes
echo "<h2>Recommended Actions</h2>";
echo "<ol>";
echo "<li>Ensure both login.php and google-login.php have consistent redirect URIs</li>";
echo "<li>Make sure the redirect URI points to a file that exists</li>";
echo "<li>Create Google credentials and update your .env file with them</li>";
echo "<li>Check that proper autoloading and directory paths are used</li>";
echo "</ol>";

// Copy the callback file if needed
if (file_exists(__DIR__ . '/User/google.Auth/google-callback.php') && !file_exists(__DIR__ . '/User/google_callback.php')) {
    echo "<h2>Creating Missing Callback File</h2>";
    echo "Copying google-callback.php to google_callback.php for compatibility...";
    
    if (copy(__DIR__ . '/User/google.Auth/google-callback.php', __DIR__ . '/User/google_callback.php')) {
        echo "SUCCESS!";
    } else {
        echo "FAILED!";
    }
}

// Display fix button
echo "<h2>Fix Options</h2>";
echo '<form method="post">';
echo '<button type="submit" name="fix_redirect_uri">Fix Redirect URIs</button>';
echo '</form>';

// Process fix if requested
if (isset($_POST['fix_redirect_uri'])) {
    // Update redirect URI in google-login.php
    $content = file_get_contents($googleLoginFile);
    $content = preg_replace(
        '/setRedirectUri\([\'"](.+?)[\'"]\)/', 
        'setRedirectUri(\'http://\' . $_SERVER[\'HTTP_HOST\'] . \'/User/google_callback.php\')', 
        $content
    );
    file_put_contents($googleLoginFile, $content);
    
    echo "Redirect URI updated in google-login.php. Please try again.";
}
?> 