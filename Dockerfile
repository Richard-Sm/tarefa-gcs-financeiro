# Usa a imagem oficial do PHP 8.3 com Apache
FROM php:8.3-apache

# Instala as ferramentas e extensões do sistema necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    zip \
    unzip \
    git

# Instala extensões do PHP necessárias para o Laravel e Banco
RUN docker-php-ext-install pdo_mysql zip

# Habilita o módulo de reescrita de URL do Apache
RUN a2enmod rewrite

# Instala o Composer (Gerenciador de pacotes do PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define onde o site vai ficar dentro do contêiner
WORKDIR /var/www/html

# Copia todos os arquivos do seu projeto para o contêiner
COPY . .

# Ajusta as pastas públicas do Apache para a pasta "public" do Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Instala as dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Dá as permissões de pasta corretas
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
