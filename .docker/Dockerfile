FROM devilbox/php-fpm-8.0:latest 

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync

RUN DEBIAN_FRONTEND=noninteractive apt-get update && apt-get upgrade -y -q \
    && DEBIAN_FRONTEND=noninteractive apt-get install -qq -y \
      build-essential \
      mariadb-client \
      curl \
      git \
      vim \
      zip unzip \
      redis-server \
      libhiredis-dev \
      autoconf \
      nginx-extras \
    && install-php-extensions \
      uuid \
      gmp \
      amqp \
      yaml \
      bcmath \
      ctype \
      bz2 \
      gd \
      json \
      intl \
      pcntl \
      ldap \
      fileinfo \
      mysqli \
      openssl \
      pdo_mysql \
      pdo_sqlite \
      pgsql \
      redis \
      soap \
      xsl \
      zip \
      sockets \
      tokenizer \
      xml

RUN yes | pecl install xdebug  \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.xdebug.discover_client_host=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=VSCODE" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && rm -rf /tmp/*

RUN echo "memory_limit=-1" > $PHP_INI_DIR/conf.d/memory-limit.ini
COPY php/php.ini /usr/local/etc/php/


RUN pecl channel-update pecl.php.net \
	&& pecl install #XDEBUG_VERSION#

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && ln -s $(composer config --global home) /root/composer
ENV PATH=$PATH:/root/composer/vendor/bin COMPOSER_ALLOW_SUPERUSER=1

RUN cd ~/ && git clone https://github.com/arnaud-lb/php-rdkafka.git && cd php-rdkafka && phpize

RUN cd ~/ && git clone https://github.com/edenhill/librdkafka.git && cd librdkafka && ./configure && make && make install && pecl install rdkafka

RUN echo "extension=rdkafka.so" > $PHP_INI_DIR/conf.d/php.ini

WORKDIR /app
