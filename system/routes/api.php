<?php

use Illuminate\Http\Request;
use System\Http\Controllers\Api\v1\OrganizationController;
use System\Http\Controllers\Api\V1\AuthenticationController;

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

Route::any("health-check", function () {
    return System\Models\Organization::first();
});

Route::group(["prefix" => "v1"], function (){
    Route::post("create-user", AuthenticationController::class . "@create");
    Route::post("authenticate", AuthenticationController::class . "@authenticate");
    Route::get("bootstrap", OrganizationController::class . "@bootstrap");
    
    Route::group(["prefix" => "organization"], function () {
        Route::post("create", OrganizationController::class . "@create");
    });
});
