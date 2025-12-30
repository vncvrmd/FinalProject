# Use PHP with Nginx
FROM richarvey/nginx-php-fpm:3.1.6

# Allow Composer to run as superuser
ENV COMPOSER_ALLOW_SUPERUSER 1

# Copy your application code
COPY . .

# Copy custom nginx config for Laravel routing
COPY conf/nginx/nginx-site.conf /etc/nginx/sites-available/default.conf
COPY conf/nginx/nginx-site.conf /etc/nginx/sites-enabled/default.conf

# Install dependencies BEFORE setting SKIP_COMPOSER
RUN composer install --no-dev --optimize-autoloader

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Set cache/session to file during build (no database available yet)
ENV CACHE_STORE file
ENV SESSION_DRIVER file

# Clear ALL cached files - start fresh
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear

# Fix permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage && \
    chmod -R 775 /var/www/html/bootstrap/cache

# Create scripts directory for startup scripts (richarvey image looks for /var/www/html/scripts/)
RUN mkdir -p /var/www/html/scripts

# Create a startup script that runs at container start
# Note: Don't cache routes - it can cause issues with dynamic URL generation
RUN printf '#!/bin/sh\nset -e\necho "Running Laravel setup..."\nphp artisan migrate --force || true\nphp artisan config:cache || true\nphp artisan view:cache || true\necho "Laravel setup complete!"\n' > /var/www/html/scripts/00-laravel-setup.sh && \
    chmod +x /var/www/html/scripts/00-laravel-setup.sh

CMD ["/start.sh"]
