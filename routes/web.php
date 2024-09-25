<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// route untuk web view user yg sudah login di jadikan group
Route::middleware(['auth', 'verified'])
->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');  

    Route::get('/testPage', function () {
        return Inertia::render('PageTest');
    })->name('cobaTest'); 

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Admin Route
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('inventories', InventoryController::class);
});

//User Route
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('inventories', [InventoryController::class, 'index']);
    Route::get('inventories/{inventory}', [InventoryController::class, 'show']);
    Route::post('inventories/request', [InventoryController::class, 'requestInventory']);
});
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

require __DIR__ . '/auth.php';
