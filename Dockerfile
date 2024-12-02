FROM whatwedo/symfony:v2.8 AS base

# Store git commit as env variable
ARG GIT_COMMIT_SHORT_SHA=UNKNOWN
ENV GIT_COMMIT_SHORT_SHA=$GIT_COMMIT_SHORT_SHA

WORKDIR /var/www



########################################################################################################################
# Development stage (depencencies and configuration used in development only)
FROM base as dev

# Install dde development depencencies
# .dde/configure-image.sh will be created automatically
COPY .dde/configure-image.sh /tmp/dde-configure-image.sh
COPY docker/dev /
ARG DDE_UID
ARG DDE_GID
RUN /tmp/dde-configure-image.sh

RUN apk add --no-cache bash make php$PHP_VERSION\-pecl-xdebug php$PHP_VERSION\-pecl-pcov



########################################################################################################################
# Production: install dependencies
FROM base as composer

ADD . /var/www

RUN composer install --no-scripts --prefer-dist && \
    composer dump-autoload --optimize --classmap-authoritative



########################################################################################################################
# Production stage (depencencies and configuration used in production only)
FROM base as prod

COPY --from=composer /var/www /var/www/