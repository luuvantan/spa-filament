# Sử dụng image PHP 8.2 (khuyến nghị cho Laravel 11/Filament 3.3)
FROM php:8.2-fpm

# Cài đặt các phụ thuộc hệ thống
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    librdkafka-dev \
    zip \
    vim \
    sudo \
    unzip \
    gnupg2 \
    libmagickwand-dev \
    ghostscript \
    nginx \
    nodejs \
    npm \
    --no-install-recommends

# Xóa cache apt để giảm kích thước image
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Cài đặt các extension PHP
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions zip pdo_mysql mbstring exif pcntl bcmath gd sodium ftp ldap sockets gmp intl openssl

# Cài đặt Imagick (đã bỏ comment)
RUN pecl install imagick && docker-php-ext-enable imagick

# Cập nhật chính sách ImageMagick để cho phép xử lý PDF
RUN sed -i 's/<policy domain="coder" rights="none" pattern="PDF"/<policy domain="coder" rights="read|write" pattern="PDF"/' /etc/ImageMagick-6/policy.xml || true
RUN sed -i 's/<policy domain="coder" rights="none" pattern="PDF"/<policy domain="coder" rights="read|write" pattern="PDF"/' /etc/ImageMagick-7/policy.xml || true

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Thiết lập thư mục làm việc
WORKDIR /var/www

# Sao chép mã nguồn
COPY . /var/www

# Cài đặt phụ thuộc PHP
RUN composer install --ignore-platform-reqs --no-interaction --optimize-autoloader

# Cài đặt phụ thuộc Node.js
RUN npm install

# Biên dịch tài nguyên Vite
RUN npm run build

# Thiết lập quyền cho Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Sao chép cấu hình Nginx (tạo file này nếu cần)
COPY ./nginx.conf /etc/nginx/sites-available/default

# Mở cổng 80 cho Nginx
EXPOSE 80

# Khởi động Nginx và PHP-FPM
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
