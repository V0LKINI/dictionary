FROM php:8.3.11-fpm
LABEL authors="Kirill Volkov"

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN curl -s https://deb.nodesource.com/setup_18.x
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql bcmath gd

# Copy php.ini
COPY ./docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user
