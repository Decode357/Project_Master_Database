<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ShapeController;
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

// หน้าแรก
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Profile (ทุกคน)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // หน้า dashboard
    Route::get('/dashboard', [PageController::class, 'dashboard'])
        ->middleware('verified')
        ->name('dashboard');

    // เมนูทั่วไปสำหรับทุก role
    Route::get('/shape', [ShapeController::class, 'shapeindex'])->name('shape.index');
    Route::get('/pattern', [PageController::class, 'patternindex'])->name('pattern.index');
    Route::get('/backstamp', [PageController::class, 'backstampindex'])->name('backstamp.index');
    Route::get('/glaze', [PageController::class, 'glazeindex'])->name('glaze.index');

    // เมนูสำหรับ admin และ superadmin
    Route::middleware('role:admin|superadmin')->group(function () {
        Route::get('/color', [PageController::class, 'colorindex'])->name('color.index');
        Route::get('/effect', [PageController::class, 'effectindex'])->name('effect.index');
        Route::get('/csv-import', [PageController::class, 'csvImport'])->name('csvImport')->middleware(['auth', 'role:admin|superadmin', 'permission:file import']);
        Route::get('/user', [PageController::class, 'user'])->name('user');
        Route::post('/user', [PageController::class, 'storeUser'])->name('user.store')->middleware(['auth', 'role:admin|superadmin', 'permission:manage users']);
        Route::delete('/user/{user}', [PageController::class, 'destroyUser'])->name('user.destroy')->middleware(['auth', 'permission:manage users']);
        Route::put('/user/{user}', [PageController::class, 'updateUser'])->name('user.update')->middleware(['auth', 'permission:manage users']);
        Route::post('/shape', [ShapeController::class, 'storeShape'])->name('shape.store')->middleware(['auth', 'role:admin|superadmin', 'permission:create']);
    });
});


// route สำหรับ auth (login/register/logout)
require __DIR__ . '/auth.php';
