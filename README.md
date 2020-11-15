## Blog Test
Blog test is a simple project for an content management system or blog that is created to fulfill the initial coding test with a given requirement.

### Features
> Point penting yang harus dipenuhi:
- Memakai framework Laravel (preferably Laravel terbaru) 
✅
- Ada 2 sisi, 1 untuk admin/CMS (misalnya di example.com/admin) dan 1 untuk user-facing/frontend (example.com)
✅
- Semua halaman CMS harus diproteksi dengan auth supaya hanya bisa diakses oleh orang yang sudah login. Jika belum login, dilempar ke halaman login kembali.
✅
- Halaman Login CMS
    - User/Admin bisa login via email dan password. ✅
    - Buat juga fitur Sign up supaya bisa mendaftar sebagai User baru. ✅
    - Di halaman sign up, selain sign up with email, tambahkan juga fitur social signup, salah satu dari Facebook Connect/Sign in with Google/Login with Twitter/Github (boleh menggunakan Socialite) ✅
    - Setelah login, user/admin akan di-redirect ke dashboard CMS yang berisi menu Categories, Posts, Change Password dan Log Out. ✅
- Halaman Change Password, ada field Old Password, New Password dan Confirm New Password. Saat submit, buat validasi standar, misal old password harus sama dengan password lama dia, new password dan confirm new password harus sama.
✅
- Halaman Posts di CMS
     - Buat CRUD untuk halaman Posts ini. ✅
     - Field-field untuk Posts ini yang perlu adalah category_id (ini dropdown, ambil data list category dari table categories), title, slug (kalau titlenya Judul Artikel, slugnya adalah judul-artikel), short_description, content, image dan thumbnail (versi lebih kecil dari image, diproses secara sistem oleh image yang diupload user). Sisanya (misal post_date, dll) kalau mau ditambah-tambah, boleh saja sesuai dengan kreativitas. ✅
    - User/admin yang login ke dalam CMS bisa create, edit, dan delete posts. ✅
- Halaman Categories di CMS
    - Field mandatory untuk Categories ini adalah name dan slug. ✅
    - User/admin yang login ke dalam CMS bisa create, edit, dan delete categories. ✅
    - Di user-facing/frontend, minimal ada routes untuk menampilkan: 
      - Home, isinya list of posts dengan pagination misalnya 10 posts per halaman ✅
      - Detail post, saat salah satu item di list of posts diklik. ✅
      - Browse posts by categories, jadi misalnya routenya http://localhost/example.com/category/games, akan menampilkan list of posts yang categorynya adalah games. ✅
- Secara tampilan baik frontend maupun CMS, bebas, mungkin untuk memudahkan bisa menggunakan Bootstrap atau semacamnya. Untuk tampilan dalam halaman CMS-nya ikutin tampilan standar CMS umumnya aja (misal list/daftar posts dalam table, dll). ✅

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
FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
FACEBOOK_CALLBACK_URL={your-domain}/login/facebook/callback

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_CALLBACK_URL={your-domain}/login/google/callback
```
10. Migrate the database
```bash
$ php artisan migrate
```
11. Seed the database
```bash
$ php artisan db:seed
```
12. Running project
```bash
$ php artisan serve
```

### Admin Credentials in Seeder

**Admin:** admin@blogtest.com  
**Password:** admin123
<br>
--or--
<br>
Register yourself for new author

### Screenshots

![image](https://raw.githubusercontent.com/dibaliqaja/blog-test/main/screenshots/1.png)

![image](https://raw.githubusercontent.com/dibaliqaja/blog-test/main/screenshots/2.png)

![image](https://raw.githubusercontent.com/dibaliqaja/blog-test/main/screenshots/3.png)

![image](https://raw.githubusercontent.com/dibaliqaja/blog-test/main/screenshots/4.png)

![image](https://raw.githubusercontent.com/dibaliqaja/blog-test/main/screenshots/5.png)

![image](https://raw.githubusercontent.com/dibaliqaja/blog-test/main/screenshots/6.png)

![image](https://raw.githubusercontent.com/dibaliqaja/blog-test/main/screenshots/7.png)

![image](https://raw.githubusercontent.com/dibaliqaja/blog-test/main/screenshots/8.png)

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
