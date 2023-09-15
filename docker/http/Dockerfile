FROM debian:latest
ENV APP_USERID=1000
ENV APP_GROUPID=1000

RUN apt update && apt install -y locales fish vim nginx sudo python3-flask-cors \
    composer php php-bcmath php-bz2 php-common php-curl php-enchant php-fpm php-gd \
    php-intl php-json php-mbstring php-mysql php-odbc php-pgsql php-readline \
    php-sqlite3 php-tidy php-xml php-zip php-imagick php-mcrypt php-memcache \
    php-memcached php-mongodb php-pear php-redis nodejs npm python3-flask \
    imagemagick mariadb-client
RUN rm -rf /var/lib/apt/lists/*
RUN localedef -i pt_BR -c -f UTF-8 -A /usr/share/locale/locale.alias pt_BR.UTF-8
ENV LANG pt_BR.utf8
RUN useradd -u ${APP_USERID} -G sudo -m -s /usr/bin/fish app
RUN echo "app ALL = NOPASSWD: /usr/sbin/service" >>/etc/sudoers
RUN echo "app ALL = NOPASSWD: /usr/sbin/nginx" >>/etc/sudoers
RUN echo "app ALL = NOPASSWD: /usr/sbin/php-fpm8.2" >>/etc/sudoers
COPY entrypoint.py /usr/bin/entrypoint
COPY nginx.conf /etc/nginx/nginx.conf
COPY php-fpm.ini /etc/php/8.2/fpm/php-fpm.conf
COPY policy.xml /etc/ImageMagick-6/policy.xml
USER app
WORKDIR /home/app
ENTRYPOINT [ "/usr/bin/entrypoint" ]
