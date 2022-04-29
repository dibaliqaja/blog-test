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
        
        Route::resource('categories', 'CategoryController', ['except' => 'show']);
        Route::resource('posts', 'PostController', ['except' => 'show']);

        Route::get('posts-download', 'PostController@downloadPost')->name('post.download');
        Route::get('download/{post}', 'PostController@getDownloadPost')->name('post.download.data');
        Route::post('download-multiple', 'PostController@getDownloadPostMultiple')->name('post.download.multiple');

        Route::post('rating', 'BlogController@ratingPost')->name('rating.store');

        Route::get('password', 'PasswordController@changePassword')->name('change.password');
        Route::patch('password', 'PasswordController@updatePassword')->name('update.password');
    });
});

Route::get('/{provider}', 'Auth\LoginController@redirectToProvider')->name('social.login');
Route::get('/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');
