# GDPR Checklist

A Laravel-based application to help organizations comply with GDPR requirements.

## Deployment

This application is configured for deployment on [Render](https://render.com/).

### Environment Variables

After deploying on Render, you'll need to set the following environment variables in the Render dashboard:

- `APP_KEY` - Generate with `php artisan key:generate --show`
- Database connection variables (when you add a PostgreSQL database):
  - `DB_HOST`
  - `DB_PORT`
  - `DB_DATABASE`
  - `DB_USERNAME`
  - `DB_PASSWORD`

### Deployment Steps

1. Fork this repository to your GitHub account.
2. Create a new Web Service on Render.
3. Connect your GitHub repository to Render.
4. Configure the service with the following settings:
   - Environment: Docker
   - Region: Frankfurt (or your preferred EU region)
   - Branch: main
5. Add the required environment variables in the Render dashboard.
6. Deploy the application.

### Database

To add a database:

1. Create a new PostgreSQL database on Render.
2. Render will automatically populate the database connection variables.
3. Run migrations after the database is created (see below).

### Running Migrations

After the application and database are deployed, you'll need to run the database migrations:

```bash
php artisan migrate --force
```

You can run this command using Render's shell feature.