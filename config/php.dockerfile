FROM php:7.0-fpm

RUN apt-get update

RUN pecl channel-update pecl.php.net

RUN apt-get install -y  \
    autoconf g++ make \
    openssl libssl-dev libcurl4-openssl-dev \
    pkg-config libsasl2-dev libpcre3-dev \
    unzip libaio-dev \
    && rm -rf /var/lib/apt/lists/*;

# MongoDB
RUN pecl install mongodb \
  && docker-php-ext-enable mongodb
