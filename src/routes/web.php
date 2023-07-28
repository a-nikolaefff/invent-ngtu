<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\BuildingTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentTypeController;
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
    return redirect()->route('departments.index');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::get('departments/autocomplete', [DepartmentController::class, 'autocomplete']);

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

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('department-types', DepartmentTypeController::class);
    Route::resource('building-types', BuildingTypeController::class);
    Route::resource('room-types', RoomTypeController::class);
    Route::resource('equipment-types', EquipmentTypeController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('buildings', BuildingController::class);
    Route::resource('rooms', RoomController::class);
});

require __DIR__ . '/auth.php';


