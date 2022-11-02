FROM php:7.3-apache

# put files
WORKDIR /var/www/html/
COPY ./src ./src
COPY ./style ./style
COPY ./templates ./templates
COPY docker-php.conf /etc/apache2/conf-available/docker-php.conf

RUN a2enmod headers

COPY ./configs/apache2.conf /etc/apache2/apache2.conf
COPY ./configs/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN mkdir upload
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql

# config permission
RUN chown -R root:www-data /var/www/html
RUN chmod 750 /var/www/html
RUN find . -type f -exec chmod 640 {} \;
RUN find . -type d -exec chmod 750 {} \;
# add write permission for upload file
RUN chmod g+w /var/www/html/upload/
RUN chmod +t -R /var/www/html/
RUN apt-get update && \
    apt-get install -y libimage-exiftool-perl
RUN apt-get install -y ncat

# RUN apt install php-mysql
# RUN service apache2 restart


EXPOSE 80
