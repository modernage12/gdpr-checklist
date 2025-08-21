FROM richarvey/nginx-php-fpm:latest  
  
# Installa Node.js e npm  
RUN apk add --no-cache nodejs npm  
  
# Copia i file dell'applicazione  
COPY . /var/www/html/  
  
WORKDIR /var/www/html  
  
# Installa le dipendenze PHP  
RUN composer install --no-dev --optimize-autoloader  
  
# Installa le dipendenze Node.js e builda gli asset  
RUN npm install --legacy-peer-deps && npm run build  
  
# Ottimizza Laravel  
RUN php artisan config:cache  
RUN php artisan route:cache  
RUN php artisan view:cache  
  
EXPOSE 80  
  
# Avvia supervisord  
CMD ["supervisord"] 
