<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {

    // with fortify auth middleware
    Route::get('home', function () {
        return view('home');
    }) ->middleware(['auth']); // fortify auth middleware

});
