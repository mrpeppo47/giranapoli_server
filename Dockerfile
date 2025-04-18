FROM php:8.2-apache

# Installa estensione mysqli
RUN docker-php-ext-install mysqli

# Imposta simulatore.php come file di default
RUN echo 'DirectoryIndex simulatore.php' > /etc/apache2/conf-available/custom-index.conf && \
    a2enconf custom-index

# Copia tutti i file nel container
COPY . /var/www/html/

# Dai i permessi corretti
RUN chown -R www-data:www-data /var/www/html

# Espone la porta 80
EXPOSE 80
