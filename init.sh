#!/usr/bin/env bash

set -x \
&& rm -rf /etc/nginx \
&& rm -rf /etc/supervisor \
&& mkdir /run/php

set -x \
&& cp -r "/usr/share/container_config/nginx" /etc/nginx \
&& cp -r "/usr/share/container_config/supervisor" /etc/supervisor

BOX_HOST_SED=${BOX_HOST//\//\\\/}
BOX_HOST_SED=${BOX_HOST_SED//\./\\\.}
PG_HOST_SED=${PG_HOST//\//\\\/}
PG_HOST_SED=${PG_HOST_SED//\./\\\.}
PG_PASSWORD_SED=${PG_PASSWORD//\//\\\/}
PG_PASSWORD_SED=${PG_PASSWORD_SED//\./\\\.}

sed -i "s/BOX_HOST/$BOX_HOST_SED/g" /etc/nginx/sites/box.conf

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

sed -i "s/BOX_HOST/$BOX_HOST_SED/g" /opt/box/src/Gateway.php
sed -i "s/BOX_FETCH_LIMIT/$BOX_FETCH_LIMIT/g" /opt/box/src/Resource/config/resources_shared.php
sed -i "s/PG_HOST/$PG_HOST_SED/g" /opt/box/src/Resource/config/resources_shared.php
sed -i "s/PG_PORT/$PG_PORT/g" /opt/box/src/Resource/config/resources_shared.php
sed -i "s/PG_DATABASE/$PG_DATABASE/g" /opt/box/src/Resource/config/resources_shared.php
sed -i "s/PG_USER/$PG_USER/g" /opt/box/src/Resource/config/resources_shared.php
sed -i "s/PG_PASSWORD/$PG_PASSWORD_SED/g" /opt/box/src/Resource/config/resources_shared.php
sed -i "s/PG_HOST/$PG_HOST_SED/g" /opt/box/src/Resource/propel/connection/propel.php
sed -i "s/PG_PORT/$PG_PORT/g" /opt/box/src/Resource/propel/connection/propel.php
sed -i "s/PG_DATABASE/$PG_DATABASE/g" /opt/box/src/Resource/propel/connection/propel.php
sed -i "s/PG_USER/$PG_USER/g" /opt/box/src/Resource/propel/connection/propel.php
sed -i "s/PG_PASSWORD/$PG_PASSWORD_SED/g" /opt/box/src/Resource/propel/connection/propel.php

set -x \
&& cd /opt/box \
&& sudo -u box php cli framework propel/migrate

touch /node_status_inited
