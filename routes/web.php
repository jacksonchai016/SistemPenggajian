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

Route::get('/', function () {
    return view('index');
});
// Route::get('/', function () {
//     return view('sistem_penggajian');
// });
// Route::get('/', function () {
//     return view('kontrak');
// });
// Route::get('/', function () {
//     return view('attendance');
// });
// Route::get('/', function () {
//     return view('about');
// });

Route::resource('admin/user_access', 'App\Http\Controllers\Admin\user_accessController');