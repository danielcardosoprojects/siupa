# Etapa 1: PHP + Composer para instalar dependências
FROM composer:2 AS vendor
WORKDIR /app
COPY siiupa/composer.json siiupa/composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader

# Etapa 2: PHP-FPM + Nginx
FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Definir pasta de trabalho
WORKDIR /var/www/html

# Copiar código Laravel (está dentro de /siiupa)
COPY siiupa . 

# Copiar dependências do Composer
COPY --from=vendor /app/vendor ./vendor

# Copiar configuração do Nginx
COPY ./nginx.conf /etc/nginx/sites-available/default

# Permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Expor porta
EXPOSE 80

# Comando para rodar Nginx + PHP-FPM juntos
CMD service nginx start && php-fpm
