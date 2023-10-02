<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DriveController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'verify'=>true
]);

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('drive')->group(function () {
        Route::get("allfiles", [DriveController::class, 'allfiles'])->name("drive.allfiles")->middleware(['RuleTwo']);
        Route::get("index", [DriveController::class, 'index'])->name("drive.index");
        Route::get("create", [DriveController::class, 'create'])->name("drive.create");
        Route::post("store", [DriveController::class, 'store'])->name("drive.store");
        Route::get("listUserFile", [DriveController::class, 'listUserFile'])->name("drive.listUserFile");
        // Route With ID
        Route::get("edit/{id}", [DriveController::class, 'edit'])->name("drive.edit");
        Route::post("update/{id}", [DriveController::class, 'update'])->name("drive.update");
        Route::get("show/{id}", [DriveController::class, 'show'])->name("drive.show");
        Route::get("destroy/{id}", [DriveController::class, 'destroy'])->name("drive.destroy");
        Route::get("download/{id}", [DriveController::class, 'download'])->name("drive.download");


        Route::get("changeStatus/{id}", [DriveController::class, 'changeStatus'])->name("drive.changeStatus");
    });

    Route::prefix('category')->group(function () {
        Route::get("index", [CategoryController::class, 'index'])->name("category.index");
        Route::get("create", [CategoryController::class, 'create'])->name("category.create");
        Route::post("store", [CategoryController::class, 'store'])->name("category.store");
        // Route With ID
        Route::get("edit/{id}", [CategoryController::class, 'edit'])->name("category.edit");
        Route::post("update/{id}", [CategoryController::class, 'update'])->name("category.update");
        Route::get("show/{id}", [CategoryController::class, 'show'])->name("category.show");
        Route::get("destroy/{id}", [CategoryController::class, 'destroy'])->name("category.destroy");
    });

    Route::prefix('user')->group(function () {
        Route::get("index", [UserController::class, 'index'])->name("user.index")->middleware("Admin");
    });
});
