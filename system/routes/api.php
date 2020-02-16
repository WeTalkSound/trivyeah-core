<?php

use Illuminate\Http\Request;
use System\Http\Controllers\Api\OrganizationController;

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

Route::group(["prefix" => "organization"], function () {
    Route::post("create", OrganizationController::class . "@create");
});