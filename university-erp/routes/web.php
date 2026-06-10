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


// Auth
Route::get('/',      [LoginController::class, 'showLogin'])->name('login');
Route::post('/login',[LoginController::class, 'login']);
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

Route::get(
    '/transcripts',
    [TranscriptController::class,'index']
)->name('transcripts.index');

Route::get(
    '/transcripts/{student}',
    [TranscriptController::class,'show']
)->name('transcripts.show');

// Protected Routes
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin only
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('departments', DepartmentController::class);
        Route::resource('students', StudentController::class);
        Route::resource('teachers', TeacherController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('notices', NoticeController::class);
        Route::resource('fees', FeeController::class);
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/students/pdf', [ReportController::class, 'studentsPdf'])->name('reports.students.pdf');
        Route::get('reports/fees/pdf', [ReportController::class, 'feesPdf'])->name('reports.fees.pdf');
        Route::get('reports/results/pdf', [ReportController::class, 'resultsPdf'])->name('reports.results.pdf');
        Route::resource('enrollments',EnrollmentController::class);
        Route::resource('routines', RoutineController::class);
        Route::resource('books', BookController::class);
        Route::resource('book-issues',BookIssueController::class);
        Route::resource('exams', ExamController::class);
        Route::resource('exam-marks',ExamMarkController::class);
        Route::resource('certificates',CertificateController::class);
    });

    // Admin + Teacher
    Route::middleware(['role:admin|teacher'])->group(function () {
        Route::resource('attendance', AttendanceController::class);
        Route::resource('results', ResultController::class);
    });
});