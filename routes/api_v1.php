<?php
    use App\Http\Controllers\Api\V1\UsersController;
    use App\Http\Controllers\Api\V1\ClassesController;

    Route::apiResource('users', UsersController::class);
    Route::apiResource('classes', ClassesController::class);