<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your addon. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/statement-analyzer', function () {
    return 'aa';
})->name('datatable.statement-analysis.index');
// Route::get('/statement-analyzer', '\Ant\StatementAnalyzer\Http\Controllers\DataTable\StatementAnalyzerController@index');