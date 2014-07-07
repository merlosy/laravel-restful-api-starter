#Laravel Restful API Starter

> Quickly build a RESTful API with Laravel! 

## What is it about?

This starter uses several open source projects:
  - Laravel 4.2 : [Laravel]
  - Eloquent for MongoDB : [Laravel MongoDB]
  - Several homemade useful stuff...
   - ApiResponse (extends Illuminate\Support\Facades\Response) to quickly send json encoded response message, and failed validation rules
   - Token : allow a user to login from multiple devices

## What does it do?

The starter allows a user to create an account, log in and log out, as well as his personnal info. This can be a good place to start to build an API that communicates with mobile apps.

#### Upcoming...
- reset lost password
- OAuth 2.0
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


[Laravel MongoDB]:https://github.com/jenssegers/laravel-mongodb
[Laravel]:http://laravel.com/docs/quick
[GitHub]:https://github.com/merlosy
[Starter API]:https://github.com/merlosy/laravel-restful-api-starter
[Postman]:https://chrome.google.com/webstore/detail/postman-rest-client/fdmmgilgnpjigdojojpjoooidkmcomcm


