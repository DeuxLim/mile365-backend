# M365 Backend

Laravel 12 backend for the MILE 365 platform.

## PostgreSQL on Render

This project is now configured to run on PostgreSQL and supports Render's `DATABASE_URL` out of the box.

### What changed

- The default database connection now falls back to `pgsql`.
- Laravel reads `DATABASE_URL` first, then falls back to `DB_URL`.
- A Docker-based `render.yaml` blueprint is included for a Render web service plus managed PostgreSQL database.
- The Render blueprint provisions both a web service and a worker service so queued mail jobs are processed.
- A production `Dockerfile` is included because Render does not offer PHP as a native runtime.
- Composer includes Render-friendly build and start scripts.
- The environment template now defaults to PostgreSQL values instead of SQLite placeholders.

## Local setup

1. Copy the environment file:

```bash
cp .env.example .env
```

2. Generate the app key:

```bash
php artisan key:generate
```

3. Point `.env` to your local PostgreSQL database:

```env
DB_CONNECTION=pgsql
DATABASE_URL=
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=m365_backend
DB_USERNAME=postgres
DB_PASSWORD=your-password
DB_SCHEMA=public
DB_SSLMODE=prefer
```

4. Run migrations and seeders if needed:

```bash
php artisan migrate
php artisan db:seed
```

## Render deploy

### Option 1: Blueprint deploy

Push this repository to GitHub and create a new Render Blueprint using [`render.yaml`](/Users/deuxlim/WebDevelopment/fundamentals/M365-Backend/render.yaml).

Render will provision:

- A PostgreSQL database
- A Docker-based web service
- A Docker-based worker service for queued listeners and mail delivery
- Environment variable wiring for `DATABASE_URL`, `DB_*`, mail, Cloudinary, and bootstrap admin values

### Option 2: Manual Render service

If you prefer to configure Render in the dashboard:

- Create a PostgreSQL database in Render.
- Create a Docker web service from this repo.
- Create a Docker worker service from this repo with the command `php artisan queue:work --sleep=3 --tries=3 --max-time=3600`.
- Set `DB_CONNECTION=pgsql`.
- Set `DATABASE_URL` to the connection string from the Render Postgres instance.
- Set `APP_KEY`, `APP_URL`, `FRONTEND_URL`, and the mail / Cloudinary variables.

## Important environment variables

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-render-service.onrender.com
FRONTEND_URL=https://your-frontend-domain.com

DB_CONNECTION=pgsql
DATABASE_URL=postgres://...
DB_SCHEMA=public
DB_SSLMODE=require

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## Migrating existing data

If your current production or local data lives in MySQL or SQLite, the safest path is:

1. Export the old database.
2. Provision the new Render Postgres database.
3. Run `php artisan migrate --force` against Postgres.
4. Transform and import the old data into PostgreSQL.
5. Verify auth, membership requests, members, sessions, cache, and queued jobs behavior.

For simple development data, it is usually faster to reseed instead of converting the old database directly.

## Useful commands

```bash
composer run render-build
composer run render-start
composer run render-worker
php artisan migrate --force
php artisan db:seed
php artisan test
```
