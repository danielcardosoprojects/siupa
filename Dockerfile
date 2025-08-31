# Usar PHP 8.1 com Apache
FROM php:8.1-apache

# Copiar todos os arquivos
COPY . /var/www/html/

# Habilitar mod_rewrite para URLs amigáveis
RUN a2enmod rewrite

# Configurar Apache para processar .htaccess
RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/htaccess.conf

RUN a2enconf htaccess

# Instalar extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql mysqli mbstring gd curl zip xml

# Permissões corretas
RUN chown -R www-data:www-data /var/www/html/

# Expor porta padrão do Apache
EXPOSE 80

# Rodar Apache em foreground
CMD ["apache2-foreground"]
