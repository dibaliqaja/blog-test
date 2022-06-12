<h1 align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="224px"/><br/>
  BlogTest
</h1>
<p align="center">BlogTest is a Content Management App</p>

<p align="center">
    <a href="https://github.com/dibaliqaja/blog-test/actions/workflows/laravel.yml" target="_blank">
        <img src="https://img.shields.io/badge/actions-passing-success?style=for-the-badge&logo=github-actions" alt="github actions" />
    </a>
    &nbsp;
    <a href="https://github.com/dibaliqaja/blog-test/releases" target="_blank">
        <img src="https://img.shields.io/badge/version-v1.0.0-red?style=for-the-badge&logo=none" alt="system version" />
    </a>
    &nbsp;
    <a href="https://github.com/dibaliqaja/blog-test" target="_blank">
        <img src="https://img.shields.io/badge/Laravel-7.29.0-fb503b?style=for-the-badge&logo=laravel" alt="laravel version" />
    </a>
    &nbsp;
    <img src="https://img.shields.io/badge/license-mit-red?style=for-the-badge&logo=none" alt="license" />
</p>

### Features
- Admin Panel
  - Login
  - Logout
  - Dashboard
  - List, Add, Edit, Delete Categories
  - List, Add, Edit, Delete Tags
  - List, Add, Edit, Delete Posts
  - Change Password
- Frontend
  - Register With Email
  - Register With Google Tap-In
  - Home/List Posts
  - Detail Posts
  - Rating Posts
  - Browse Posts by Categories
  - Search Posts

### Requirements
- PHP >= 7.2.5
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

### Installation
1. Clone GitHub repo for this project locally
```bash
$ git clone https://github.com/dibaliqaja/blog-test.git
```
2. Change directory in project which already clone
```bash
$ cd blog-test
```
3. Install Composer dependencies
```bash
$ composer install
```
4. Install NPM dependencies
```bash
$ npm install
```
5. Create a copy of your .env file
```bash
$ cp .env.example .env
```
6. Generate an app encryption key
```bash
$ php artisan key:generate
```
7. Create an empty database for our application

8. In the .env file, add database information to allow Laravel to connect to the database
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={database-name}
DB_USERNAME={username-database}
DB_PASSWORD={password-database}
```
9. Input client_id and client_secret for socialize sign-in, change {your-domain} with your domain and setting in the Facebook and Google API OAuth
```bash
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_CALLBACK_URL={your-domain}/google/callback

FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
FACEBOOK_CALLBACK_URL={your-domain}/facebook/callback
```
10. Migrate the database
```bash
$ php artisan migrate
```
11. Create a symbolic link from public/storage to storage/app/public 
```bash
$ php artisan storage:link
```
12. Seed the database
```bash
$ php artisan db:seed
```
13. Running project
```bash
$ php artisan serve
```

### Admin Credentials in Seeder
| #        | Administrator      | Author                            |
| -------- | ------------------ |---------------------------------- |
| Email    | admin@blogtest.com |Register yourself for new author   |
| Password | admin123           |                                   |

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
