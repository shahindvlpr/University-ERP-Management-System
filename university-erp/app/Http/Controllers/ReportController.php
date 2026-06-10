<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Attendance;
use App\Models\Result;
use App\Models\FeeInvoice;

class ReportController extends Controller
{
    public function index()
    {
        $data = [

            'students' => Student::count(),

            'teachers' => Teacher::count(),

            'courses' => Course::count(),

            'attendance_present' =>
                Attendance::where('status','present')->count(),

            'attendance_absent' =>
                Attendance::where('status','absent')->count(),

            'results' => Result::count(),

            'fees_collected' =>
                FeeInvoice::sum('paid_amount'),

            'fees_due' =>
                FeeInvoice::sum('due_amount'),
        ];

        return view('reports.index', compact('data'));
    }
}