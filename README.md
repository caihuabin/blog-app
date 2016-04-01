# blog-app

## Introduction

Blog-App is a blog webapp written in Laravel 5.1. 

## Screenshots

### Sign in

![](https://raw.githubusercontent.com/icyse/carte/master/image/screenshot0.png) 

### List and Picture Carousel

![](https://raw.githubusercontent.com/icyse/carte/master/image/screenshot2.png)

### Content and Comment

![](https://raw.githubusercontent.com/icyse/carte/master/image/screenshot3.png)

### Picture Slide

![](https://raw.githubusercontent.com/icyse/carte/master/image/screenshot4.png)

### Feed

![](https://raw.githubusercontent.com/icyse/carte/master/image/screenshot6.png)

## Requirements and Environment

* PHP 5.5.9+
* Laravel 5.1+

## Installation

Recommended using [Homestead](http://laravel.com/docs/4.2/homestead) for development.

### 1. Clone the repo

    git clone https://github.com/icyse/blog-app.git

### 2. Composer install

    cd blog-app
    composer install
    
### 3. Database stuff

	cp .env.example .env
	vi .env

Edit .env, ajust the database information: DB_HOST、DB_DATABASE、DB_USERNAME、DB_PASSWORD;ajust other information: URL、URL_STATIC、USER_STATIC.

Then:
	
	php artisan migrate

