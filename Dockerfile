FROM richarvey/nginx-php-fpm:latest  
  
COPY . /var/www/html/  
  
WORKDIR /var/www/html  
  
RUN composer install --no-dev --optimize-autoloader  
RUN npm install --legacy-peer-deps && npm run build  
  
RUN php artisan config:cache  
RUN php artisan route:cache  
RUN php artisan view:cache  
  
EXPOSE 80  
  
CMD [\"supervisord\", \"-c\", \"/etc/supervisor/conf.d/supervisord.conf\"] 
COPY nginx/default.conf /etc/nginx/sites-available/default 
