<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\FeeInvoice;
use App\Models\Notice;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students'      => Student::count(),
            'teachers'      => Teacher::count(),
            'courses'       => Course::count(),
            'fee_due'       => FeeInvoice::sum('due_amount'),
            'today_present' => Attendance::where('status', 'present')->count(),
            'today_absent'  => Attendance::where('status', 'absent')->count(),
        ];

        $recent_notices = Notice::latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recent_notices'));
        
        $recent_students = Student::latest()->take(5)->get();
    }
}