
FROM ubuntu
RUN apt-get update
RUN apt install apache2 -y
RUN apt install php libapache2-mod-php php-mysql -y


WORKDIR /var/www/html
RUN rm -rf *
COPY ./site/index.php .
EXPOSE 80

CMD ["apache2ctl", "-D", "FOREGROUND"]