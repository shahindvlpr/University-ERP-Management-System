<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Course;
use App\Models\Routine;
use App\Models\Attendance;
use App\Models\Result;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class TeacherPortalController extends Controller
{
    private function getTeacher()
{
    return Teacher::first();
}

    public function dashboard()
{
    $teacher = $this->getTeacher();

    $courseCount = Course::where(
        'teacher_id',
        $teacher->id
    )->count();

    $routineCount = Routine::where(
        'teacher_id',
        $teacher->id
    )->count();

    $studentCount = Enrollment::whereHas(
        'course',
        function($q) use ($teacher)
        {
            $q->where(
                'teacher_id',
                $teacher->id
            );
        }
    )->count();

    $todayClasses = Routine::where(
        'teacher_id',
        $teacher->id
    )->where(
        'day',
        now()->format('l')
    )->count();

    return view(
        'teacher_portal.dashboard',
        compact(
            'teacher',
            'courseCount',
            'routineCount',
            'studentCount',
            'todayClasses'
        )
    );
}

    public function courses()
    {
        $teacher = $this->getTeacher();

        $courses = Course::where(
            'teacher_id',
            $teacher->id
        )->get();

        return view(
            'teacher_portal.courses',
            compact('courses')
        );
    }

    public function students()
    {
        $teacher = $this->getTeacher();

        $students = Enrollment::with(
            'student',
            'course'
        )
        ->whereHas('course', function($q) use ($teacher)
        {
            $q->where(
                'teacher_id',
                $teacher->id
            );
        })
        ->get();

        return view(
            'teacher_portal.students',
            compact('students')
        );
    }

    public function routine()
    {
        $teacher = $this->getTeacher();

        $routines = Routine::where(
            'teacher_id',
            $teacher->id
        )->get();

        return view(
            'teacher_portal.routine',
            compact('routines')
        );
    }

    public function attendance()
    {
        return view(
            'teacher_portal.attendance'
        );
    }

    public function results()
    {
        return view(
            'teacher_portal.results'
        );
    }

    public function profile()
    {
        $teacher = $this->getTeacher();

        return view(
            'teacher_portal.profile',
            compact('teacher')
        );
    }
}