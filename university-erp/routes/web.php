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
use App\Http\Controllers\TeacherPortalController;

/*
|--------------------------------------------------------------------------
| Public Routes — Auth
|--------------------------------------------------------------------------
*/

Route::get('/',          [LoginController::class, 'showLogin'])->name('login');
Route::post('/login',    [LoginController::class, 'login']);
Route::post('/logout',   [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |----------------------------------------------------------------------
    | Shared — Dashboard & Transcript (admin + all roles)
    |----------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');

    Route::get('/transcripts',           [TranscriptController::class, 'index'])
         ->name('transcripts.index');
    Route::get('/transcripts/{student}', [TranscriptController::class, 'show'])
         ->name('transcripts.show');

    /*
    |----------------------------------------------------------------------
    | Admin Only
    |----------------------------------------------------------------------
    */

    Route::middleware(['role:admin'])->group(function () {

        // Academic
        Route::resource('departments', DepartmentController::class);
        Route::resource('students',    StudentController::class);
        Route::resource('teachers',    TeacherController::class);
        Route::resource('courses',     CourseController::class);
        Route::resource('enrollments', EnrollmentController::class);

        // Management
        Route::resource('notices',     NoticeController::class);
        Route::resource('fees',        FeeController::class);
        Route::resource('routines',    RoutineController::class);

        // Library
        Route::resource('books',       BookController::class);
        Route::resource('book-issues', BookIssueController::class);

        // Exam & Certificates
        Route::resource('exams',        ExamController::class);
        Route::resource('exam-marks',   ExamMarkController::class);
        Route::resource('certificates', CertificateController::class);

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/',                 [ReportController::class, 'index'])        ->name('index');
            Route::get('/students/pdf',     [ReportController::class, 'studentsPdf']) ->name('students.pdf');
            Route::get('/students/excel',   [ReportController::class, 'studentsExcel'])->name('students.excel');
            Route::get('/results/pdf',      [ReportController::class, 'resultsPdf'])  ->name('results.pdf');
            Route::get('/results/excel',    [ReportController::class, 'resultsExcel'])->name('results.excel');
            Route::get('/fees/pdf',         [ReportController::class, 'feesPdf'])     ->name('fees.pdf');
            Route::get('/fees/excel',       [ReportController::class, 'feesExcel'])   ->name('fees.excel');
            Route::get('/attendance/pdf',   [ReportController::class, 'attendancePdf'])->name('attendance.pdf');
            Route::get('/attendance/excel', [ReportController::class, 'attendanceExcel'])->name('attendance.excel');
            Route::get('/marksheet',        [ReportController::class, 'marksheet'])   ->name('marksheet');
            Route::get('/invoice/{id}/pdf', [ReportController::class, 'invoicePdf'])  ->name('invoice.pdf');
            Route::get('/export/excel', [StudentController::class, 'export'])->name('export');
            Route::get('students/export/excel', [StudentController::class, 'export'])->name('students.export');

        });
    });

    /*
    |----------------------------------------------------------------------
    | Admin + Teacher
    |----------------------------------------------------------------------
    */

    Route::middleware(['role:admin|teacher'])->group(function () {
        Route::resource('attendance', AttendanceController::class);
        Route::resource('results',    ResultController::class);
    });

    /*
    |----------------------------------------------------------------------
    | Student Portal
    |----------------------------------------------------------------------
    */

// Student Routes
Route::middleware(['auth', 'role:admin|student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [StudentPortalController::class, 'courses'])->name('courses');
    Route::get('/courses/{id}', [StudentPortalController::class, 'courseDetails'])->name('course.details');
    Route::get('/courses/{id}/materials', [StudentPortalController::class, 'courseMaterials'])->name('course.materials');
    Route::get('/attendance', [StudentPortalController::class, 'attendance'])->name('attendance');
    Route::get('/results', [StudentPortalController::class, 'results'])->name('results');
    Route::get('/fees', [StudentPortalController::class, 'fees'])->name('fees');
    Route::get('/routine', [StudentPortalController::class, 'routine'])->name('routine');
    Route::get('/library', [StudentPortalController::class, 'library'])->name('library');
    Route::get('/assignments', [StudentPortalController::class, 'assignments'])->name('assignments');
    Route::get('/transcript', [StudentPortalController::class, 'transcript'])->name('transcript');
    Route::get('/notices', [StudentPortalController::class, 'notices'])->name('notices');
    Route::get('/settings', [StudentPortalController::class, 'settings'])->name('settings');
});
    /*
    |----------------------------------------------------------------------
    | Teacher Portal
    |----------------------------------------------------------------------
    */

    Route::middleware(['auth', 'role:admin|teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [TeacherPortalController::class, 'dashboard'])->name('dashboard');
    
    // Course Management
    Route::get('/courses', [TeacherPortalController::class, 'courses'])->name('courses');
    Route::get('/courses/{id}', [TeacherPortalController::class, 'courseDetails'])->name('course.details');
    
    // Student Management
    Route::get('/students', [TeacherPortalController::class, 'students'])->name('students');
    Route::get('/students/{id}', [TeacherPortalController::class, 'studentDetails'])->name('student.details');
    
    // Routine
    Route::get('/routine', [TeacherPortalController::class, 'routine'])->name('routine');
    Route::post('/routine/create', [TeacherPortalController::class, 'createRoutine'])->name('routine.create');
    
    // Attendance
    Route::get('/attendance', [TeacherPortalController::class, 'attendance'])->name('attendance');
    Route::post('/attendance/mark', [TeacherPortalController::class, 'markAttendance'])->name('attendance.mark');
    Route::get('/attendance/data', [TeacherPortalController::class, 'getAttendanceData'])->name('attendance.data');
    
    // Results
    Route::get('/results', [TeacherPortalController::class, 'results'])->name('results');
    Route::post('/results/upload', [TeacherPortalController::class, 'uploadResults'])->name('results.upload');
    
    // Assignments - ADD THESE ROUTES
    Route::get('/assignments/create', [TeacherPortalController::class, 'createAssignment'])->name('assignments.create');
    Route::post('/assignments/store', [TeacherPortalController::class, 'storeAssignment'])->name('assignments.store');
    Route::get('/assignments/{id}/edit', [TeacherPortalController::class, 'editAssignment'])->name('assignments.edit');
    Route::put('/assignments/{id}', [TeacherPortalController::class, 'updateAssignment'])->name('assignments.update');
    Route::delete('/assignments/{id}', [TeacherPortalController::class, 'deleteAssignment'])->name('assignments.delete');
    
    // Notices
    Route::get('/notices', [TeacherPortalController::class, 'notices'])->name('notices');
    Route::post('/notices/create', [TeacherPortalController::class, 'createNotice'])->name('notices.create');
    
    // Profile
    Route::get('/profile', [TeacherPortalController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [TeacherPortalController::class, 'updateProfile'])->name('profile.update');
});

});