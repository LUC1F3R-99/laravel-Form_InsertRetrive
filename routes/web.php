<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('/store', [StudentController::class, 'store'])->name('welcome.form.data.saved');
Route::get('/fetch', [StudentController::class, 'fetch'])->name('welcome.form.data.fetched');
Route::get('/edit', [StudentController::class, 'edit'])->name('welcome.form.data.edit');
Route::post('/update', [StudentController::class, 'update'])->name('welcome.form.data.update');
Route::delete('/delete', [StudentController::class,'delete'])->name('delete');
