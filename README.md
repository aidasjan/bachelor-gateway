# Wholesale Management Platform - Gateway Portal

## Requirements

- PHP 8.0.2+
- MySQL 8+

## Installation

Install the application by running `composer install`.

## Running

Run database migrations using `php artisan migrate:fresh`.

To seed database with test data run `php artisan db:seed`. 3 users will be created (admin@wmp.local, info@water.local, info@chemicals.local). Their password is "admin123".

Environment variables need to be set according to the contents of `.env.local` file. For the standard configuration, rename the file to `.env`.

## Testing

Run tests using `php artisan test`. Tests use an SQLite database, so empty `testdb.sqlite` file needs to exist in a root directory.

## Test Environment

The platform is deployed to test environment. It consists of [Gateway Portal](https://wmp-gateway.herokuapp.com/) and two company portals.
