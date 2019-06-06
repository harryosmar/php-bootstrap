FROM php:7.2.14-fpm

RUN apt-get update && apt-get install -y \
  git \
  zlib1g-dev \
  unzip

# Install librdkafka
RUN cd /tmp \
  && mkdir librdkafka \
  && cd librdkafka \
  && git clone https://github.com/edenhill/librdkafka.git --depth=1 . \
  && ./configure \
  && make \
  && make install \
  && rm -r /var/lib/apt/lists/*

# PHP Extensions
RUN docker-php-ext-install -j$(nproc) zip \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka

CMD ["php", "/var/www/console.php", "kafka:consumer"]