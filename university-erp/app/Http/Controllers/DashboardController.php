<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\FeeInvoice;
use App\Models\Notice;
use App\Models\Attendance;
use App\Models\Result;
use App\Models\Enrollment;
use App\Models\Book;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Core Stats ──────────────────────────────────────────
        $stats = [
            'students'         => Student::where('status', 'active')->count(),
            'teachers'         => Teacher::where('status', 'active')->count(),
            'courses'          => Course::where('status', 'active')->count(),
            'enrollments'      => Enrollment::where('status', 'enrolled')->count(),
            'results'          => Result::count(),
            'books'            => Book::count(),

            // Fee summary
            'fee_due'          => FeeInvoice::where('status', '!=', 'paid')->sum('due_amount'),
            'fee_paid'         => FeeInvoice::where('status', 'paid')->sum('paid_amount'),
            'fee_unpaid_count' => FeeInvoice::where('status', 'unpaid')->count(),

            // Today's attendance
            'today_present'    => Attendance::whereDate('date', today())->where('status', 'present')->count(),
            'today_absent'     => Attendance::whereDate('date', today())->where('status', 'absent')->count(),
            'today_late'       => Attendance::whereDate('date', today())->where('status', 'late')->count(),

            // Student status breakdown
            'students_active'    => Student::where('status', 'active')->count(),
            'students_inactive'  => Student::where('status', 'inactive')->count(),
            'students_graduated' => Student::where('status', 'graduated')->count(),
        ];

        // ── Attendance rate (today) ──────────────────────────────
        $totalToday = $stats['today_present'] + $stats['today_absent'] + $stats['today_late'];
        $stats['attendance_rate'] = $totalToday > 0
            ? round(($stats['today_present'] / $totalToday) * 100)
            : 0;

        // ── Grade distribution ───────────────────────────────────
        $totalResults = $stats['results'] ?: 1; // avoid division by zero
        $stats['grade_dist'] = [
            'A+' => round(Result::where('grade', 'A+')->count() / $totalResults * 100),
            'A'  => round(Result::where('grade', 'A')->count()  / $totalResults * 100),
            'B+' => round(Result::where('grade', 'B+')->count() / $totalResults * 100),
            'B'  => round(Result::where('grade', 'B')->count()  / $totalResults * 100),
        ];

        // ── Recent data ──────────────────────────────────────────
        $recent_notices = Notice::where('is_published', true)
                                ->latest()
                                ->take(4)
                                ->get();

        $recent_results = Result::with(['student', 'course'])
                                ->latest()
                                ->take(5)
                                ->get();

        // ── Monthly enrollment trend (last 6 months) ─────────────
        $enrollment_trend = Enrollment::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                                      ->where('created_at', '>=', now()->subMonths(6))
                                      ->groupBy('month')
                                      ->orderBy('month')
                                      ->pluck('total', 'month')
                                      ->toArray();

        return view('dashboard', compact(
            'stats',
            'recent_notices',
            'recent_results',
            'enrollment_trend',
        ));
    }
}