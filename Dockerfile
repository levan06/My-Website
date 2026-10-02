FROM php:8.1-cli

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo_pgsql pgsql && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY . .

CMD sh -c "php -S 0.0.0.0:${PORT}"