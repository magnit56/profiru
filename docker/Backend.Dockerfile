FROM php:8.2-fpm
USER root
RUN mkdir /var/cache/profiru
RUN chmod -R 777 /var/cache/profiru
RUN chown -R www-data:www-data /var/cache/profiru
RUN touch /var/cache/profiru/urls.dat
RUN chmod 777 /var/cache/profiru/urls.dat
WORKDIR /var/www/project/backend
