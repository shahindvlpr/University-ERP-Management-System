<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookIssueController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamMarkController;
use App\Http\Controllers\TranscriptController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\StudentPortalController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LoginController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Transcript
    |--------------------------------------------------------------------------
    */

    Route::get('/transcripts', [TranscriptController::class, 'index'])
        ->name('transcripts.index');

    Route::get('/transcripts/{student}', [TranscriptController::class, 'show'])
        ->name('transcripts.show');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:admin'])->group(function () {

        Route::resource('departments', DepartmentController::class);

        Route::resource('students', StudentController::class);

        Route::resource('teachers', TeacherController::class);

        Route::resource('courses', CourseController::class);

        Route::resource('notices', NoticeController::class);

        Route::resource('fees', FeeController::class);

        Route::resource('enrollments', EnrollmentController::class);

        Route::resource('routines', RoutineController::class);

        Route::resource('books', BookController::class);

        Route::resource('book-issues', BookIssueController::class);

        Route::resource('exams', ExamController::class);

        Route::resource('exam-marks', ExamMarkController::class);

        Route::resource('certificates', CertificateController::class);

        /*
        |--------------------------------------------------------------------------
        | Reports
        |--------------------------------------------------------------------------
        */

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/students/pdf', [ReportController::class, 'studentsPdf'])
            ->name('reports.students.pdf');

        Route::get('/reports/fees/pdf', [ReportController::class, 'feesPdf'])
            ->name('reports.fees.pdf');

        Route::get('/reports/results/pdf', [ReportController::class, 'resultsPdf'])
            ->name('reports.results.pdf');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin + Teacher Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:admin|teacher'])->group(function () {

        Route::resource('attendance', AttendanceController::class);

        Route::resource('results', ResultController::class);

    });


/*
|--------------------------------------------------------------------------
| Student Portal
|--------------------------------------------------------------------------
*/

Route::middleware(['role:admin|student'])
    ->prefix('student')
    ->group(function () {

        Route::get(
            '/dashboard',
            [StudentPortalController::class, 'dashboard']
        )->name('student.dashboard');

        Route::get(
            '/attendance',
            [StudentPortalController::class, 'attendance']
        )->name('student.attendance');

        Route::get(
            '/results',
            [StudentPortalController::class, 'results']
        )->name('student.results');

        Route::get(
            '/courses',
            [StudentPortalController::class, 'courses']
        )->name('student.courses');

        Route::get(
            '/fees',
            [StudentPortalController::class, 'fees']
        )->name('student.fees');

        Route::get(
            '/transcript',
            [StudentPortalController::class, 'transcript']
        )->name('student.transcript');

        Route::get(
            '/notices',
            [StudentPortalController::class, 'notices']
        )->name('student.notices');

    });

});