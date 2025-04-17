<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;

// Admin
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCrudController;

// Student
use App\Http\Controllers\StudentController;
use App\Http\Controllers\QueryController;

// Teacher
use App\Http\Controllers\TeacherController;

Route::get('/test', function () {
    return view('test');
});
Route::get('/', function () { 
    return view('index'); 
});

Route::get('/results/', [QueryController::class, 'results']);
Route::get('/study/{id}', [QueryController::class, 'pdf_reader']);

Route::get('/go/recovery', [LoginController::class, 'recovery']);
Route::get('/go/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('/go/login', [LoginController::class, 'login']);
Route::post('/results/', [QueryController::class, 'search']);

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard']);
    Route::get('/user-control', [AdminController::class, 'userControl']);
    Route::get('/edit', [AdminController::class, 'edit']);
    Route::get('/storage', [AdminController::class, 'messages']);
    Route::get('/recovery', [AdminController::class, 'recovery']);
    Route::get('/storage/read/{id}', [AdminController::class, 'pdf']);

    Route::post('/create', [AdminCrudController::class, 'create']);
    Route::post('/edit/{id}', [AdminCrudController::class, 'edit']);
    Route::post('/delete/{id}', [AdminCrudController::class, 'delete']);
    Route::post('/recovery/{id}', [AdminCrudController::class, 'recover']);
    Route::post('/done/{id}', [AdminCrudController::class, 'markAsDone']);

    Route::post('/editacc/{id}', [AdminCrudController::class, 'editacc']);
    Route::post('/update-acc/{id}', [AdminCrudController::class, 'updateacc']);
});

Route::prefix('student')->middleware(['auth', 'student'])->group(function () {
    Route::get('/', [StudentController::class, 'dashboard']);
    Route::get('/document-submission', [StudentController::class, 'submission']);
    Route::get('/document-status', [StudentController::class, 'status']);
    Route::get('/edit', [StudentController::class, 'edit']);
    Route::get('/pdf-reader/{id}', [StudentController::class, 'pdf_reader']);

    Route::post('/editacc/{id}', [AdminCrudController::class, 'editacc']);
    Route::post('/update-acc/{id}', [AdminCrudController::class, 'updateacc']);
    Route::post('/submit', [StudentController::class, 'submit']);
});

Route::prefix('teacher')->middleware(['auth', 'teacher'])->group(function () {
    Route::get('/', [TeacherController::class, 'dashboard']);
    Route::get('/review-studies', [TeacherController::class, 'review']);
    Route::get('/edit', [TeacherController::class, 'edit']);
    Route::get('/review-studies/{id}', [QueryController::class, 'pdf_reader_teacher']);

    Route::post('/editacc/{id}', [AdminCrudController::class, 'editacc']);
    Route::post('/update-acc/{id}', [AdminCrudController::class, 'updateacc']);
    Route::post('/review-studies/request/{id}', [TeacherController::class, 'request']);
});

Route::post('/out', [LoginController::class, 'logout']);