<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
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
    return view('welcome');
});

Auth::routes();



Route::middleware(['auth'])->group(function (){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/add-task', [TaskController::class,'store'])->name('add-task');
    Route::get('/edit-task/{task}', [TaskController::class,'edit'])->name('edit-task');
    Route::post('/update-task/{task}', [TaskController::class,'update'])->name('update-task');
    Route::get('/delete-task/{task}', [TaskController::class,'delete'])->name('delete-task');
});


