<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;

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
    Route::controller(TasksController::class)->group(function () {
        // with fortify auth middleware
        Route::get('home', 'index') ->middleware(['auth']); // fortify auth middleware

    });
    
});
