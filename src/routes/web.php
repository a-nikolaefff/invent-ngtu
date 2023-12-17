<?php

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\BuildingTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentTypeController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepairApplicationController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\RepairTypeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPanelController;
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
    Route::resource('repair-types', RepairTypeController::class);

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

    Route::post(
        'rooms/{room}/store-images',
        [RoomController::class, 'storeImages']
    )->name('rooms.store-images');
    Route::delete(
        'rooms/{room}/destroy-image',
        [RoomController::class, 'destroyImage']
    )->name('rooms.destroy-image');
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
    Route::get(
        'equipment/autocomplete',
        [EquipmentController::class, 'autocomplete']);
    Route::resource('equipment', EquipmentController::class);

    Route::post(
        'repairs/{repair}/store-before-images',
        [RepairController::class, 'storeBeforeImages']
    )->name('repairs.store-before-images');
    Route::delete(
        'repairs/{repair}/destroy-before-image',
        [RepairController::class, 'destroyBeforeImage']
    )->name('repairs.destroy-before-image');
    Route::post(
        'repairs/{repair}/store-after-images',
        [RepairController::class, 'storeAfterImages']
    )->name('repairs.store-after-images');
    Route::delete(
        'repairs/{repair}/destroy-after-image',
        [RepairController::class, 'destroyAfterImage']
    )->name('repairs.destroy-after-image');
    Route::resource('repairs', RepairController::class);

    Route::post(
        'repair-applications/{repairApplication}/store-images',
        [RepairApplicationController::class, 'storeImages']
    )->name('repair-applications.store-images');
    Route::delete(
        'repair-applications/{repairApplication}/destroy-image',
        [RepairApplicationController::class, 'destroyImage']
    )->name('repair-applications.destroy-image');
    Route::resource('repair-applications', RepairApplicationController::class);

    Route::get('/admin-main', [AdminPanelController::class, 'index'])
        ->name('admin-main')
        ->middleware('admin_or_specialist');

    Route::get('/user-main', [UserPanelController::class, 'index'])
        ->name('user-main');
});

require __DIR__ . '/auth.php';


