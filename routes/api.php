<?php

use Ant\StatementAnalyzer\Http\Controllers\API\StatementAnalyzerController;
use Ant\StatementAnalyzer\Http\Controllers\API\StatementTagController;
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

// Route::patch('order/{order}/update-status', 'OrderController@updateStatus')->middleware('currencySession');;
// Route::patch('order/{order}/update-tracking-number', 'OrderController@updateTracking')->middleware('currencySession');;
// Route::patch('order/{order}/update-items', 'OrderController@updateItems')->middleware('currencySession');;
// Route::patch('order/{order}/update-contact/{type}', 'OrderController@updateContact')->middleware('currencySession');;
// Route::get('order-products', 'OrderController@products')->middleware('currencySession');
// Route::get('couriers', 'OrderController@listCouriers');

// Route::get('order/meta', 'OrderController@meta');
// Route::post('order/{order}/generate-invoice', 'OrderController@generateInvoice');
// Route::post('order/{order}/update-invoice', 'OrderController@updateInvoice');
// Route::get('statement-analyzer/index', 'StatementAnalyzerController@index');
Route::get('statement-tags/getAll', [StatementTagController::class, 'getAll'])->name('api.statement-tags.getAll');
Route::post('statement-tags', [StatementTagController::class, 'store'])->name('api.statement-tags.store');
Route::get('statements/getAll', [StatementAnalyzerController::class, 'getAll'])->name('api.statements.getAll');