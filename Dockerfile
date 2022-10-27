FROM php:8.1-fpm

ENV USER=www
ENV GROUP=www

COPY composer.lock composer.json /var/www/html/

WORKDIR /var/www/html/


# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Postgre PDO
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# Get latest Composer
# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Setup working directory
#WORKDIR /var/www/

# Create User and Group
RUN groupadd -g 1000 ${GROUP} && useradd -u 1000 -ms /bin/bash -g ${GROUP} ${USER}

# Grant Permissions
RUN chown -R ${USER} /var/www/html/

# Select User
USER ${USER}

COPY . /var/www/html/

# Copy permission to selected user
COPY --chown=${USER}:${GROUP} . .

EXPOSE 9000

CMD ["php-fpm"]


