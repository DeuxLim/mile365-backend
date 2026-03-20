#!/bin/sh
set -e

php artisan migrate --force
php artisan db:seed --class=RolePermissionSeeder --force

if [ -n "${SUPER_ADMIN_EMAIL:-}" ] && [ -n "${SUPER_ADMIN_FIRST_NAME:-}" ] && [ -n "${SUPER_ADMIN_LAST_NAME:-}" ] && [ -n "${SUPER_ADMIN_PASSWORD:-}" ]; then
  php artisan app:bootstrap-super-admin --update-existing
fi

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
