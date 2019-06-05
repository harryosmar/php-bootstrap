FROM php:7.2.14-fpm

CMD ["php", "/var/www/console.php", "kafka:consumer"]