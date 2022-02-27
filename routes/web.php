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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', 'RegistrationController@register');
Route::get('/register', 'RegistrationController@register');
Route::get('/profile', 'RegistrationController@profile')->middleware(['auth']);
Route::post('/profile_store', 'RegistrationController@profileStore');
Route::get('/matched-profile', 'RegistrationController@matchedProfile')->middleware(['auth']);

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');

Route::get('admin', 'AdminController@admin');
Route::post('adminlogin', 'AdminController@adminlogin');
Route::get('all-users', 'AdminController@allUsers')->middleware(['is_admin']);;
Route::get('admin-logout', 'AdminController@adminLogout');
