<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Tech Specification

- Laravel 8
- Paypal
- Stripe

## Features

- Donate any amount in a click
- Show all donation
- Notofication after donation success

## Installation

- `git clone https://github.com/tsakib360/donation-system-laravel.git`
- `cd donation-system-laravel/`
- `composer install`
- `cp .env.example .env`
- Update `.env` and set your database credentials and stripe credentials
- `php artisan key:generate`
- `php artisan migrate`
- Update `config/paypal.php` and set paypal credentials
- `php artisan serve`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
