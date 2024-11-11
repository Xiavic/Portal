# Use a base image with Apache and PHP 8.3
FROM php:8.3-apache

# Set environment variables for Apache and PHP
ENV APACHE_DOCUMENT_ROOT /var/www/html
ENV PHP_INI_DIR /usr/local/etc/php

ENV NODE_VERSION 20.12.2
ENV NVM_DIR /usr/local/nvm

ENV PATH="${NVM_DIR}/versions/node/v${NODE_VERSION}/bin:${PATH}"

# Install required packages for PHP and Apache
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mbstring mysqli pdo pdo_mysql xml

RUN mkdir -p $NVM_DIR
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
RUN . "${NVM_DIR}/nvm.sh" \
    && nvm install $NODE_VERSION \
    && nvm alias default $NODE_VERSION \
    && nvm use $NODE_VERSION

    # Set the working directory
WORKDIR $APACHE_DOCUMENT_ROOT

# Copy the application files to the working directory
COPY . .

# Set the Apache document root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Apache modules
RUN a2enmod rewrite

# Expose port 80 for Apache
EXPOSE 80

# Start Apache service
CMD ["apache2-foreground"]