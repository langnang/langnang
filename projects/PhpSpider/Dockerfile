# 使用官方 PHP 镜像作为基础镜像
FROM php:7.4-fpm

# 安装扩展，例如 pdo_mysql 和 zip
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# 设置工作目录
WORKDIR /var/www/html

# 复制项目文件到容器中
COPY . .

# 安装 Composer 依赖
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader
