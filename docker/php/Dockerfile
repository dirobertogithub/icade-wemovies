FROM php:8.0.10-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    nodejs \
    npm \
    yarn \
    curl


# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www