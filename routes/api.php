<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DriveController;
use App\Http\Controllers\API\authUserApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("user")->group(function () {
    Route::post("register", [authUserApiController::class, 'register']);
    Route::post("login", [authUserApiController::class, 'login']);
});

Route::middleware("auth:sanctum")->group(function () {
    Route::prefix('drive')->group(function () {
        Route::get("allfiles", [DriveController::class, 'allfiles'])->name("drive.allfiles");
        Route::get("index", [DriveController::class, 'index'])->name("drive.index");
        Route::post("store", [DriveController::class, 'store'])->name("drive.store");
        Route::get("listUserFile/{id}/{userId}", [DriveController::class, 'listUserFile'])->name("drive.listUserFile");
        // Route With ID
        Route::post("update/{id}", [DriveController::class, 'update'])->name("drive.update");
        Route::get("show/{id}", [DriveController::class, 'show'])->name("drive.show");
        Route::delete("destroy/{id}", [DriveController::class, 'destroy'])->name("drive.destroy");
        Route::get("download/{id}", [DriveController::class, 'download'])->name("drive.download");


        Route::get("changeStatus/{id}", [DriveController::class, 'changeStatus'])->name("drive.changeStatus");
    });
    Route::get("logout", [authUserApiController::class, 'logout']);
});
