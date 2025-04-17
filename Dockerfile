# Usa un'immagine base con PHP e Apache
FROM php:8.2-apache

# Copia tutti i file nella root del container web
COPY . /var/www/html/

# Dai i permessi corretti
RUN chown -R www-data:www-data /var/www/html

# Esponi la porta 80
EXPOSE 80
