# Technical test

You need to have **docker** installed on your computer to run the project.

### Install the project
run command:

    ./install

### Connect to container
run command:

    docker-compose exec php bash

### Database
run commands:

    php artisan migrate:fresh --seed

### Routes
run command to know the API routes:

    php artisan route:list

### Postman requests
you can import the postman records file to test the API endpoints (prepared requests)

    Piloc.postman_collection.json

### Tests PHPUnit
run command to test the API:

    vendor/bin/phpunit

### Credentials Laravel Passport
run command:
    
    php artisan passport:client --personal
    Personal

copy/paste Client secret in .env
