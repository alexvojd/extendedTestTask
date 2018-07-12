<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'AreasListController@showAreasList');
Route::get('/places', 'AreasListController@showAreasList');
Route::get('/addplace', 'AreasListController@showAddPlace');

Route::post('/', 'AreasListController@showAreasList');
Route::post('/saveplace', 'AreasListController@savePlace');