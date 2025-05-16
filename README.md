# Google Authentication Setup

This guide will help you set up Google authentication for your website.

## Requirements

1. PHP 7.4 or higher
2. Composer
3. Google Developer Account

## Setup Instructions

### 1. Environment Configuration

Run the setup_env.php script to create your .env file:

```bash
php setup_env.php
```

Edit the .env file with your actual values:

```
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
```

### 2. Google API Setup

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project
3. Navigate to API & Services > Credentials
4. Create OAuth Client ID credentials
5. Set the authorized redirect URI to: `http://your-domain.com/User/google.Auth/google-callback.php`
6. Copy the Client ID and Client Secret to your .env file

### 3. Database Setup

Run the add_google_id_column.php script to ensure your database has the required columns:

```bash
php User/add_google_id_column.php
```

### 4. Testing

1. Visit your login page
2. Click on "Continue with Google"
3. You should be redirected to Google for authentication
4. After successful authentication, you will be redirected back to your website

## Troubleshooting

If you encounter issues:

- Check that your .env file has the correct Google credentials
- Verify that the redirect URI matches exactly what's configured in Google Console
- Ensure your database has the required columns (google_id and profile_image)
- Check PHP error logs for specific error messages 