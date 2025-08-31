# Imagem base com Apache + PHP 8.1
FROM php:8.1-apache

# Instalar dependências necessárias para extensões PHP
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql mysqli mbstring gd curl zip xml \
    && rm -rf /var/lib/apt/lists/*
# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configurar pasta do projeto
WORKDIR /var/www/html

# Copiar os arquivos do Laravel para dentro do container
COPY . .

# Instalar dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Dar permissão para a pasta de cache e logs
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Habilitar mod_rewrite no Apache (necessário para Laravel)
RUN a2enmod rewrite
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

# Expõe a porta 80
EXPOSE 80

# Rodar o Apache no foreground
CMD ["apache2-foreground"]
