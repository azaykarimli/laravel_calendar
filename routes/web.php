<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FullCalendarController;
use App\Http\Controllers\UserController;
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
/* 
Route::get('/', function () {
    return view('welcome');
}); */


/* Event roots below delete create and index */

Route::get('/', [FullCalendarController::class, 'getEvent'])->middleware('auth');
//Route::get('/change/{key}', [FullCalendarController::class, 'getEvent'])->name('getevent');
Route::post('/createevent', [FullCalendarController::class, 'createEvent'])->name('createevent')->middleware('auth');
Route::post('/deleteevent', [FullCalendarController::class, 'deleteEvent'])->name('deleteevent')->middleware('auth');
//delete reguest from tabular view
Route::delete('/deleteevent/{event}', [FullCalendarController::class, 'destroy'])->name('destroyevent')->middleware('auth');



//manage my listing //gets only selected users events
Route::get('/manage', [FullCalendarController::class, 'manage'])->middleware('auth');



/* user reletad root below */

//show register form
Route::get('/register', [UserController::class, 'register_form'])->name('')->middleware('guest');
Route::post('/register', [UserController::class, 'register'])->name('')->middleware('guest');

//show login form
Route::get('/login', [UserController::class, 'login_form'])->name('')->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

//logout
Route::post('/logout', [UserController::class, 'logout'])->name('')->middleware('auth');
