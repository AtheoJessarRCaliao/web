<?php
// 404 Logger for rewrite rule

// Log the requested URL
$logFile = __DIR__ . '/404_errors.txt';
$requestUrl = $_GET['url'] ?? ($_SERVER['REQUEST_URI'] ?? 'unknown');
$referer = $_SERVER['HTTP_REFERER'] ?? 'none';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
$timestamp = date('Y-m-d H:i:s');

$logEntry = "[$timestamp] Rewrite 404: $requestUrl | Referer: $referer | User Agent: $userAgent\n";
file_put_contents($logFile, $logEntry, FILE_APPEND);

// Include the custom 404 page
include __DIR__ . '/custom_404.php';
?> 