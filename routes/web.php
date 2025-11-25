<?php

use App\Http\Controllers\{
    ProfileController, PageController,
    ShapeController, PatternController,
    BackstampController, GlazeController,
    ColorController, EffectController,
    UserController, GlazeInsideOuterController,
    ShapeCollectionController, ImportController,
    ExportController,CustomerController,ItemGroupController
};
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
    
    // เพิ่ม route สำหรับดึงข้อมูล chart
    Route::get('/dashboard/chart-data', [PageController::class, 'getChartData'])
        ->middleware('verified')
        ->name('dashboard.chartData');

    // เมนูทั่วไปสำหรับทุก role
    Route::get('/shape', [ShapeController::class, 'shapeindex'])->name('shape.index');
    Route::get('/pattern', [PatternController::class, 'patternindex'])->name('pattern.index');
    Route::get('/backstamp', [BackstampController::class, 'backstampindex'])->name('backstamp.index');
    Route::get('/glaze', [GlazeController::class, 'glazeindex'])->name('glaze.index');
    Route::get('/color', [ColorController::class, 'colorindex'])->name('color.index');
    Route::get('/effect', [EffectController::class, 'effectindex'])->name('effect.index');
    Route::get('/glaze-inside-outer', [GlazeInsideOuterController::class, 'index'])->name('glaze.inside.outer.index');
    Route::get('/shape-collection', [ShapeCollectionController::class, 'shapecollectionindex'])->name('shape.collection.index');

    // เมนูสำหรับ admin และ superadmin
    Route::middleware('role:admin|superadmin')->group(function () {
        // เมนูสำหรับแสดงข้อมูล
        Route::get('/csv-import', [PageController::class, 'csvImport'])->name('csvImport')->middleware('permission:file import');
        Route::get('/user', [UserController::class, 'user'])->name('user');
        Route::get('/customer', [CustomerController::class, 'customerindex'])->name('customer.index');
        Route::get('/item-group', [ItemGroupController::class, 'itemGroupindex'])->name('item.group.index');

        // เมนูสำหรับเก็บข้อมูล 
        Route::post('/user', [UserController::class, 'storeUser'])->name('user.store')->middleware(['auth', 'role:admin|superadmin', 'permission:manage users']);
        Route::post('/shape', [ShapeController::class, 'storeShape'])->name('shape.store')->middleware(['auth', 'role:admin|superadmin', 'permission:create']);
        Route::post('/pattern', [PatternController::class, 'storePattern'])->name('pattern.store')->middleware(['auth', 'role:admin|superadmin', 'permission:create']);
        Route::post('/backstamp', [BackstampController::class, 'storeBackstamp'])->name('backstamp.store')->middleware(['auth', 'role:admin|superadmin', 'permission:create']);
        Route::post('/glaze', [GlazeController::class, 'storeGlaze'])->name('glaze.store')->middleware(['auth', 'role:admin|superadmin', 'permission:create']);
        Route::post('/color', [ColorController::class, 'storeColor'])->name('color.store')->middleware(['auth', 'role:admin|superadmin', 'permission:create']);
        Route::post('/effect', [EffectController::class, 'storeEffect'])->name('effect.store')->middleware(['auth', 'role:admin|superadmin', 'permission:create']);
        Route::post('/glaze-inside', [GlazeInsideOuterController::class, 'storeGlazeInside'])->name('glaze-inside.store')->middleware(['auth', 'role:admin|superadmin', 'permission:create']);
        Route::post('/glaze-outer', [GlazeInsideOuterController::class, 'storeGlazeOuter'])->name('glaze-outer.store')->middleware(['auth', 'role:admin|superadmin', 'permission:create']);
        Route::post('/shape-collection', [ShapeCollectionController::class, 'storeShapeCollection'])->name('shape-collection.store')->middleware(['auth', 'role:admin|superadmin', 'permission:create']);
        Route::post('/customer', [CustomerController::class, 'storeCustomer'])->name('customer.store')->middleware(['auth', 'role:admin|superadmin', 'permission:create']);
        Route::post('/item-group', [ItemGroupController::class, 'storeItemGroup'])->name('item.group.store')->middleware(['auth', 'role:admin|superadmin', 'permission:create']);

        // เมนูสำหรับแก้ไขข้อมูล
        Route::put('/user/{user}', [UserController::class, 'updateUser'])->name('user.update')->middleware(['auth', 'permission:manage users']);
        Route::put('/shape/{shape}', [ShapeController::class, 'updateShape'])->name('shape.update')->middleware(['auth', 'permission:edit']);
        Route::put('/pattern/{pattern}', [PatternController::class, 'updatePattern'])->name('pattern.update')->middleware(['auth', 'permission:edit']);
        Route::put('/backstamp/{backstamp}', [BackstampController::class, 'updateBackstamp'])->name('backstamp.update')->middleware(['auth', 'permission:edit']);
        Route::put('/glaze/{glaze}', [GlazeController::class, 'updateGlaze'])->name('glaze.update')->middleware(['auth', 'permission:edit']);
        Route::put('/color/{color}', [ColorController::class, 'updateColor'])->name('color.update')->middleware(['auth', 'permission:edit']);
        Route::put('/effect/{effect}', [EffectController::class, 'updateEffect'])->name('effect.update')->middleware(['auth', 'permission:edit']);
        Route::put('/glaze-inside/{glazeInside}', [GlazeInsideOuterController::class, 'updateGlazeInside'])->name('glaze-inside.update')->middleware(['auth', 'permission:edit']); 
        Route::put('/glaze-outer/{glazeOuter}', [GlazeInsideOuterController::class, 'updateGlazeOuter'])->name('glaze-outer.update')->middleware(['auth', 'permission:edit']);
        Route::put('/shape-collection/{shapeCollection}', [ShapeCollectionController::class, 'updateShapeCollection'])->name('shape-collection.update')->middleware(['auth', 'permission:edit']);
        Route::put('/customer/{customer}', [CustomerController::class, 'updateCustomer'])->name('customer.update')->middleware(['auth', 'permission:edit']);
        Route::put('/item-group/{itemGroup}', [ItemGroupController::class, 'updateItemGroup'])->name('item.group.update')->middleware(['auth', 'permission:edit']);

        // เมนูสำหรับลบข้อมูล
        Route::delete('/user/{user}', [UserController::class, 'destroyUser'])->name('user.destroy')->middleware(['auth', 'permission:manage users']);
        Route::delete('/shape/{shape}', [ShapeController::class, 'destroyShape'])->name('shape.destroy')->middleware(['auth', 'permission:delete']);
        Route::delete('/pattern/{pattern}', [PatternController::class, 'destroyPattern'])->name('pattern.destroy')->middleware(['auth', 'permission:delete']);
        Route::delete('/backstamp/{backstamp}', [BackstampController::class, 'destroyBackstamp'])->name('backstamp.destroy')->middleware(['auth', 'permission:delete']);
        Route::delete('/glaze/{glaze}', [GlazeController::class, 'destroyGlaze'])->name('glaze.destroy')->middleware(['auth', 'permission:delete']);
        Route::delete('/color/{color}', [ColorController::class, 'destroyColor'])->name('color.destroy')->middleware(['auth', 'permission:delete']);
        Route::delete('/effect/{effect}', [EffectController::class, 'destroyEffect'])->name('effect.destroy')->middleware(['auth', 'permission:delete']);
        Route::delete('/glaze-inside/{glazeInside}', [GlazeInsideOuterController::class, 'destroyGlazeInside'])->name('glaze-inside.destroy')->middleware(['auth', 'permission:delete']);
        Route::delete('/glaze-outer/{glazeOuter}', [GlazeInsideOuterController::class, 'destroyGlazeOuter'])->name('glaze-outer.destroy')->middleware(['auth', 'permission:delete']);
        Route::delete('/shape-collection/{shapeCollection}', [ShapeCollectionController::class, 'destroyShapeCollection'])->name('shape-collection.destroy')->middleware(['auth', 'permission:delete']); 
        Route::delete('/customer/{customer}', [CustomerController::class, 'destroyCustomer'])->name('customer.destroy')->middleware(['auth', 'permission:delete']);
        Route::delete('/item-group/{itemGroup}', [ItemGroupController::class, 'destroyItemGroup'])->name('item.group.destroy')->middleware(['auth', 'permission:delete']);
        
        // เมนูสำหรับนำเข้า-ส่งออกข้อมูลลูกค้า (Customers Management)
        Route::prefix('customers')->name('customers.')->middleware('permission:file import')->group(function () {
            Route::post('/import', [ImportController::class, 'customer_import'])->name('import');
            Route::get('/export', [ExportController::class, 'customer_export'])->name('export');
            Route::get('/template', [ExportController::class, 'customer_exportTemplate'])->name('template');
        });

        // เมนูสำหรับนำเข้า-ส่งออกข้อมูล Shape (Shape Management)
        Route::prefix('shapes')->name('shapes.')->middleware('permission:file import')->group(function () {
            Route::post('/import', [ImportController::class, 'shape_import'])->name('import');
            Route::get('/export', [ExportController::class, 'shape_export'])->name('export');
            Route::get('/template', [ExportController::class, 'shape_exportTemplate'])->name('template');
        });

        // เมนูสำหรับนำเข้า-ส่งออกข้อมูล Glaze (Glaze Management)
        Route::prefix('glazes')->name('glazes.')->middleware('permission:file import')->group(function () {
            Route::post('/import', [ImportController::class, 'glaze_import'])->name('import');
            Route::get('/export', [ExportController::class, 'glaze_export'])->name('export');
            Route::get('/template', [ExportController::class, 'glaze_exportTemplate'])->name('template');
        });

        // เมนูสำหรับนำเข้า-ส่งออกข้อมูล Pattern (Pattern Management)
        Route::prefix('patterns')->name('patterns.')->middleware('permission:file import')->group(function () {
            Route::post('/import', [ImportController::class, 'pattern_import'])->name('import');
            Route::get('/export', [ExportController::class, 'pattern_export'])->name('export');
            Route::get('/template', [ExportController::class, 'pattern_exportTemplate'])->name('template');
        });

        // เมนูสำหรับนำเข้า-ส่งออกข้อมูล Backstamp (Backstamp Management)
        Route::prefix('backstamps')->name('backstamps.')->middleware('permission:file import')->group(function () {
            Route::post('/import', [ImportController::class, 'backstamp_import'])->name('import');
            Route::get('/export', [ExportController::class, 'backstamp_export'])->name('export');
            Route::get('/template', [ExportController::class, 'backstamp_exportTemplate'])->name('template');
        });
    });
});

// route สำหรับ auth (login/register/logout)
require __DIR__ . '/auth.php';

// Language switcher
Route::get('/language/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'th'])) {
        session()->put('locale', $lang);
        App::setLocale($lang);
    }
    
    if (request()->ajax()) {
        return response()->json(['status' => 'success']);
    }
    
    return redirect()->back();
})->name('language.change');
