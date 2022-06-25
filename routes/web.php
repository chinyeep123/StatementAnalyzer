<?php

// use Ant\StatementAnalyzer\Http\Controllers\Web\StatementAnalyzerController;
// use Ant\StatementAnalyzer\Http\Controllers\Web\StatementTagController;
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

Route::post("/statements/delete", [Ant\StatementAnalyzer\Http\Controllers\Web\StatementController::class, 'destroy']);
Route::get("/import/statements/create", [Ant\StatementAnalyzer\Http\Controllers\Web\StatementController::class, 'import']);
Route::post("/import/statements", [Ant\StatementAnalyzer\Http\Controllers\Web\StatementController::class, 'storeImport']);
Route::resource('/statements', StatementController::class);
Route::resource('/statement-tags', StatementTagController::class);