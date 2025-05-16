<?php
// Custom 404 handler with detailed error information

// Log the 404 error
$logFile = __DIR__ . '/404_errors.txt';
$requestUrl = $_SERVER['REQUEST_URI'] ?? 'unknown';
$referer = $_SERVER['HTTP_REFERER'] ?? 'none';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
$timestamp = date('Y-m-d H:i:s');

$logEntry = "[$timestamp] 404 Error: $requestUrl | Referer: $referer | User Agent: $userAgent\n";
file_put_contents($logFile, $logEntry, FILE_APPEND);

// Set proper 404 status code
header("HTTP/1.0 404 Not Found");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        h1 {
            color: #e74c3c;
        }
        .error-details {
            background-color: #f8f9fa;
            border-left: 4px solid #e74c3c;
            padding: 1rem;
            margin: 1rem 0;
        }
        .solutions {
            background-color: #f1f8e9;
            border-left: 4px solid #8bc34a;
            padding: 1rem;
            margin: 1rem 0;
        }
        code {
            background-color: #f5f5f5;
            padding: 2px 4px;
            border-radius: 3px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <h1>Page Not Found (404)</h1>
    <p>The page you're looking for could not be found on this server.</p>
    
    <div class="error-details">
        <h2>Error Details</h2>
        <p><strong>Requested URL:</strong> <?php echo htmlspecialchars($requestUrl); ?></p>
        <p><strong>Referer:</strong> <?php echo htmlspecialchars($referer); ?></p>
        <p><strong>Time:</strong> <?php echo $timestamp; ?></p>
    </div>
    
    <div class="solutions">
        <h2>Possible Solutions</h2>
        <ol>
            <li>Check if the URL is typed correctly</li>
            <li>Make sure the file exists on the server</li>
            <li>Check case sensitivity (URLs are case-sensitive)</li>
            <li>Verify your .htaccess configuration</li>
            <li>Try accessing these known working pages:
                <ul>
                    <li><a href="/User/login.php">Login Page</a></li>
                    <li><a href="/test.php">Test PHP</a></li>
                    <li><a href="/test_google_auth.php">Test Google Auth</a></li>
                    <li><a href="/debug_url.php">Debug URL Tool</a></li>
                </ul>
            </li>
        </ol>
    </div>
    
    <div class="error-details">
        <h2>Google Auth Debug</h2>
        <p>If you're having trouble with Google Authentication:</p>
        <ol>
            <li>Ensure your <code>.env</code> file contains valid Google credentials</li>
            <li>Verify that the redirect URI in Google API Console matches your callback URL:
                <code>http://<?php echo $_SERVER['HTTP_HOST']; ?>/User/google_callback.php</code></li>
            <li>Check that all required Google Auth files exist</li>
            <li>Make sure <code>mod_rewrite</code> is enabled if you're using URL rewriting</li>
        </ol>
    </div>
</body>
</html> 