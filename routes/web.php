<?php

use App\Http\Controllers\productController;
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

Route::get('/',[productController::class,'index']);
Route::post('/store',[productController::class,'store'])->name('store');
Route::get('/fetchAll',[productController::class,'fetchAll'])->name('fetchAll');
Route::get('/edit',[productController::class,'edit'])->name('edit');
Route::post('/update',[productController::class,'update'])->name('update');
Route::post('/delete',[productController::class,'delete'])->name('delete');