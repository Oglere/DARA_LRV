<?php
use App\Http\Controllers\Controller;
use App\Http\Controllers\OTP\OtpController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCrudController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\SearchController\QueryController;
use App\Http\Controllers\Teacher\TeacherController;

Route::get('/test', function () {
    return view('test');
});

Route::get('/', [QueryController::class, 'index']);
Route::get('/results/', [QueryController::class, 'results']);
Route::get('/study/{id}', [QueryController::class, 'pdf_reader']);

Route::post('/results/', [QueryController::class, 'search']);

Route::middleware(['prevent-back-history'])->group(function () {
    Route::get('/go/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/go/login', [LoginController::class, 'login']);
});

Route::get('/go/recovery', [LoginController::class, 'recovery'])->name('recovery');

Route::post('/out', [LoginController::class, 'logout']);

Route::middleware(['ensure.recovery', 'prevent-back-history'])->group(function () {
    Route::get('/go/recovery/verify', [OTPController::class, 'recovery']);
    
    Route::post('/go/recovery/email', [OtpController::class, 'verify']);
    Route::post('/go/recovery/verify/otp', [OtpController::class, 'otp']);
    Route::post('/go/recovery/{email}/login', [OtpController::class, 'login']);
});

Route::prefix('admin')->middleware(['auth', 'admin', 'prevent-back-history'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard']);
    Route::get('/dashboard/stats', [AdminController::class, 'getDashboardStats']);
    Route::get('/dashboard/recent-users', [AdminController::class, 'getRecentUsersOnline']);
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

    Route::post('/storage/{id}/1', [AdminCrudController::class, 'one']);
    Route::post('/storage/{id}/2', [AdminCrudController::class, 'two']);
    Route::post('/storage/{id}/3', [AdminCrudController::class, 'three']);
});

Route::prefix('student')->middleware(['auth', 'student', 'prevent-back-history'])->group(function () {
    Route::get('/', [StudentController::class, 'dashboard']);
    Route::get('/document-submission', [StudentController::class, 'submission']);
    Route::get('/document-status', [StudentController::class, 'status']);
    Route::get('/edit', [StudentController::class, 'edit']);
    Route::get('/pdf-reader/{id}', [StudentController::class, 'pdf_reader']);

    Route::post('/editacc/{id}', [AdminCrudController::class, 'editacc']);
    Route::post('/update-acc/{id}', [AdminCrudController::class, 'updateacc']);
    Route::post('/submit', [StudentController::class, 'submit']);
    Route::post('/pdf-reader/request', [StudentController::class, 'request']);
});

Route::prefix('teacher')->middleware(['auth', 'teacher', 'prevent-back-history'])->group(function () {
    Route::get('/', [TeacherController::class, 'dashboard']);
    Route::get('/review-studies', [TeacherController::class, 'review']);
    Route::get('/edit', [TeacherController::class, 'edit']);
    Route::get('/review-studies/{id}', [QueryController::class, 'pdf_reader_teacher']);

    Route::post('/editacc/{id}', [AdminCrudController::class, 'editacc']);
    Route::post('/update-acc/{id}', [AdminCrudController::class, 'updateacc']);
    Route::post('/review-studies/request/{id}', [TeacherController::class, 'request']);
});
