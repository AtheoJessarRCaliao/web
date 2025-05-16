<?php
// Create a .env file with the correct Google OAuth credentials
$envContent = <<<EOT
# Google OAuth credentials
GOOGLE_CLIENT_ID=308218146883-rs3gpm7dl141mpjdateqfmjqefoofcuq.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=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
GOOGLE_REDIRECT_URI=http://localhost/User/google.Auth/google-callback.php
EOT;

// Write the .env file to the root directory
file_put_contents(__DIR__ . '/.env', $envContent);

echo "Successfully created .env file with Google OAuth credentials.\n";
?> 