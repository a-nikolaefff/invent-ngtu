FROM nginx:stable-alpine

# Get an UID and a GUI from the docker-compose.yml file
ARG UID
ARG GID

# Set the UID and the GUI as environment variables
ENV UID=${UID}
ENV GID=${GID}

# Remove an unnecessary dialout group
RUN delgroup dialout

# Create a new group and a new user
RUN addgroup --gid ${GID} --system laravel
RUN adduser --ingroup laravel --disabled-password --shell /bin/sh --uid ${UID} --system laravel

# Replace default user with admin user in configuration files
RUN sed -i "s/user  nginx/user laravel/g" /etc/nginx/nginx.conf

# Nginx config
ADD config/default.conf /etc/nginx/conf.d/

RUN mkdir -p /var/www/html