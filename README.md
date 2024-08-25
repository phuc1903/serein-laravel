
# Serein Laravel 11 with Inertia and React 18

The jewelry product is a combination of Laravel 11 with Inertia and React 18




## Authors

- [@phuc1903](https://github.com/phuc1903)


## Demo

Insert gif or link to demo


## 🛠 Skills
This project is built using the following technologies:

- **Laravel 11**: A PHP framework for building robust web applications.

## Requirements
- Generated ssh key

- PHP min v.8.2

- DB server (Recommended:MySQL)

- [composer min v.2](https://getcomposer.org/download/)

- [nodejs min v.20](https://nodejs.org/en/download/prebuilt-installer)

- Please also check [Laravel](https://laravel.com/docs/11.x)


## Run Locally

Clone the project

```bash
git clone git@github.com:phuc1903/serein-laravel.git
```

Go to the project directory

```bash
cd serein-laravel
``` 

Install dependencies

```bash
composer install
```

Add .env

```bash
cp .env.example .env
php artisan key:generate
```

Run Migrate

```bash
php artisan migrate
```

## Start the server

```bash
php artisan serve
```
