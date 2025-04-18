FROM php:8.2-apache

# Installa mysqli
RUN docker-php-ext-install mysqli

# Copia i file
COPY . /var/www/html/

# Dai i permessi
RUN chown -R www-data:www-data /var/www/html

# Fa partire simulatore.php in background e poi Apache
CMD php /var/www/html/simulatore.php & apache2-foreground
