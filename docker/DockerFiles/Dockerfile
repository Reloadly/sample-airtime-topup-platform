FROM php:8.1.2-apache

# Environment variables
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV APP_ROOT /var/www/html/
ENV APPLICATION_USER "application"
ENV APPLICATION_USER_ID "1000"
ENV APPLICATION_GROUP "application"
ENV APPLICATION_GROUP_ID "1000"
ENV NODE_VERSION=16.14.0
ENV NVM_VERSION=v0.39.1
ENV NVM_DIR=/usr/local/nvm
ENV PATH ${PATH}:${APP_ROOT}/bin:${APP_ROOT}/scripts:${APP_ROOT}/app

RUN a2enmod rewrite expires include deflate proxy headers ssl
RUN a2ensite default-ssl
RUN mkdir -p /usr/share/man/man1/ /usr/share/man/man7/
RUN apt-get update
RUN apt-get install -y --no-install-recommends \
        sshpass \
        libpng-dev \
        libjpeg-dev \
        libwebp-dev \
        libjpeg62-turbo-dev \
        libxpm-dev \
        libfreetype6-dev \
        libpq-dev \
        libmcrypt-dev \
        libldap2-dev \
        libldb-dev \
        libicu-dev \
        libgmp-dev \
        libmagickwand-dev \
        libxml2-dev \
        libzip-dev \
        build-essential \
        libssl-dev \
        openssh-server \
        ca-certificates \
        python2.7 \
        git \
        vim \
        nano \
        curl \
        wget \
        rsync \
        unzip \
        inetutils-ping \
        tcptraceroute \
        screen \
        bash-completion \
        mariadb-client \
        postgresql-client \
        ssl-cert \
        cron
RUN update-alternatives --install /usr/bin/python python /usr/bin/python2.7 1
RUN ln -s /usr/lib/x86_64-linux-gnu/libldap.so /usr/lib/libldap.so \
    && ln -s /usr/lib/x86_64-linux-gnu/liblber.so /usr/lib/liblber.so \
    && ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/include/gmp.h \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN docker-php-ext-configure gd \
    --with-webp \
    --with-jpeg \
    --with-xpm \
    --with-freetype
RUN docker-php-ext-install gd \
    mysqli \
    opcache \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    ldap \
    intl \
    gmp \
    zip \
    bcmath \
    pcntl \
    xml \
    simplexml \
    exif \
    soap \
    sysvsem
#add sockets to above command after 8.1.3 this bellow command is a workaround to an open issue with php 8.1.2
RUN CFLAGS="$CFLAGS -D_GNU_SOURCE" docker-php-ext-install sockets
RUN make-ssl-cert generate-default-snakeoil

COPY ./docker/etc/motd /etc/motd
COPY ./docker/etc/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY ./docker/etc/vhost-ssl.conf /etc/apache2/sites-available/default-ssl.conf
COPY ./docker/etc/init_container.sh /bin/

RUN chmod 777 /var/log \
    && chmod 777 /var/run \
    && chmod 777 /var/lock \
    && chmod 777 /bin/init_container.sh

RUN { \
            echo 'opcache.memory_consumption=128'; \
            echo 'opcache.interned_strings_buffer=8'; \
            echo 'opcache.max_accelerated_files=4000'; \
            echo 'opcache.revalidate_freq=0'; \
            echo 'opcache.fast_shutdown=1'; \
            echo 'opcache.enable_cli=1'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini

RUN { \
            echo 'error_log=/var/log/apache2/php-error.log'; \
            echo 'display_errors=Off'; \
            echo 'log_errors=On'; \
            echo 'display_startup_errors=Off'; \
            echo 'date.timezone=Europe/Berlin'; \
    } > /usr/local/etc/php/conf.d/php.ini

RUN echo '* * * * * root php /var/www/html/artisan schedule:run >> /tmp/artisan_log' >> /etc/crontab

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install nodejs / npm via nvm
RUN mkdir -p $NVM_DIR \
    && curl https://raw.githubusercontent.com/creationix/nvm/$NVM_VERSION/install.sh | bash \
    && . $NVM_DIR/nvm.sh \
    && nvm install $NODE_VERSION \
    && nvm alias default $NODE_VERSION \
    && nvm use default \
    && npm install gulp -g \
    && npm install jspm -g

# Setup bashrc
RUN echo | tee -a /etc/skel/.bashrc >> /etc/bash.bashrc \
    && echo ". /etc/profile.d/dockerenv.sh" | tee -a /etc/skel/.bashrc >> /etc/bash.bashrc \
    && echo "cd \$APP_ROOT" | tee -a /etc/skel/.bashrc >> /etc/bash.bashrc \
    && echo ". \$NVM_DIR/nvm.sh" | tee -a /etc/skel/.bashrc >> /etc/bash.bashrc \
    && echo | tee -a /etc/skel/.bashrc >> /etc/bash.bashrc

# Create user
RUN groupadd -g $APPLICATION_GROUP_ID $APPLICATION_GROUP \
    && useradd -m -s /bin/bash -u $APPLICATION_USER_ID -g $APPLICATION_GROUP $APPLICATION_USER

# SSL CERTIFICATE FOR HTTPS

RUN mkdir /etc/apache2/ssl \
    && openssl req -new -newkey rsa:4096 -days 3650 -nodes -x509 -subj \
    "/C=PK/ST=PUNJAB/L=LAHORE/O=OTIF Solutions/CN=localhost" \
    -keyout /etc/apache2/ssl/ssl.key -out /etc/apache2/ssl/ssl.crt

WORKDIR ${APP_ROOT}

ENTRYPOINT ["/bin/init_container.sh"]
