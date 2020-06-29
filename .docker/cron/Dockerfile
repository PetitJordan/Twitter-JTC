FROM php:7.2.3-fpm

# Install cron
RUN apt-get update && apt-get install -y dos2unix && apt-get install -y cron

# Add files
COPY crontab.sh /
COPY entrypoint.sh /

RUN chmod +x /crontab.sh /entrypoint.sh

RUN dos2unix /entrypoint.sh
RUN dos2unix /crontab.sh

RUN docker-php-ext-install pdo_mysql

ENTRYPOINT ["/entrypoint.sh"]