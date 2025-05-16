<?php
// This script will help users set up their environment variables

// Check if the .env file already exists
if (file_exists('.env')) {
    echo "The .env file already exists. If you want to recreate it, please delete it first.\n";
    exit;
}

echo "Creating a new .env file with sample values...\n";

$env_content = <<<EOT
# Google OAuth credentials
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret

# reCAPTCHA configuration
RECAPTCHA_SITE_KEY=6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI
RECAPTCHA_SECRET_KEY=6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe

# Database configuration
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=
DB_NAME=your_database_name
EOT;

// Write the .env file
if (file_put_contents('.env', $env_content)) {
    echo "The .env file has been created successfully.\n";
    echo "Please edit it with your actual values.\n";
    
    echo "\nInstructions:\n";
    echo "1. For Google OAuth, go to Google Cloud Console and create credentials\n";
    echo "2. Set your GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET with values from Google\n";
    echo "3. Make sure your database configuration is correct\n";
} else {
    echo "Failed to create the .env file. Please check permissions.\n";
}
?> 