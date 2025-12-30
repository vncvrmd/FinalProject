# Use PHP with Nginx
FROM richarvey/nginx-php-fpm:3.1.6

# Allow Composer to run as superuser
ENV COMPOSER_ALLOW_SUPERUSER 1

# Copy your application code
COPY . .

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

# Clear cached files (use --no-interaction to avoid prompts)
# Note: cache:clear needs a driver, so we skip it during build
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear

# Fix permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage && \
    chmod -R 775 /var/www/html/bootstrap/cache

# Create scripts directory for startup scripts
RUN mkdir -p /var/www/html/scripts

# Create a startup script that runs migrations and caching after DB is available
RUN echo '#!/bin/sh' > /var/www/html/scripts/00-laravel-setup.sh && \
    echo 'php artisan migrate --force' >> /var/www/html/scripts/00-laravel-setup.sh && \
    echo 'php artisan config:cache' >> /var/www/html/scripts/00-laravel-setup.sh && \
    echo 'php artisan route:cache' >> /var/www/html/scripts/00-laravel-setup.sh && \
    echo 'php artisan view:cache' >> /var/www/html/scripts/00-laravel-setup.sh && \
    chmod +x /var/www/html/scripts/00-laravel-setup.sh

CMD ["/start.sh"]
