<?php
    use App\Http\Controllers\Api\V1\CustomAuthController;

    Route::apiResource('users', CustomAuthController::class);