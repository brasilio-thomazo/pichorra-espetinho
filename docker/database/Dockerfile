FROM alpine:latest

ENV APP_USERID=1000
ENV APP_GROUPID=1000
ENV ROOT_PASSWORD='root'
ENV REDIS_PASSWORD='redis'

ENV POSTGRESQL_USER='postgres'
ENV POSTGRESQL_PASSWORD='postgres'

RUN apk add --no-cache fish doas icu-data-full tzdata musl-locales \
    mariadb mariadb-client postgresql postgresql-contrib postgresql-jit \
    doas bash vim redis memcached
RUN cp /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime
RUN echo "America/Sao_Paulo" >/etc/timezone
RUN addgroup -g ${APP_GROUPID} app
RUN adduser -h /home/app -G app -u ${APP_USERID} -s /usr/bin/fish -D app
RUN mkdir -p /var/run/mysql /var/run/postgresql
RUN chown app:app /var/run/mysql /var/lib/mysql /var/run/postgresql /var/lib/postgresql /etc/postgresql
RUN echo 'permit app as root' >>/etc/doas.d/doas.conf
RUN echo 'permit nopass app as root' >>/etc/doas.d/doas.conf
RUN touch /etc/postgresql/pg_ident.conf
COPY my.ini /etc/my.cnf
COPY postgresql.conf /etc/postgresql/postgresql.conf
COPY pg_hba.conf /etc/postgresql/pg_hba.conf
COPY redis.conf /etc/redis.conf
COPY entrypoint /usr/bin/entrypoint
USER app
ENTRYPOINT [ "entrypoint" ]
