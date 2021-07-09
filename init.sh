#!/usr/bin/env bash

set -x \
&& rm -rf /etc/nginx \
&& rm -rf /etc/supervisor \
&& mkdir /run/php

set -x \
&& cp -r "/usr/share/container_config/nginx" /etc/nginx \
&& cp -r "/usr/share/container_config/supervisor" /etc/supervisor

BOX_TIMEZONE_SED=${BOX_TIMEZONE//\//\\\/}
BOX_TIMEZONE_SED=${BOX_TIMEZONE_SED//\./\\\.}
QUEUE_URL_SED=${QUEUE_URL//\//\\\/}
QUEUE_URL_SED=${QUEUE_URL_SED//\./\\\.}
QUEUE_BACK_URL_SED=${QUEUE_BACK_URL//\//\\\/}
QUEUE_BACK_URL_SED=${QUEUE_BACK_URL_SED//\./\\\.}
PG_HOST_SED=${PG_HOST//\//\\\/}
PG_HOST_SED=${PG_HOST_SED//\./\\\.}
PG_REAL_HOST_SED=${PG_REAL_HOST//\//\\\/}
PG_REAL_HOST_SED=${PG_REAL_HOST_SED//\./\\\.}
PG_PASSWORD_SED=${PG_PASSWORD//\//\\\/}
PG_PASSWORD_SED=${PG_PASSWORD_SED//\./\\\.}
BOX_ADMIN_SECRET_SED=${BOX_ADMIN_SECRET//\//\\\/}
BOX_ADMIN_SECRET_SED=${BOX_ADMIN_SECRET_SED//\./\\\.}
PG_SLAVES_SED=${PG_SLAVES//\//\\\/}
PG_SLAVES_SED=${PG_SLAVES_SED//\./\\\.}
BOX_INSTANCES_SED=${BOX_INSTANCES//\//\\\/}
BOX_INSTANCES_SED=${BOX_INSTANCES_SED//\./\\\.}

sed -i "s/error_log = \/var\/log\/php7.4-fpm.log/error_log = \/dev\/stdout/g" /etc/php/7.4/fpm/php-fpm.conf
sed -i "s/;error_log = syslog/error_log = \/dev\/stdout/g" /etc/php/7.4/fpm/php.ini
sed -i "s/;error_log = syslog/error_log = \/dev\/stdout/g" /etc/php/7.4/cli/php.ini
sed -i "s/log_errors = Off/log_errors = On/g" /etc/php/7.4/cli/php.ini
sed -i "s/log_errors = Off/log_errors = On/g" /etc/php/7.4/fpm/php.ini
sed -i "s/log_errors_max_len = 1024/log_errors_max_len = 0/g" /etc/php/7.4/cli/php.ini
sed -i "s/user = www-data/user = box/g" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/group = www-data/group = box/g" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/pm = dynamic/pm = static/g" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/pm.max_children = 5/pm.max_children = ${PHP_PM_MAX_CHILDREN}/g" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/;pm.max_requests = 500/pm.max_requests = ${PHP_PM_MAX_REQUESTS}/g" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/listen.owner = www-data/listen.owner = box/g" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/listen.group = www-data/listen.group = box/g" /etc/php/7.4/fpm/pool.d/www.conf
sed -i "s/;catch_workers_output = yes/catch_workers_output = yes/g" /etc/php/7.4/fpm/pool.d/www.conf

if [ $DEV != 'true' ]; then
  sed -i "s/BOX_FETCH_LIMIT/$BOX_FETCH_LIMIT/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/\$this->addResources(__DIR__ \. '\/\.\.\/env\.php');//g" /opt/box/src/Application.php
  sed -i "s/'TEST'/$TEST/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/BOX_TIMEZONE/$BOX_TIMEZONE_SED/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/BOX_ADMIN_USER/$BOX_ADMIN_USER/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/BOX_ADMIN_SECRET/$BOX_ADMIN_SECRET_SED/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/BOX_INSTANCES/$BOX_INSTANCES_SED/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/'BOX_IS_SYSTEM'/$BOX_IS_SYSTEM/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/QUEUE_URL/$QUEUE_URL_SED/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/QUEUE_BACK_URL/$QUEUE_BACK_URL_SED/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/QUEUE_WORKER/$QUEUE_WORKER/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/PG_HOST/$PG_HOST_SED/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/PG_SLAVES/$PG_SLAVES_SED/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/PG_REAL_HOST/$PG_REAL_HOST_SED/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/PG_PORT/$PG_PORT/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/PG_DATABASE/$PG_DATABASE/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/PG_SCHEMA/$PG_SCHEMA/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/PG_USER/$PG_USER/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/PG_PASSWORD/$PG_PASSWORD_SED/g" /opt/box/src/Resource/config/resources_shared.php
  sed -i "s/PG_HOST/$PG_HOST_SED/g" /opt/box/src/Resource/propel/connection/propel.php
  sed -i "s/PG_PORT/$PG_PORT/g" /opt/box/src/Resource/propel/connection/propel.php
  sed -i "s/PG_DATABASE/$PG_DATABASE/g" /opt/box/src/Resource/propel/connection/propel.php
  sed -i "s/PG_SCHEMA/$PG_SCHEMA/g" /opt/box/src/Resource/propel/connection/propel.php
  sed -i "s/PG_USER/$PG_USER/g" /opt/box/src/Resource/propel/connection/propel.php
  sed -i "s/PG_PASSWORD/$PG_PASSWORD_SED/g" /opt/box/src/Resource/propel/connection/propel.php
fi

if [ $DEV = 'true' ]; then
  set -x \
  && cd /opt/box \
  && cp env.example.php env.php \
  && cp propel.example.php propel.php
fi

set -x \
&& cd /opt/box \
&& sudo -u box php cli box startup

touch /node_status_inited
