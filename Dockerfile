# Gunakan image PHP 8.2 dengan ekstensi yang dibutuhkan Laravel
FROM php:8.2-apache

# Install dependensi sistem
RUN apt-get update && apt-get install -y \
    git zip unzip libpq-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Aktifkan mod_rewrite untuk Laravel
RUN a2enmod rewrite

# Copy file aplikasi ke dalam container
COPY . /var/www/html

# Atur working directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install semua dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Set permission untuk storage & bootstrap
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Jalankan Laravel dengan Apache
EXPOSE 80
CMD ["apache2-foreground"]
