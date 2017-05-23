**`Docker`**

	version: '2'

	services:

	    nginx:
	        image: nginx:1.13
	        container_name: app-nginx
	        ports:
	            - "8000:80"
	        volumes:
	            - ./config/nginx.conf:/etc/nginx/conf.d/default.conf
	            - ./angular-dist:/var/www/html/angular
	            - ./laravel:/var/www/html/laravel

	    php:
	        build:
	            context: ./config
	            dockerfile: php.dockerfile
	        container_name: app-php
	        volumes:
	            - ./laravel:/var/www/html/laravel

	    mongo:
	        image: mongo:3.4
	        container_name: app-mongo
	        volumes:
	            - ./mongo/data:/data/db


**`Nginx`**

	v - 1.13

    config:

      server {
          listen 80 default_server;
          listen [::]:80 default_server;

          root /var/www/html/laravel/public;

          server_name docker.dev;

          index index.html index.php index.htm;

          location / {
              root /var/www/html/angular;
              index index.html;
              try_files $uri $uri/ /index.html?$args;
          }

          location /api {
              try_files $uri $uri/ /index.php?$query_string;
          }

          location ~ \.php$ {
              fastcgi_pass php:9000;
              try_files $uri /index.php =404;
              fastcgi_split_path_info ^(.+\.php)(/.+)$;
              include fastcgi_params;
              fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
              fastcgi_param PATH_INFO $fastcgi_path_info;
          }
      }

**`Angular`**

    v - 4.0

    ng build output dir:
    	./angular-dist

**`Laravel`**

    v - 5.4

    requiere:
    	moloquent/moloquent:dev-master
		barryvdh/laravel-cors


**`Mongo`**

    v-3.4

    data:
    	./mongo
