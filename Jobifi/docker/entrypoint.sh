#!/bin/sh
set -e

# ── 1. Create .env if not present ──────────────────────────────────────────
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# ── 2. Ensure APP_KEY is set ───────────────────────────────────────────────
if grep -q "^APP_KEY=$" /var/www/html/.env; then
    php /var/www/html/artisan key:generate --force
fi

# ── 3. Wait for PostgreSQL to be ready ────────────────────────────────────
DB_HOST=$(grep "^DB_HOST=" /var/www/html/.env | cut -d'=' -f2- | tr -d '"'"'" | xargs)
DB_PORT=$(grep "^DB_PORT=" /var/www/html/.env | cut -d'=' -f2- | tr -d '"'"'" | xargs)
DB_PORT=${DB_PORT:-5432}

if [ -n "$DB_HOST" ]; then
    echo "Waiting for PostgreSQL at $DB_HOST:$DB_PORT..."
    until pg_isready -h "$DB_HOST" -p "$DB_PORT" -q; do
        sleep 1
    done
    echo "PostgreSQL is ready."
fi

# ── 4. Run migrations ─────────────────────────────────────────────────────
php /var/www/html/artisan migrate --force

# ── 5. Cache config, routes & views ──────────────────────────────────────
php /var/www/html/artisan config:cache
php /var/www/html/artisan route:cache
php /var/www/html/artisan view:cache

# ── 6. Configure PHP-FPM to use unix socket ───────────────────────────────
cat > /usr/local/etc/php-fpm.d/www.conf <<'EOF'
[www]
user = www-data
group = www-data
listen = /var/run/php-fpm.sock
listen.owner = www-data
listen.group = www-data
listen.mode = 0660
pm = dynamic
pm.max_children = 10
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 5
EOF

# ── 7. Fix final ownership ────────────────────────────────────────────────
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# ── 8. Start supervisor ───────────────────────────────────────────────────
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
