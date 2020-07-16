<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* Auth */
Route::post('login', 'API\Auth\LoginController@login')->name('login');
Route::post('register', 'API\Auth\RegisterController@register')->name('register');
/* Votes */
Route::post('news/{article:slug}/vote', 'API\VotesController@store')->name('vote.store');
Route::delete('news/{article:slug}/vote', 'API\VotesController@destroy')->name('vote.destroy');
/* Categories */
Route::get('news/categories', 'API\CategoriesController@index')->name('category.index');
Route::get('news/category/{category:slug}', 'API\CategoriesController@show')->name('category.show');
/* News */
Route::apiResource('news', 'API\NewsController')->parameters(['news' => 'article:slug']);

