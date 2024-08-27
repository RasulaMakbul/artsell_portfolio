<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\CreativityController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/hero', HeroController::class);
    Route::get('/hero/active/{id}', [HeroController::class, 'active'])->name('hero.active');
    Route::get('/hero/inactive/{id}', [HeroController::class, 'inactive'])->name('hero.inactive');
    Route::resource('/creativity', CreativityController::class);
    Route::get('/creativity/active/{id}', [CreativityController::class, 'active'])->name('creativity.active');
    Route::get('/creativity/inactive/{id}', [CreativityController::class, 'inactive'])->name('creativity.inactive');
});

require __DIR__.'/auth.php';
