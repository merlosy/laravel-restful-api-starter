#Laravel Restful API Starter

> Check out the [WIKI] now!

## What is it about?

This starter is based on:
  - [Laravel] 4.2 :  Use the power a lightweight trendy Framework

Use MongoDB for storage, and still Eloquent for ORM:
  - Eloquent for MongoDB : ([Laravel MongoDB]) You can easily use MongoDB (NoSQL) as well as the basic SQL database managed by Laravel (MySQL, PGSQL, SQLite, SQL server). Everything is already configured!
  - Seeder files (js) to set up MongoDB users

Send custom response messages:
   - ApiResponse (extends Illuminate\Support\Facades\Response) to quickly send json encoded response message, with adapted Http status codes, and even failed validation rules

Multi-device session:
   - Token : allow a user to login from multiple devices and track all his active sessions.

## What does it do?

The starter allows a user to create an account, log in and log out, as well as accessing his personnal info. This can be a good place to start to build an API that communicates with mobile apps.

#### Upcoming...
- reset lost password
- OAuth 2.0
- Push Notification
- login with social media: Facebook, Twitter, Google+ ...


## Get it working

### Requirements

    PHP >= 5.4.0
    MCrypt PHP Extension

## How to install
### 1. Get the code

	git clone git://github.com/merlosy/laravel-restful-api-starter.git my_api

or

    https://github.com/merlosy/laravel-restful-api-starter/archive/master.zip

### 2. Use Composer to install dependencies

    cd my_api
	composer install --dev
	
### 3. Set you own project key

    php artisan key:generate
    
### 4. Install mongoDB et set up the config files

### 5. Try it

I use [Postman] that works in Chrome. It is very convienient and easy to use. To check out available URIs, use:
    
    php artisan routes

## About it

### Feedback appreciated 
Contact me on [GitHub]

### License
MIT

[WIKI]:https://github.com/merlosy/laravel-restful-api-starter/wiki
[Laravel MongoDB]:https://github.com/jenssegers/laravel-mongodb
[Laravel]:http://laravel.com/docs/quick
[GitHub]:https://github.com/merlosy
[Starter API]:https://github.com/merlosy/laravel-restful-api-starter
[Postman]:https://chrome.google.com/webstore/detail/postman-rest-client/fdmmgilgnpjigdojojpjoooidkmcomcm


