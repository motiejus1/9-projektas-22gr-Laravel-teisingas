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

Route::prefix('clients')->group(function() {
    Route::get('', 'App\Http\Controllers\ClientController@index')->name('client.index');
    Route::get('create', 'App\Http\Controllers\ClientController@create')->name('client.create');
    Route::post('store', 'App\Http\Controllers\ClientController@store')->name('client.store');
    Route::post('storeAjax', 'App\Http\Controllers\ClientController@storeAjax')->name('client.storeAjax');
    Route::post('delete/{client}', 'App\Http\Controllers\ClientController@destroy')->name('client.destroy');
    Route::post('deleteAjax/{client}', 'App\Http\Controllers\ClientController@destroyAjax')->name('client.destroyAjax');
    Route::get('showAjax/{client}', 'App\Http\Controllers\ClientController@showAjax')->name('client.showAjax');
    Route::post('updateAjax/{client}', 'App\Http\Controllers\ClientController@updateAjax')->name('client.updateAjax');
    // Route::get('createvalidate', 'App\Http\Controllers\AuthorController@createvalidate')->name('author.createvalidate');
    // Route::post('storevalidate', 'App\Http\Controllers\AuthorController@storevalidate')->name('author.storevalidate');
    // Route::get('search', 'App\Http\Controllers\AuthorController@search')->name('author.search');

});
