FROM richarvey/nginx-php-fpm:latest  
  
# Installa Node.js e npm  
RUN apk add --no-cache nodejs npm  
  
# Copia i file dell'applicazione  
COPY . /var/www/html/  
  
# Copia il file di configurazione di Supervisor  
COPY supervisor/supervisord.conf /etc/supervisord.conf  
  
# Copia il file di configurazione di PHP-FPM  
COPY php-fpm/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf  
  
# Copia il file di configurazione di nginx  
COPY nginx/default.conf /etc/nginx/sites-enabled/default.conf  
  
WORKDIR /var/www/html  
  
# Crea directory necessarie  
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache  
  
# Imposta i permessi corretti  
RUN chmod -R 775 storage bootstrap/cache  
RUN chown -R www-data:www-data storage bootstrap/cache  
  
# Crea i link simbolici per i log  
RUN ln -sf /dev/stdout /var/log/access.log  
RUN ln -sf /dev/stderr /var/log/error.log  
RUN ln -sf /dev/stderr /var/log/php-fpm-error.log  
  
# Installa le dipendenze PHP  
RUN composer install --no-dev --optimize-autoloader  
  
# Installa le dipendenze Node.js e builda gli asset  
RUN npm install --legacy-peer-deps && npm run build  
  
# Ottimizza Laravel  
RUN php artisan config:cache  
RUN php artisan route:cache  
RUN php artisan view:cache  
  
# Crea un health check endpoint  
RUN echo "<?php http_response_code(200); echo 'OK';" > public/health.php  
  
EXPOSE 80  
  
# Avvia supervisord con il file di configurazione personalizzato  
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"] 
