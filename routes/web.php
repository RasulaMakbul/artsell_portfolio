<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\CreativityController;
use App\Http\Controllers\FashionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ArchitectureController;
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

    Route::resource('/fashion', FashionController::class);
    Route::get('/fashion/active/{id}', [CreativityController::class, 'active'])->name('fashion.active');
    Route::get('/fashion/inactive/{id}', [CreativityController::class, 'inactive'])->name('fashion.inactive');

    Route::resource('/product', ProductController::class);
    Route::get('/product/active/{id}', [ProductController::class, 'active'])->name('product.active');
    Route::get('/product/inactive/{id}', [ProductController::class, 'inactive'])->name('product.inactive');

    Route::resource('/architecture', ArchitectureController::class);
    Route::get('/architecture/active/{id}', [ArchitectureController::class, 'active'])->name('architecture.active');
    Route::get('/architecture/inactive/{id}', [ArchitectureController::class, 'inactive'])->name('architecture.inactive');
});

require __DIR__.'/auth.php';
