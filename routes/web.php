<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\SectionController;
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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sections', [HomeController::class, 'sections'])->name('sections');
Route::get('/libraries/{library_type}', [LibraryController::class, 'index'])->name('libraries.type');

Route::prefix('data')->group(function () {
    Route::resource('/sections', SectionController::class);
});

