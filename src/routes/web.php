<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\BuildingTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentTypeController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\UserController;
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
    return redirect()->route('buildings.index');
});

Route::get(
    'departments/autocomplete',
    [DepartmentController::class, 'autocomplete']
);
Route::get('buildings/floor-amount', [BuildingController::class, 'floorAmount']
);

Route::middleware(['auth', 'verified', 'authorized'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name(
        'profile.edit'
    );
    Route::patch('/profile', [ProfileController::class, 'update'])->name(
        'profile.update'
    );
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name(
        'profile.destroy'
    );

    Route::resource('users', UserController::class);
    Route::resource('department-types', DepartmentTypeController::class);
    Route::resource('building-types', BuildingTypeController::class);
    Route::resource('room-types', RoomTypeController::class);
    Route::resource('equipment-types', EquipmentTypeController::class);

    Route::resource('departments', DepartmentController::class);

    Route::post(
        'buildings/{building}/store-images',
        [BuildingController::class, 'storeImages']
    )->name('buildings.store-images');
    Route::delete(
        'buildings/{building}/destroy-image',
        [BuildingController::class, 'destroyImage']
    )->name('buildings.destroy-image');
    Route::resource('buildings', BuildingController::class);

    Route::get('rooms/autocomplete', [RoomController::class, 'autocomplete']);
    Route::resource('rooms', RoomController::class);

    Route::post(
        'equipment/{equipment}/store-images',
        [EquipmentController::class, 'storeImages']
    )->name('equipment.store-images');
    Route::delete(
        'equipment/{equipment}/destroy-image',
        [EquipmentController::class, 'destroyImage']
    )->name('equipment.destroy-image');
    Route::resource('equipment', EquipmentController::class);
});

require __DIR__ . '/auth.php';


