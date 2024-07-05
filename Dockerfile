# Usa una imagen base de PHP con Apache
FROM php:7.4-apache

# Instala dependencias necesarias
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    && docker-php-ext-install curl

# Copia el contenido de la carpeta public al directorio raíz del servidor web
COPY public/ /var/www/html/
COPY app/ /var/www/html/app/

# Copia la configuración personalizada de Apache
COPY apache-setup.conf /etc/apache2/conf-available/apache-setup.conf
RUN a2enconf apache-setup

# Exponer el puerto 80
EXPOSE 80
