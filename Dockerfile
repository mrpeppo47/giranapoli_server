# Usa la base PHP con Apache
FROM php:8.2-apache

# Installa le estensioni necessarie
RUN docker-php-ext-install mysqli

# Installa supervisord
RUN apt-get update && apt-get install -y supervisor

# Copia i file dell'applicazione
COPY . /var/www/html/

# Copia la configurazione di supervisord
COPY supervisord.conf /etc/supervisord.conf

# Dai i permessi
RUN chown -R www-data:www-data /var/www/html

# Espone la porta 80 per Apache
EXPOSE 80

# Avvia supervisord per gestire Apache e lo script PHP
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
