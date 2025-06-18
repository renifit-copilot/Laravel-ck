<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\OrganizerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
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

// Публичные маршруты
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

// Административные маршруты
Route::prefix('admin')->name('admin.')->group(function () {
    // В будущем здесь будет аутентификация middleware('auth')
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Маршруты для управления категориями
    Route::resource('categories', CategoryController::class);
    
    // Маршруты для управления локациями
    Route::resource('locations', LocationController::class);
    
    // Маршруты для управления организаторами
    Route::resource('organizers', OrganizerController::class);
    
    // Маршруты для управления мероприятиями
    Route::resource('events', AdminEventController::class);
});
