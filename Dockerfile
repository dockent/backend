FROM mileschou/phalcon
RUN apt update
RUN apt install -y beanstalkd git zlib1g-dev libicu-dev libyaml-dev wget
RUN mkdir /var/beanstore
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN docker-php-ext-install intl
RUN docker-php-ext-install zip
RUN docker-php-ext-install sockets
WORKDIR /usr/src/php/ext
RUN wget https://pecl.php.net/get/yaml-2.0.2.tgz
RUN tar -xvf yaml-2.0.2.tgz
RUN rm yaml-2.0.2.tgz
RUN mv yaml-2.0.2 yaml
RUN docker-php-ext-install yaml
WORKDIR /
RUN git clone https://Scary_Donetskiy@bitbucket.org/scary_develop/dockent.git /var/app
WORKDIR /var/app
RUN composer install --no-dev
RUN composer update --no-dev
CMD ["sh", "start.sh"]
EXPOSE 8080