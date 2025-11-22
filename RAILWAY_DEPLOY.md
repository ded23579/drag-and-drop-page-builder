# Deployment to Railway

This application is configured for deployment on Railway platform.

## Setup

1. Create an account at [railway.app](https://railway.app)
2. Install Railway CLI (optional): `npm install -g @railway/cli`
3. Connect your GitHub repository to Railway

## Environment Variables Required

Add these variables in your Railway dashboard:

- `APP_KEY`: Generate with `php artisan key:generate --show`
- `APP_ENV`: production
- `APP_DEBUG`: false
- `APP_URL`: Your railway.app URL
- `DB_CONNECTION`: sqlite or your database connection
- Any other environment-specific variables

## Database Setup

If using SQLite:
- The database file will be ephemeral, so consider using Railway's database addon
- For persistent data, set up PostgreSQL or MySQL addon in Railway

## Deployment Process

1. Push your code to GitHub
2. Railway will automatically detect and build the application
3. The build process will run `build.sh` as specified in `railway.json`
4. Application will be deployed with the start command from `railway.json`

## Useful Commands

During development:
```bash
# Locally
composer install
npm install
php artisan key:generate
php artisan migrate
npm run dev

# With Railway CLI
railway run php artisan migrate
railway run php artisan config:cache
```