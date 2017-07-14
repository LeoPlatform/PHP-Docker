FROM php:7.0-cli
RUN apt-get update
RUN apt-get install -y apt-utils
RUN apt-get install -y python3
RUN apt-get install -y python3-pip
RUN pip3 install --upgrade --user awscli
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp
RUN curl -sS https://getcomposer.org/installer | php
RUN php composer.phar install