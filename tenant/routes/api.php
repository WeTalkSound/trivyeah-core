<?php

use Tenant\Http\Controllers\Api\AuthenticationController;


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

Route::post("authenticate", AuthenticationController::class . "@authenticate");
Route::post("create-user", AuthenticationController::class . "@create");

Route::group(["prefix" => "forms", "middleware" => "auth:tenant"], function () {
    Route::post("create", function () {
        return Tenant\Models\Form::create(["title" => "test form", "slug" => "test-form"]);
    });
});
