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

// Route::group(['middleware' => 'auth'], function() {
//     Route::get('/my-account/orders', 'OrderController@index')->name('order.index');
//     Route::get('/my-account/view-order/{order}', 'OrderController@show')->name('order.show');
// });
// Route::get('/order/{order}/pdf', 'OrderController@downloadPdf')->middleware('signed')->name('order.pdf');;
// Route::get('/view-order/{order}', 'OrderController@showSigned')->middleware('signed')->name('order.show_signed');

Route::get('/statement-analyzer', '\Ant\StatementAnalyzer\Http\Controllers\Web\StatementAnalyzerController@index')->name('statement-analyzer.index');