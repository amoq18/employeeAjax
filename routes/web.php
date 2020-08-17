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

use Illuminate\Support\Facades\Route;

Route::get('/', 'ProductsController@index');
Route::post('/', 'ProductsController@getProducts')->name('getProducts');
// Route::get('/','ProductsController@index')->name('employees.getEmployees');
// Route::post('/employees/getEmployees/','EmployeesController@getEmployees')->name('employees.getEmployees');
