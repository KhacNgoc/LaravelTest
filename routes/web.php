<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/new', [App\Http\Controllers\HomeController::class, 'new'])->name('new_task');

Auth::routes();

Route::post('/create', [App\Http\Controllers\HomeController::class, 'create'])->name('create_task');

Auth::routes();

Route::get('/edit/{idtask}', [App\Http\Controllers\HomeController::class, 'edit'])->name('edit_task');

Auth::routes();

Route::post('/edit_complete/{idtask}', [App\Http\Controllers\HomeController::class, 'edit_complete'])->name('edit_complete_task');

Auth::routes();

Route::get('/delete/{idtask}', [App\Http\Controllers\HomeController::class, 'delete'])->name('delete_task');

Auth::routes();

Route::get('/finish/{idtask}', [App\Http\Controllers\HomeController::class, 'finish'])->name('finish_task');
