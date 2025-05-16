<?php
// Script to create .env file
$envContent = "RECAPTCHA_SITE_KEY=6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI
RECAPTCHA_SECRET_KEY=6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe";

// Try to write to project root
$rootEnvFile = __DIR__ . '/.env';
file_put_contents($rootEnvFile, $envContent);

// Try to write to User directory
$userEnvFile = __DIR__ . '/User/.env';
file_put_contents($userEnvFile, $envContent);

echo "Attempted to create .env files at:\n";
echo "- " . $rootEnvFile . "\n";
echo "- " . $userEnvFile . "\n";
echo "Check if they were created successfully.";
?> 