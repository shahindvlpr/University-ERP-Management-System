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
    // ── Helper: logged-in student ────────────────────────────────
    // private function getStudent(): Student
    // {
    //     return Student::where('user_id', Auth::id())->firstOrFail();
    // }

    private function getStudent(): Student
    {
        return Student::first();
    }

    // ── Dashboard ────────────────────────────────────────────────
    public function dashboard()
    {
        $student = $this->getStudent();

        // Counts
        $courseCount = Enrollment::where('student_id', $student->id)
                                 ->where('status', 'enrolled')
                                 ->count();

        // Attendance
        $totalAtt       = Attendance::where('student_id', $student->id)->count();
        $presentAtt     = Attendance::where('student_id', $student->id)
                                    ->where('status', 'present')->count();
        $attendanceCount = $totalAtt;
        $attendanceRate  = $totalAtt > 0
                           ? round(($presentAtt / $totalAtt) * 100)
                           : 0;

        // Results & CGPA
        $allResults  = Result::with('course')
                             ->where('student_id', $student->id)
                             ->latest()
                             ->get();
        $resultCount   = $allResults->count();
        $cgpa          = $allResults->avg('gpa') ?? 0;
        $recentResults = $allResults->take(4);

        // Fees
        $feeDue  = FeeInvoice::where('student_id', $student->id)
                             ->where('status', '!=', 'paid')
                             ->sum('due_amount');
        $feePaid = FeeInvoice::where('student_id', $student->id)
                             ->sum('paid_amount');

        // Notices (for students or all)
        $notices = Notice::where('is_published', true)
                         ->whereIn('audience', ['all', 'students'])
                         ->latest()
                         ->take(4)
                         ->get();

        return view('student_portal.dashboard', compact(
            'student',
            'courseCount',
            'attendanceCount',
            'attendanceRate',
            'resultCount',
            'cgpa',
            'recentResults',
            'feeDue',
            'feePaid',
            'notices',
        ));
    }

    // ── Attendance ───────────────────────────────────────────────
    public function attendance()
    {
        $student = $this->getStudent();

        $attendances = Attendance::with('course')
                                 ->where('student_id', $student->id)
                                 ->latest()
                                 ->paginate(15);

        // Summary stats
        $total   = Attendance::where('student_id', $student->id)->count();
        $present = Attendance::where('student_id', $student->id)
                             ->where('status', 'present')->count();
        $absent  = Attendance::where('student_id', $student->id)
                             ->where('status', 'absent')->count();
        $late    = Attendance::where('student_id', $student->id)
                             ->where('status', 'late')->count();
        $rate    = $total > 0 ? round(($present / $total) * 100) : 0;

        return view('student_portal.attendance', compact(
            'student',
            'attendances',
            'total',
            'present',
            'absent',
            'late',
            'rate',
        ));
    }

    // ── Results ──────────────────────────────────────────────────
    public function results()
    {
        $student = $this->getStudent();

        $results = Result::with('course')
                         ->where('student_id', $student->id)
                         ->latest()
                         ->paginate(15);

        // CGPA & grade breakdown
        $allResults = Result::where('student_id', $student->id)->get();
        $cgpa       = round($allResults->avg('gpa') ?? 0, 2);
        $highest    = $allResults->max('total_marks') ?? 0;
        $lowest     = $allResults->min('total_marks') ?? 0;
        $average    = round($allResults->avg('total_marks') ?? 0, 1);

        return view('student_portal.results', compact(
            'student',
            'results',
            'cgpa',
            'highest',
            'lowest',
            'average',
        ));
    }

    // ── Courses ──────────────────────────────────────────────────
    public function courses()
    {
        $student = $this->getStudent();

        $courses = Enrollment::with(['course.teacher', 'course.department'])
                             ->where('student_id', $student->id)
                             ->latest()
                             ->paginate(12);

        $totalCredits = Enrollment::with('course')
                                  ->where('student_id', $student->id)
                                  ->where('status', 'enrolled')
                                  ->get()
                                  ->sum(fn($e) => $e->course->credit_hours ?? 0);

        return view('student_portal.courses', compact(
            'student',
            'courses',
            'totalCredits',
        ));
    }

    // ── Fees ─────────────────────────────────────────────────────
    public function fees()
    {
        $student = $this->getStudent();

        $fees = FeeInvoice::with('payments')
                          ->where('student_id', $student->id)
                          ->latest()
                          ->paginate(10);

        // Summary
        $totalAmount = FeeInvoice::where('student_id', $student->id)->sum('amount');
        $totalPaid   = FeeInvoice::where('student_id', $student->id)->sum('paid_amount');
        $totalDue    = FeeInvoice::where('student_id', $student->id)->sum('due_amount');
        $paidCount   = FeeInvoice::where('student_id', $student->id)->where('status', 'paid')->count();
        $unpaidCount = FeeInvoice::where('student_id', $student->id)->where('status', 'unpaid')->count();
        $paidRate    = $totalAmount > 0 ? round(($totalPaid / $totalAmount) * 100) : 0;

        return view('student_portal.fees', compact(
            'student',
            'fees',
            'totalAmount',
            'totalPaid',
            'totalDue',
            'paidCount',
            'unpaidCount',
            'paidRate',
        ));
    }

    // ── Transcript ───────────────────────────────────────────────
    public function transcript()
    {
        $student = $this->getStudent();

        // Group results by semester for clean transcript view
        $results = Result::with('course')
                         ->where('student_id', $student->id)
                         ->orderBy('session')
                         ->orderBy('semester')
                         ->get()
                         ->groupBy(fn($r) => $r->session . ' — Semester ' . $r->semester);

        $cgpa        = round(Result::where('student_id', $student->id)->avg('gpa') ?? 0, 2);
        $totalCourses= Result::where('student_id', $student->id)->count();
        $totalCredits= Result::with('course')
                             ->where('student_id', $student->id)
                             ->get()
                             ->sum(fn($r) => $r->course->credit_hours ?? 0);

        return view('student_portal.transcript', compact(
            'student',
            'results',
            'cgpa',
            'totalCourses',
            'totalCredits',
        ));
    }

    // ── Notices ──────────────────────────────────────────────────
    public function notices()
    {
        $notices = Notice::where('is_published', true)
                         ->whereIn('audience', ['all', 'students'])
                         ->latest()
                         ->paginate(10);

        return view('student_portal.notices', compact('notices'));
    }
}