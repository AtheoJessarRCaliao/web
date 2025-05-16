<?php
// Debug script to log HTTP request details
$logFile = __DIR__ . '/request_log.txt';

// Collect request information
$data = [
    'time' => date('Y-m-d H:i:s'),
    'url' => $_SERVER['REQUEST_URI'] ?? 'unknown',
    'method' => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
    'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    'host' => $_SERVER['HTTP_HOST'] ?? 'unknown',
    'referer' => $_SERVER['HTTP_REFERER'] ?? 'none',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
    'query_string' => $_SERVER['QUERY_STRING'] ?? 'none',
    'is_https' => isset($_SERVER['HTTPS']) ? 'yes' : 'no'
];

// Format log entry
$logEntry = "==== " . $data['time'] . " ====\n";
foreach ($data as $key => $value) {
    $logEntry .= "{$key}: {$value}\n";
}
$logEntry .= "========================\n\n";

// Write to log file
file_put_contents($logFile, $logEntry, FILE_APPEND);

// Output success message
echo "<h1>Request Logged</h1>";
echo "<p>URL: " . htmlspecialchars($data['url']) . " has been logged to " . htmlspecialchars($logFile) . "</p>";
echo "<p>Return to <a href='/User/login.php'>login page</a> and try again.</p>";
echo "<h2>Recent Log Entries</h2>";
echo "<pre>";
$logContent = file_exists($logFile) ? file_get_contents($logFile) : 'No logs found';
echo htmlspecialchars($logContent);
echo "</pre>";
?> 