# Use PHP with Nginx
FROM richarvey/nginx-php-fpm:3.1.6

# Copy your application code
COPY . .

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

# Allow Composer to run
ENV COMPOSER_ALLOW_SUPERUSER 1

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Fix permissions
RUN chown -R www-data:www-data /var/www/html

CMD ["/bin/sh", "-c", "php artisan migrate --force && /start.sh"]
