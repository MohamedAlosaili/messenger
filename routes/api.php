<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;


Route::post("/auth/login", [AuthController::class, "register"]);

Route::any("/{any}", function () {
    return response()->json([
        "success" => false,
        "data" => null,
        "errorCode" => "route_not_found",
    ], Response::HTTP_BAD_REQUEST);
})->where('any', '.*');
