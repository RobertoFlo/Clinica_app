FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www
# Argumentos definidos en docker-compose.yml
ARG UID
ARG GID
# Install system dependencies & PHP extensions' dependencies
# This is the key fix: adding -dev libraries for the PHP extensions
RUN apt-get update && apt-get install -y \
    build-essential \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    libexif-dev \
    default-libmysqlclient-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*


# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl
# Configure and install GD extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Cambiar el UID y GID de www-data para que coincida con el del usuario anfitrión
# Esta es la parte clave para resolver el problema de permisos
# RUN usermod -u ${UID} www-data && groupmod -g ${GID} www-data

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application code
COPY . /var/www

# # Set correct permissions for storage and bootstrap cache
# RUN chown -R 777 www-data:www-data /var/www/storage /var/www/bootstrap/cache

# # Change current user to www
# USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
