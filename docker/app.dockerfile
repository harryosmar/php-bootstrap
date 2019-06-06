FROM php:7.2.14-fpm

RUN apt-get update && apt-get install -y \
    software-properties-common \
    apt-utils \
    build-essential \
    gnupg2 \
    wget \
    libcurl3-gnutls \
    apt-transport-https


RUN wget -qO - https://packages.confluent.io/deb/5.2/archive.key | apt-key add - \
  && add-apt-repository "deb [arch=amd64] https://packages.confluent.io/deb/5.2 stable main" \
  && apt-get update \
  && apt-get install \
    libssl1.0.0 \
    librdkafka1 \
    librdkafka-dev
