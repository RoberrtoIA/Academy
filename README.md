# Final Project

**Authors:**

rmoreno@applaudostudios.dev  
gmarsano@applaudostudios.dev

## Content
- [API Demo](#api-demo)
- [Demo Usage](#demo-usage)
- [Install](#install)
- [Demo Seeder](#demo-seeder)
- [Run with Docker](#run-with-docker)
    - [First run install](#first-run-install)
    - [build](#build)
    - [up services](#up-services)
    - [migrate fresh](#migrate-fresh)
    - [down services](#down-services)


## API Demo

You can find a [Postman](https://www.postman.com/) collection for API demo in `demo` folder.

[Import json file](https://learning.postman.com/docs/getting-started/importing-and-exporting-data/#importing-postman-data).

## Demo Usage

Login with all demo users (see [Demo Seeder](#demo-seeder)) and fill the
respective `token` fields in the `collection variables`.

## Install

PHP 8.1+, composer and MySQL8+ are required.

Clone the project and install dependencies.

```bash
git clone https://gitlab.com/applaudo-php-tp-2022/final-project
cd final-project
composer install
```

Copy `.env.example` and fill environment variables as needed.

```bash
cp .env.example .env
```

Run following commands

```bash
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
```

Seed is required for initial data set.

### Demo Seeder 
You can use demo seeder for [API Demo](#api-demo) context.

```bash
php artisan migrate:fresh \
    --seeder=Database\\Seeders\\Sample\\SampleSeeder
```

### Run with Docker

You can use [Laravel Sail](https://laravel.com/docs/9.x/sail#main-content) for
run containerized development environment.

Also you can use `MakeFile` as follows.

#### First run install
Use `$ make install` for dev first run. It will clean any previous run, build and up services and run migrations.

##### build
`$ make build-dev`

##### up services
`$ make up-dev`

#### migrate fresh
`$ make do-migrate-dev`

##### down services
`$ make down-dev`
