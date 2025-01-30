<?php
    use App\Http\Controllers\Api\V1\UsersController;
    
    Route::apiResource('users', UsersController::class);