#!/bin/sh
set -e

# ── 1. Create .env from .env.example if missing ──────────────────────────
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# ── 2. Write Render-injected env vars into .env ──────────────────────────
# Render provides env vars as actual shell variables, not in a .env file.
# We sync them so Laravel's config:cache picks up the correct values.
update_env() {
    local key="$1"
    local value="$2"
    if [ -n "$value" ]; then
        if grep -q "^${key}=" /var/www/html/.env; then
            sed -i "s|^${key}=.*|${key}=${value}|" /var/www/html/.env
        else
            echo "${key}=${value}" >> /var/www/html/.env
        fi
    fi
}

update_env "APP_KEY"          "$APP_KEY"
update_env "APP_ENV"          "$APP_ENV"
update_env "APP_URL"          "$APP_URL"
update_env "APP_DEBUG"        "$APP_DEBUG"
update_env "DB_CONNECTION"    "$DB_CONNECTION"
update_env "DB_HOST"          "$DB_HOST"
update_env "DB_PORT"          "$DB_PORT"
update_env "DB_DATABASE"      "$DB_DATABASE"
update_env "DB_USERNAME"      "$DB_USERNAME"
update_env "DB_PASSWORD"      "$DB_PASSWORD"
update_env "SESSION_DRIVER"   "$SESSION_DRIVER"
update_env "QUEUE_CONNECTION" "$QUEUE_CONNECTION"
update_env "CACHE_STORE"      "$CACHE_STORE"
update_env "MAIL_MAILER"      "$MAIL_MAILER"

# ── 3. Generate APP_KEY if still blank ────────────────────────────────────
if grep -q "^APP_KEY=$" /var/www/html/.env; then
    php /var/www/html/artisan key:generate --force
fi

# ── 4. Wait for PostgreSQL (uses shell env var, not .env) ─────────────────
if [ -n "$DB_HOST" ] && [ "${DB_CONNECTION:-pgsql}" = "pgsql" ]; then
    echo "Waiting for PostgreSQL at ${DB_HOST}:${DB_PORT:-5432}..."
    until pg_isready -h "$DB_HOST" -p "${DB_PORT:-5432}" -q; do
        sleep 2
    done
    echo "PostgreSQL is ready."
fi

# ── 5. Run migrations ─────────────────────────────────────────────────────
php /var/www/html/artisan migrate --force

# ── 6. Create storage symlink (public/storage → storage/app/public) ───────
php /var/www/html/artisan storage:link --force

# ── 7. Cache config, routes & views ──────────────────────────────────────
php /var/www/html/artisan config:cache
php /var/www/html/artisan route:cache
php /var/www/html/artisan view:cache

# ── 7. Configure PHP-FPM unix socket ─────────────────────────────────────
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

# ── 8. Fix storage ownership ──────────────────────────────────────────────
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# ── 9. Launch supervisor (nginx + php-fpm + queue) ────────────────────────
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
