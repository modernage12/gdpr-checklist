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
  
# Imposta il livello di log di PHP  
RUN echo "log_errors = On"  
RUN echo "error_log = /var/log/php-error.log"  
RUN echo "display_errors = Off"  
RUN echo "display_startup_errors = Off"  
RUN echo "error_reporting = E_ALL"  
  
# Copia il file .env.render come .env  
RUN cp .env.render .env  
  
# Installa le dipendenze PHP  
RUN composer install --no-dev --optimize-autoloader  
  
# Debug: Verifica che le dipendenze siano state installate correttamente  
RUN ls -la /var/www/html/vendor/  
RUN ls -la /var/www/html/vendor/autoload.php  
RUN ls -la /var/www/html/vendor/laravel/  
  
# Installa le dipendenze Node.js e builda gli asset  
RUN npm install --legacy-peer-deps && npm run build  
  
# Genera la chiave dell'applicazione  
RUN php artisan key:generate --force  
  
# Ottimizza Laravel  
RUN php artisan config:cache  
RUN php artisan route:cache  
RUN php artisan view:cache  
  
EXPOSE 80  
  
# Avvia supervisord con il file di configurazione personalizzato  
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"] 
