<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Route::get('/', [EventController::class, 'index'])->name('index');
// Route::get('/addmenu', [EventController::class,'AddView'])->name('addmenu');
// Route::post('/event/store', [EventController::class,'store'])->name('store-event');
// Route::get('/event/viewedit/{id}', [EventController::class, 'EditMenu'])->name('edit-index');
// Route::put('/event/edit/{id}', [EventController::class,'updateEvent'])->name('edit');
// Route::delete('/event/delete/{id}', [EventController::class,'DeleteEvent'])->name('delete');


// Public Routes - Accessible by anyone
Route::get('/', [EventController::class, 'index'])->name('index');

// Auth Routes - Protected by auth middleware
Route::controller(AuthController::class)->group(function() {
    Route::get('/register-menu', 'registermenu')->name('register-menu');
    Route::post('/register', 'register')->name('register');
    Route::get('/login-page', 'loginmenu')->name('login-page');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/me', 'me')->name('me');
});

// Event Routes - Protected by auth middleware
Route::group(['middleware' => 'auth'], function () {
    Route::get('/addmenu', [EventController::class, 'AddView'])->name('addmenu');
    Route::get('/user-detail/{id}', [EventController::class, 'GetUserDetail'])->name('user-detail');
    Route::post('/event/store', [EventController::class, 'store'])->name('store-event');
    Route::get('/event/viewedit/{id}', [EventController::class, 'EditMenu'])->name('edit-index');
    Route::put('/event/edit/{id}', [EventController::class, 'updateEvent'])->name('edit');
    Route::delete('/event/delete/{id}', [EventController::class, 'DeleteEvent'])->name('delete');
});

