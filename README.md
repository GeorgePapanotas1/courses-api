

## Courses CRUD API
### implemented with DDD and Hexagonal Architecture

This repository is a Laravel CRUD API for courses resource. The API is designed with Hexagonal Architecture and DDD.
To achieve this, the code is moved from the default "app" package to a new src/Modules package. To perform this change a PSR4 autoload entry is placed in the respective place in composer.json ( "Modules\\": "src/Modules/")

Furthermore, the source code of each package is split into Core and Adapters packages. Adapters contains all the classes that interact with the outside world (either inputs or outputs). On the other hand, the core logic of each package resides into the Core package.  

Note: In pure Hexagonal Architecture, the Models directory should be in the Adapters package as the database is consider an external domain. The controllers should also implement a custom interface (port), but in this scenario, it's not necessary as the controller abstraction is handled by Laravel.

Installation: 

This project utilized Laravel Sail to interact with Docker. However you can run on any platform by setting the appropriate .env variables.
Just checkout the repo and follow your normal Laravel workflow. Please remember to: 

cp .env.example .env

composer install

php artisan migrate

ready.

OPEN AI Docs:

After running the project locally, please visit {project_url}/api/documentation#/Courses for more info.



