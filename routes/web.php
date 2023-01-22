<?php

use App\Http\Controllers\ClassRecordController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectionStudentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UnitActionController;
use App\Http\Controllers\UnitItemController;
use App\Http\Controllers\UnitScoreController;
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

Route::get('/', [HomeController::class, 'sections'])->name('home');
Route::get('/sections', [HomeController::class, 'sections'])->name('sections');
Route::get('/students', [HomeController::class, 'students'])->name('students');
Route::get('/guardians', [HomeController::class, 'guardians'])->name('guardians');
Route::get('/teachers', [HomeController::class, 'teachers'])->name('teachers');
Route::get('/sections/{uuid}/manage/{type?}', [HomeController::class, 'manageSection'])->name('sections.manage');
Route::get('/libraries/{library_type}', [LibraryController::class, 'index'])->name('libraries.type');

Route::prefix('data')->group(function () {
    Route::resource('/guardians', GuardianController::class);
    Route::resource('/sections', SectionController::class);
    Route::resource('/students', StudentController::class);
    Route::resource('/teachers', TeacherController::class);
    Route::resource('/section-students', SectionStudentController::class);
    Route::resource('/unit-items', UnitItemController::class);
    Route::resource('/unit-scores', UnitScoreController::class);
    Route::resource('/unit-actions', UnitActionController::class);
    Route::resource('/class-records', ClassRecordController::class);
    Route::get('/class-records/{id}/unit-items', [ClassRecordController::class, 'unitItems'])->name('class-records.unit-items');
    Route::get('/class-records/{id}/unit-scores', [ClassRecordController::class, 'unitScore'])->name('class-records.unit-scores');
    Route::get('/class-records/{id}/unit-summary', [ClassRecordController::class, 'unitSummary'])->name('class-records.unit-summary');
    Route::get('/all/teachers', [TeacherController::class, 'all'])->name('all.teachers');
    Route::get('/all/guardians', [TeacherController::class, 'all'])->name('all.guardians');
});

