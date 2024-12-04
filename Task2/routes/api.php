<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PositionController;
use App\Http\Controllers\SpecificationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CompanyController;

Route::group(['prefix' => 'positions'], function () {
    Route::get('/', [PositionController::class, 'index']);
    Route::post('/', [PositionController::class, 'create']);
    Route::post('/{id}', [PositionController::class, 'find']);
    Route::put('/{id}', [PositionController::class, 'update']);
    Route::delete('/{id}', [PositionController::class, 'delete']);
});

Route::group(['prefix' => 'specifications'], function () {
    Route::get('/', [SpecificationController::class, 'index']);
    Route::post('/', [SpecificationController::class, 'create']);
    Route::post('/{id}', [SpecificationController::class, 'find']);
    Route::put('/{id}', [SpecificationController::class, 'update']);
    Route::delete('/{id}', [SpecificationController::class, 'delete']);
});

Route::group(['prefix' => 'companies'], function () {
    Route::get('/', [CompanyController::class, 'index']);
    Route::post('/', [CompanyController::class, 'create']);
    Route::post('/{id}', [CompanyController::class, 'find']);
    Route::put('/{id}', [CompanyController::class, 'update']);
    Route::delete('/{id}', [CompanyController::class, 'delete']);
});

Route::group(['prefix' => 'employees'], function () {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::post('/', [EmployeeController::class, 'create']);
    Route::post('/{id}', [EmployeeController::class, 'find']);
    Route::put('/{id}', [EmployeeController::class, 'update']);
    Route::delete('/{id}', [EmployeeController::class, 'delete']);
    Route::get('/show', [EmployeeController::class, 'show']);
});
