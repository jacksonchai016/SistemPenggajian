<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('layouts.main');
// });

Route::resource('admin/user_access', 'App\Http\Controllers\Admin\user_accessController');
Route::resource('admin/employee', 'App\Http\Controllers\Admin\employeeController');
Route::resource('admin/contract', 'App\Http\Controllers\Admin\contractController');
Route::resource('admin/attendance', 'App\Http\Controllers\Admin\attendanceController');
Route::resource('admin/bpjs_data', 'App\Http\Controllers\Admin\bpjs_dataController');
Route::resource('admin/payslip', 'App\Http\Controllers\Admin\payslipController');
