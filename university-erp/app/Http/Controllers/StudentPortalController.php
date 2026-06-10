<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Result;
use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\FeeInvoice;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;

class StudentPortalController extends Controller
{
    public function dashboard()
{
    $student = Student::first();

    $attendanceCount = Attendance::where(
        'student_id',
        $student->id
    )->count();

    $resultCount = Result::where(
        'student_id',
        $student->id
    )->count();

    $courseCount = Enrollment::where(
        'student_id',
        $student->id
    )->count();

    $feeDue = FeeInvoice::where(
        'student_id',
        $student->id
    )->sum('due_amount');

    return view(
        'student_portal.dashboard',
        compact(
            'student',
            'attendanceCount',
            'resultCount',
            'courseCount',
            'feeDue'
        )
    );
}

    public function attendance()
{
    $student = Student::where(
        'user_id',
        auth()->id()
    )->first();

    $attendances = Attendance::with('course')
                    ->where(
                        'student_id',
                        $student->id
                    )
                    ->latest()
                    ->paginate(10);

    return view(
        'student_portal.attendance',
        compact('attendances')
    );
}

public function results()
{
    $student = Student::where(
        'user_id',
        auth()->id()
    )->first();

    $results = Result::with('course')
                ->where(
                    'student_id',
                    $student->id
                )
                ->paginate(10);

    return view(
        'student_portal.results',
        compact('results')
    );
}

public function courses()
{
    $student = Student::where(
        'user_id',
        auth()->id()
    )->first();

    $courses = Enrollment::with('course')
                ->where(
                    'student_id',
                    $student->id
                )
                ->paginate(10);

    return view(
        'student_portal.courses',
        compact('courses')
    );
}

public function fees()
{
    $student = Student::where(
        'user_id',
        auth()->id()
    )->first();

    $fees = FeeInvoice::where(
        'student_id',
        $student->id
    )->paginate(10);

    return view(
        'student_portal.fees',
        compact('fees')
    );
}

public function transcript()
{
    $student = Student::where(
        'user_id',
        auth()->id()
    )->first();

    $results = Result::with('course')
                ->where(
                    'student_id',
                    $student->id
                )
                ->get();

    return view(
        'student_portal.transcript',
        compact(
            'student',
            'results'
        )
    );
}
}