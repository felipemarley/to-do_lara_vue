<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;

Route::apiResource('tasks', TaskController::class);

Route::get('/ping', function () {
    return response()->json(['pong' => true]);
});

Route::get('/ping', function (Request $request) {
    return response()->json(['message' => 'pong']);
});
