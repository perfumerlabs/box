FROM ubuntu:bionic

LABEL authors="Ilyas Makashev mehmatovec@gmail.com"

ENV TZ 'UTC'

RUN set -x \
    && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone \
    && apt-get update \
    && apt-get install -y \
        ca-certificates \
        wget \
        locales \
        gnupg2 \
    && rm -rf /var/lib/apt/lists/* \
    && useradd -s /bin/bash -m box \
    && echo "deb http://nginx.org/packages/ubuntu/ bionic nginx" > /etc/apt/sources.list.d/nginx.list \
    && echo "deb-src http://nginx.org/packages/ubuntu/ bionic nginx" >> /etc/apt/sources.list.d/nginx.list \
    && echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu bionic main" > /etc/apt/sources.list.d/php.list \
    && echo "deb-src http://ppa.launchpad.net/ondrej/php/ubuntu bionic main" >> /etc/apt/sources.list.d/php.list \
    && apt-key adv --keyserver keyserver.ubuntu.com --recv-keys ABF5BD827BD9BF62 \
    && apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 4F4EA0AAE5267A6C \
    && apt update \
    && apt install -y \
        nginx \
        php7.4 \
        php7.4-cli \
        php7.4-common \
        php7.4-curl \
        php7.4-fpm \
        php7.4-json \
        php7.4-opcache \
        php7.4-pgsql \
        php7.4-xml \
        php7.4-mbstring \
        supervisor \
        vim \
        iputils-ping \
        curl \
        git \
        zip \
        sudo \
        apt-transport-https

COPY project /opt/box
COPY nginx /usr/share/container_config/nginx
COPY supervisor /usr/share/container_config/supervisor
COPY init.sh /usr/local/bin/init.sh
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

RUN set -x\
    && chown -R box:box /opt/box \
    && cd /opt/box \
    && sudo -u box php composer.phar install --prefer-dist \
    && chmod +x /usr/local/bin/entrypoint.sh \
    && chmod +x /usr/local/bin/init.sh

ENV BOX_TIMEZONE "Utc"
ENV BOX_FETCH_LIMIT 100
ENV BOX_ADMIN_USER user
ENV BOX_ADMIN_SECRET secret
ENV BOX_INSTANCES ''
ENV BOX_IS_SYSTEM 'false'
ENV QUEUE_URL "http://queue"
ENV QUEUE_WORKER "box"
ENV QUEUE_BACK_URL "http://box"
ENV PG_REAL_HOST postgresql
ENV PG_HOST postgresql
ENV PG_PORT 5432
ENV PG_SLAVES ''
ENV PG_DATABASE box
ENV PG_SCHEMA public
ENV PG_USER postgres
ENV PG_PASSWORD postgres
ENV PHP_PM_MAX_CHILDREN 10
ENV PHP_PM_MAX_REQUESTS 500
ENV TEST false
ENV DEV false

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]