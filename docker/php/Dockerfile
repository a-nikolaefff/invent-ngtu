FROM php:8.2-fpm

# Get an UID and a GUI from the docker-compose.yml file
ARG UID
ARG GID

# Set the UID and the GUI as environment variables
ENV UID=${UID}
ENV GID=${GID}

# Install the necessary packages
RUN apt-get update && apt-get install -y \
    curl \
    git \
    zip \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Set the working directory to run the following commands
RUN mkdir -p /var/www/html
WORKDIR /var/www/html

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Remove an unnecessary dialout group
RUN delgroup dialout

# Create a new group and a new user
RUN addgroup --gid ${GID} --system laravel
RUN adduser --ingroup laravel --disabled-password --shell /bin/sh --uid ${UID} --system laravel

# Replace default user with admin user in configuration files
RUN sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf

# Add saving php errors to log file
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

# Xdebug
RUN pecl install xdebug \ && docker-php-ext-enable xdebug

# PostgreSQL
RUN docker-php-ext-install pgsql
RUN docker-php-ext-install pdo_pgsql

# MySQL
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql

USER laravel

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]

