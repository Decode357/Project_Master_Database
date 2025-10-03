<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ShapeController;
use App\Http\Controllers\PatternController;
use App\Http\Controllers\BackstampController;
use App\Http\Controllers\GlazeController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\EffectController;
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
    Route::get('/pattern', [PatternController::class, 'patternindex'])->name('pattern.index');
    Route::get('/backstamp', [BackstampController::class, 'backstampindex'])->name('backstamp.index');
    Route::get('/glaze', [GlazeController::class, 'glazeindex'])->name('glaze.index');

    // เมนูสำหรับ admin และ superadmin
    Route::middleware('role:admin|superadmin')->group(function () {
        // เมนูสำหรับแสดงข้อมูล
        Route::get('/color', [ColorController::class, 'colorindex'])->name('color.index');
        Route::get('/effect', [EffectController::class, 'effectindex'])->name('effect.index');
        Route::get('/csv-import', [PageController::class, 'csvImport'])->name('csvImport')->middleware(['auth', 'role:admin|superadmin', 'permission:file import']);
        Route::get('/user', [PageController::class, 'user'])->name('user');

        // เมนูสำหรับเก็บข้อมูล 
        Route::post('/user', [PageController::class, 'storeUser'])->name('user.store')->middleware(['auth', 'role:admin|superadmin', 'permission:manage users']);
        Route::post('/shape', [ShapeController::class, 'storeShape'])->name('shape.store')->middleware(['auth', 'role:admin|superadmin', 'permission:create']);

        // เมนูสำหรับแก้ไขข้อมูล
        Route::put('/user/{user}', [PageController::class, 'updateUser'])->name('user.update')->middleware(['auth', 'permission:manage users']);
        Route::put('/shape/{shape}', [ShapeController::class, 'updateShape'])->name('shape.update')->middleware(['auth', 'permission:edit']);

        // เมนูสำหรับลบข้อมูล
        Route::delete('/user/{user}', [PageController::class, 'destroyUser'])->name('user.destroy')->middleware(['auth', 'permission:manage users']);
        Route::delete('/shape/{shape}', [ShapeController::class, 'destroyShape'])->name('shape.destroy')->middleware(['auth', 'permission:delete']);
        Route::delete('/pattern/{pattern}', [PatternController::class, 'destroyPattern'])->name('pattern.destroy')->middleware(['auth', 'permission:delete']);
        Route::delete('/backstamp/{backstamp}', [BackstampController::class, 'destroyBackstamp'])->name('backstamp.destroy')->middleware(['auth', 'permission:delete']);
        Route::delete('/glaze/{glaze}', [GlazeController::class, 'destroyGlaze'])->name('glaze.destroy')->middleware(['auth', 'permission:delete']);
        Route::delete('/color/{color}', [ColorController::class, 'destroyColor'])->name('color.destroy')->middleware(['auth', 'permission:delete']);
        Route::delete('/effect/{effect}', [EffectController::class, 'destroyEffect'])->name('effect.destroy')->middleware(['auth', 'permission:delete']);
    });
});


// route สำหรับ auth (login/register/logout)
require __DIR__ . '/auth.php';
