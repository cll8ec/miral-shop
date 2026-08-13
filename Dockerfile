FROM php:8.4-fpm

# تثبيت متطلبات النظام ولارافيل
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# تنظيف الكاش

# تثبيت امتدادات PHP لقاعدة البيانات
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# نسخ Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD ["php-fpm","-F"]