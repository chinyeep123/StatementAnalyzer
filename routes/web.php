<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your addon. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'statements'], function () {
    Route::any("/search", [Ant\StatementAnalyzer\Http\Controllers\Web\StatementController::class, 'index']);
    Route::post("/delete", [Ant\StatementAnalyzer\Http\Controllers\Web\StatementController::class, 'destroy']);
});
Route::group(['prefix' => 'import'], function () {
    Route::get("/statements/create", [Ant\StatementAnalyzer\Http\Controllers\Web\StatementController::class, 'import']);
    Route::post("/statements", [Ant\StatementAnalyzer\Http\Controllers\Web\StatementController::class, 'storeImport']);
});
//AUTOCOMPLETE AJAX FEED
Route::group(['prefix' => 'feed'], function () {
    Route::get("/statements/account_numbers", [Ant\StatementAnalyzer\Http\Controllers\Web\StatementController::class, 'accountNumbers']);
    Route::get("/statement-tags/categories", [Ant\StatementAnalyzer\Http\Controllers\Web\StatementTagController::class, 'categories']);
    Route::get("/statement-tags/tags", [Ant\StatementAnalyzer\Http\Controllers\Web\StatementTagController::class, 'tags']);
    Route::get("/statement-tags/all", [Ant\StatementAnalyzer\Http\Controllers\Web\StatementTagController::class, 'all']);
});

Route::resource('/statements', StatementController::class);
Route::resource('/statement-tags', StatementTagController::class);