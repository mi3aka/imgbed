FROM php:7.3-apache

ENV TimeZone=Asia/Shanghai

RUN echo "mysql-server mysql-server/root_password password root" | debconf-set-selections && echo "mysql-server mysql-server/root_password_again password root" | debconf-set-selections

RUN ln -snf /usr/share/zoneinfo/$TimeZone /etc/localtime && echo $TimeZone > /etc/timezone; \
    sed -i 's/deb.debian.org/mirrors.aliyun.com/g' /etc/apt/sources.list \
    && sed -i 's/security.debian.org/mirrors.aliyun.com/g' /etc/apt/sources.list \
    && apt-get update;apt-get upgrade -y;apt-get install mariadb-server -y; \
    docker-php-ext-install mysqli \
    && pecl install xdebug-2.9.8 \
    && docker-php-ext-enable xdebug
COPY db_init.sh /tmp/db_init.sh
RUN chmod 700 /tmp/db_init.sh \
    && /tmp/db_init.sh \
    && rm /tmp/db_init.sh \
    && chown -R www-data:www-data /var/www/html/
CMD service apache2 restart & service mysql restart & tail -F /var/log/apache2/access.log;