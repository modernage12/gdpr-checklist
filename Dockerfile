FROM richarvey/nginx-php-fpm:latest  
  
# Installa Node.js, npm e Composer  
RUN apk add --no-cache nodejs npm curl  
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer  
  
# Copia i file dell'applicazione  
COPY . /var/www/html/  
  
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
RUN echo "error_log = /dev/stderr"  
RUN echo "display_errors = Off"  
RUN echo "display_startup_errors = Off"  
RUN echo "error_reporting = E_ALL"  
  
# Copia il file .env.render come .env  
RUN cp .env.render .env  
  
# Installa le dipendenze PHP  
RUN composer install --no-dev --optimize-autoloader  
  
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
