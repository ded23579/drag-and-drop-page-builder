# Laravel Application for Railway Deployment

This is a Laravel application configured for deployment on Railway.

## Deployment to Railway

This application is optimized for deployment on Railway platform. Here's how to deploy:

### Prerequisites
- A Railway account
- Git repository with this code

### Deployment Steps

1. **Connect GitHub Repository**:
   - Go to [https://railway.app](https://railway.app)
   - Create a new project
   - Select "Deploy from GitHub repo"
   - Choose your repository (`ded23579/drag-and-drop`)

2. **Set Environment Variables**:
   - In the Railway dashboard, go to your project
   - Navigate to "Variables" section
   - Add the following environment variables:
     - `APP_KEY`: Generate with `php artisan key:generate --show`
     - `APP_ENV`: production
     - `APP_DEBUG`: false
     - `APP_URL`: Your railway.app URL
     - Database configuration variables as needed

3. **Deploy**:
   - Railway will automatically build and deploy your application
   - The build process will execute `build.sh` as defined in `railway.json`

### Environment Variables

You'll need to set the following environment variables in your Railway dashboard:

- `APP_KEY`: Generate with `php artisan key:generate --show`
- `APP_ENV`: production
- `APP_DEBUG`: false
- `APP_URL`: Your production URL (e.g., https://your-app.up.railway.app)

Additional environment variables based on your application requirements (database, mail, etc.)

### Build Process

The application uses the included `build.sh` script to:
- Install PHP dependencies
- Cache Laravel configurations
- Install and build frontend assets
- Run database migrations

## Local Development

To run locally:

```bash
# Install dependencies
composer install
npm install

# Create .env file from example
cp .env.example .env

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# Start development server
npm run dev
```

## Database Configuration

For persistent data storage on Railway:
- Use the PostgreSQL or MySQL addon
- Configure your database connection in Railway variables
- Update your deployment configuration accordingly