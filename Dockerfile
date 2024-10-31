FROM leantime/leantime:latest

# Instala PHP, Phar e Curl usando os pacotes genéricos disponíveis
RUN apk update && \
    apk add --no-cache php php-phar curl && \
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Copia o código local para o container
WORKDIR /var/www/html
COPY . /var/www/html

# Instala as dependências do PHP
RUN composer install --no-interaction
