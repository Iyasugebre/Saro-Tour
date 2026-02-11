# Use official PHP image with Apache
FROM php:8.2-apache

# Copy project files into Apache web root
COPY . /var/www/html/

# Expose port (Render uses $PORT)
EXPOSE 10000
