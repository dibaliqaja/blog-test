<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'BlogController@index')->name('homepage');
Route::get('post/{slug}','BlogController@detail')->name('blog.detail');
Route::get('categories/{category}','BlogController@categories')->name('blog.categories');
Route::get('search','BlogController@search')->name('blog.search');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('cms')->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');
        Route::resource('categories', 'CategoryController');
        Route::resource('posts', 'PostController');

        Route::get('password', 'PasswordController@changePassword')->name('change.password');
        Route::patch('password', 'PasswordController@updatePassword')->name('update.password');
    });
});

Route::get('/login/{provider}', 'Auth\LoginController@redirectToProvider')->name('social.login');
Route::get('/login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');
