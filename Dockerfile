# ──────────────────────────────────────────────
#  Stage 1 – Node: build frontend assets
# ──────────────────────────────────────────────
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci --prefer-offline

COPY resources/ resources/
COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY public/ public/

RUN npm run build

# ──────────────────────────────────────────────
#  Stage 2 – PHP: install Composer dependencies
# ──────────────────────────────────────────────
FROM composer:2.8 AS composer-builder

WORKDIR /app

COPY composer.json composer.lock ./
# Install production deps only (no dev)
RUN composer install \
      --no-dev \
      --no-interaction \
      --no-progress \
      --optimize-autoloader \
      --prefer-dist

COPY . .

# ──────────────────────────────────────────────
#  Stage 3 – Final runtime image
# ──────────────────────────────────────────────
FROM php:8.2-fpm-alpine AS runtime

# ---- system packages & PHP extensions --------
RUN apk add --no-cache \
      nginx \
      postgresql-client \
      libpq-dev \
      libpng-dev \
      libjpeg-turbo-dev \
      freetype-dev \
      libzip-dev \
      zip \
      unzip \
      curl \
      supervisor \
    && docker-php-ext-configure gd \
         --with-freetype \
         --with-jpeg \
    && docker-php-ext-install \
         pdo \
         pdo_pgsql \
         pgsql \
         gd \
         zip \
         opcache \
         bcmath \
         pcntl \
    && rm -rf /var/cache/apk/*

# ---- copy application code -------------------
WORKDIR /var/www/html

COPY --from=composer-builder /app /var/www/html
COPY --from=node-builder     /app/public/build /var/www/html/public/build

# ---- nginx config ----------------------------
COPY docker/nginx.conf /etc/nginx/nginx.conf

# ---- supervisor config -----------------------
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ---- permissions & storage -------------------
RUN mkdir -p storage/logs \
             storage/framework/cache/data \
             storage/framework/sessions \
             storage/framework/views \
             bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# ---- entrypoint script -----------------------
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]
