# HTTP Notification System

## Installation

Follow this steps to build locally:

```sh
Clone project
composer install
cp .env.example .env
php artisan migrate:fresh --seed
php artisan queue:work
```

## Endpoints

### Create a subscription

/api/v1/subscribe/{topic} <br/>

### Publish message to topic

/api/v1/publish/{topic} <br/>
