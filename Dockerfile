# Usa PHP 8.2 con Apache
FROM php:8.2-apache

# Installa l'estensione mysqli
RUN docker-php-ext-install mysqli

# Copia i file nel container
COPY . /var/www/html/

# Dai i permessi corretti
RUN chown -R www-data:www-data /var/www/html

RUN echo 'DirectoryIndex simulatore.php' > /etc/apache2/conf-available/directoryindex.conf && \
    a2enconf directoryindex

# Esponi la porta 80
EXPOSE 80
