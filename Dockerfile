FROM php
RUN docker-php-ext-install mysqli
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp
CMD [ "php", "./index.php" ]