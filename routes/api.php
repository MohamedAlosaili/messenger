<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

// Public: Auth routes
Route::post("/auth/register", [AuthController::class, "register"]);
Route::post("/auth/login", [AuthController::class, "login"]);

// Public: Rooms routes
Route::get("/rooms", [RoomController::class, "index"]);
Route::get("/rooms/{roomId}", [RoomController::class, "show"]);

// Public: Messages routes
Route::get("/rooms/{roomId}/messages", [MessageController::class, "index"]);

Route::middleware("auth:api")->group(function () {
    // Private: Auth routes
    Route::get('/auth/me', [AuthController::class, "show"]);
    Route::delete('/auth', [AuthController::class, "destroy"]);

    // Private: Rooms Routes
    Route::post("/rooms", [RoomController::class, "store"]);
    Route::delete("/rooms", [RoomController::class, "destroy"]);

    // Private: Messages Routes
    Route::post("/rooms/{roomId}/messages", [MessageController::class, "store"]);
    Route::put("/messages/{messageId}", [MessageController::class, "update"]);
    Route::delete("/messages/{messageId}", [MessageController::class, "destroy"]);


});

Route::any("/{any}", function () {
    return response()->json([
        "success" => false,
        "data" => null,
        "errorCode" => "route_not_found",
    ], Response::HTTP_BAD_REQUEST);
})->where('any', '.*');
