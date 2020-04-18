<?php

use TrivYeah\Support\RouteName as RN;
use Tenant\Http\Controllers\Api\V1\FormController;
use Tenant\Http\Controllers\Api\V1\AuthenticationController;


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
    return Tenant\Models\Setting::first();
});

Route::group(["prefix" => "v1"], function () {
    Route::post("authenticate", AuthenticationController::class . "@authenticate");
    Route::post("create-user", AuthenticationController::class . "@create");
    
    Route::group(["prefix" => "forms"], function () {
        Route::post("create", FormController::class . "@createForm")->name(RN::CREATE_FORM);
        Route::put("update", FormController::class . "@updateForm")->name(RN::UPDATE_FORM);
        Route::get("list", FormController::class . "@listForms")->name(RN::LIST_FORMS);
        Route::get("view", FormController::class . "@viewForm")->name(RN::VIEW_FORM);
        Route::delete("delete", FormController::class . "@deleteForm")->name(RN::DELETE_FORM);
        Route::post("import", FormController::class . "@import")->name(RN::IMPORT_FORM);
    });
});

