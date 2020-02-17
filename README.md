# TechBB

> Technology blog

## Backend

### Techologies

1. PHP 7.4
2. Redis

### PHP extenstions

1. ext-redis
2. ext-sodium
3. ext-mbstring
4. ext-json

### Libraries 

1. Symphony router engine
2. Dependency Injection PHP DI
3. Nesbot Carbon DateTime 
4. Rakkit Validation - Laravel validation clone
5. Monolog Logging library
6. Illuminate Database (Eloquent)
7. Doctrine Annotations
8. Json Web Token ( RSA and HMAC Signing algorithms)
9. SendGrid email library
10. Proxy manager for lazy loading of dependencies
11. DotEnv Parser and Lexer (My own) 


#### Development libraries
1. Rob Morgan's PHINX migration tool
2. Symphony Var Dumper
3. Faker library

### Running
> Application only works on *NIX platforms - it uses specific system APIs - No garanties it works on Windows
First of all copy .env.example into .env

1. Make sure you have PHP 7.4.1 - for new syntax and features used in project ( short closures, typed properties )
2. Install Redis and set it up in .env file
3. Install RabbitMQ and management plugin
4. Configure Database connection and User credentials in .env file
5. Migrate the database

```sh
$ ./vendor/bin/phinx migrate

```
6. Seed the database - it will take a while - it seeds 10k of Posts

```sh
$ ./vendor/bin/phinx seed:run -s UserSeeder-s CategorySeeder -s PostsSeeder

```

7. Add SendGrid Key - Create free account
8. Generate key pairs

```sh
$ ./genkeys

```
9. Generate APP Key with SODIUM
```php

echo sodium_bin2base64(sodium_crypto_auth_keygen(), SODIUM_BASE64_VARIANT_URLSAFE) . PHP_EOL;

```

10. Make sure your APP_URL Matches the domain name used for serving
11. Most important of all - Web APP work only with SSL - Generate certificate with openssl or use Laravel VALET 
for serving with 
```sh

$ valet secure api.techbb

```

### To check out only the framework without application specific code go to framwork branch, that branch contains latest features and bugfixes

## Frontend

### Techologies

1. Angular 9

### Libraries

1. NGXS
2. Angular Pagination
3. SweetAlert
4. MomentJS
5. NgxBootstrap
6. Ng Bootstrap Validation
7. Ngx Permissions
8. Bootstrap

### Running

1. Install dependencies
2. Change Backend URL in environment file 
3. Run the project with Angular CLI - (** Make sure you have Angular 9 - This project relies on Ivy **)
4. Run project with --aot (Ahead of Time) flag
