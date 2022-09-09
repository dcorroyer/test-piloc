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

    php artisan migrate:fresh
    php artisan db:feed

### Test API
run command to know the API routes:

    php artisan route:list

### Others
done:

    project creation
    docker
    database
    models with relations
    migrations
    factories
    seeders
    properties controller
    properties validation
    properties routes
    readme

to finish + bonus:

    tests
    auth with laravel passport
    address with api geocoding
    pagination
    part for user
    part for account
