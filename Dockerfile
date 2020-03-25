FROM mileschou/phalcon
RUN apt-get update
RUN apt-get install -y beanstalkd zlib1g-dev libzip-dev libicu-dev libyaml-dev git supervisor
RUN mkdir /var/beanstore
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN docker-php-ext-install zip sockets intl
RUN printf "\n" | pecl install yaml
RUN docker-php-ext-enable yaml
ADD . /app
WORKDIR /app
RUN mkdir -p /var/log/supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN composer install --no-dev
RUN composer frontend
CMD ["/usr/bin/supervisord"]
EXPOSE 8080