FROM mileschou/phalcon
RUN apt update
RUN yes | apt install beanstalkd git
RUN mkdir /var/beanstore
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN git clone https://Scary_Donetskiy@bitbucket.org/scary_develop/dockent.git /var/app
WORKDIR /var/app
RUN composer install --no-dev
CMD ["sh", "start.sh"]
EXPOSE 80