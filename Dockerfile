FROM php:8.2-apache

# Enable Apache mods
RUN a2enmod rewrite

# Copy project files
COPY . /var/www/html/

# Install extensions (pdo_mysql for MySQL)
RUN docker-php-ext-install pdo pdo_mysql

# Configure Apache to listen on Render's PORT
RUN sed -i "s/Listen 80/Listen \${PORT}/" /etc/apache2/ports.conf \
    && sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf

CMD ["apache2-foreground"]
