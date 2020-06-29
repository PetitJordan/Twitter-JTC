FROM php:7.2.3-fpm

# Install cron
RUN apt-get update && apt-get install -y cron

# Add files
ADD crontab.sh /crontab.sh
ADD entrypoint.sh /entrypoint.sh
 
RUN chmod +x /crontab.sh /entrypoint.sh

RUN docker-php-ext-install pdo_mysql

ENTRYPOINT /entrypoint.sh