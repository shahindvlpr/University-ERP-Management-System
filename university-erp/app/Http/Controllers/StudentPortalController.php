<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Result;
use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\FeeInvoice;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StudentPortalController extends Controller
{
    // ── Helper: logged-in student ────────────────────────────────
    private function getStudent()
    {
        $user = Auth::user();
        
        // Debug: দেখুন কে লগইন করছে
        \Log::info('Logged in user:', ['id' => $user->id, 'email' => $user->email]);
        
        // সঠিকভাবে স্টুডেন্ট খুঁজুন
        $student = Student::where('user_id', $user->id)->first();
        
        // Debug: দেখুন কোন স্টুডেন্ট পাওয়া গেছে
        \Log::info('Student found:', [
            'student_id' => $student ? $student->id : 'null',
            'student_name' => $student ? $student->name : 'null',
            'user_id' => $student ? $student->user_id : 'null'
        ]);
        
        // যদি স্টুডেন্ট না পাওয়া যায়, তাহলে error দেখান
        if (!$student) {
            abort(403, 'Student profile not found for this user. Please contact administrator.');
        }
        
        return $student;
    }

    // ── Dashboard ────────────────────────────────────────────────
    public function dashboard()
    {
        // Get the correct student for logged-in user
        $student = $this->getStudent();
        
        // Debug: নিশ্চিত করুন সঠিক স্টুডেন্ট এসেছে
        // dd([
        //     'logged_in_user' => Auth::user()->email,
        //     'student_found' => $student->name,
        //     'student_id' => $student->id,
        //     'student_user_id' => $student->user_id
        // ]);
        
        // Count courses for THIS student only
        $courseCount = Enrollment::where('student_id', $student->id)
                                 ->where('status', 'enrolled')
                                 ->count();

        // Attendance for THIS student only
        $totalAtt = Attendance::where('student_id', $student->id)->count();
        $presentAtt = Attendance::where('student_id', $student->id)
                                ->where('status', 'present')
                                ->count();
        $attendanceCount = $presentAtt;
        $attendanceRate = $totalAtt > 0 ? round(($presentAtt / $totalAtt) * 100) : 0;

        // Results for THIS student only
        $allResults = Result::with('course')
                            ->where('student_id', $student->id)
                            ->latest()
                            ->get();
        
        // Calculate CGPA
        $totalPoints = 0;
        $totalCredits = 0;
        foreach($allResults as $result) {
            $creditHours = $result->course->credit_hours ?? 3;
            $totalPoints += ($result->gpa ?? 0) * $creditHours;
            $totalCredits += $creditHours;
        }
        $cgpa = $totalCredits > 0 ? round($totalPoints / $totalCredits, 2) : 0;
        
        $resultCount = $allResults->count();
        $recentResults = $allResults->take(4);

        // Fees for THIS student only
        $feeDue = FeeInvoice::where('student_id', $student->id)
                            ->where('status', '!=', 'paid')
                            ->sum('due_amount');
        $feePaid = FeeInvoice::where('student_id', $student->id)
                             ->sum('paid_amount');
        
        // Completed courses for THIS student only
        $completedCoursesCount = Enrollment::where('student_id', $student->id)
                                           ->where('status', 'completed')
                                           ->count();

        // Notices
        $notices = Notice::where('is_published', true)
                         ->whereIn('audience', ['all', 'students'])
                         ->latest()
                         ->take(5)
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
            'completedCoursesCount'
        ));
    }
    
    // ── Other methods ──
    public function attendance()
    {
        $student = $this->getStudent();
        
        $attendances = Attendance::with('course')
                                 ->where('student_id', $student->id)
                                 ->latest()
                                 ->paginate(15);
        
        $total = Attendance::where('student_id', $student->id)->count();
        $present = Attendance::where('student_id', $student->id)
                             ->where('status', 'present')
                             ->count();
        $absent = Attendance::where('student_id', $student->id)
                            ->where('status', 'absent')
                            ->count();
        $late = Attendance::where('student_id', $student->id)
                          ->where('status', 'late')
                          ->count();
        $rate = $total > 0 ? round(($present / $total) * 100) : 0;
        
        return view('student_portal.attendance', compact(
            'student', 'attendances', 'total', 'present', 'absent', 'late', 'rate'
        ));
    }
    
    public function results()
    {
        $student = $this->getStudent();
        
        $results = Result::with('course')
                         ->where('student_id', $student->id)
                         ->latest()
                         ->paginate(15);
        
        $allResults = Result::where('student_id', $student->id)->get();
        
        $totalPoints = 0;
        $totalCredits = 0;
        foreach($allResults as $result) {
            $creditHours = $result->course->credit_hours ?? 3;
            $totalPoints += ($result->gpa ?? 0) * $creditHours;
            $totalCredits += $creditHours;
        }
        $cgpa = $totalCredits > 0 ? round($totalPoints / $totalCredits, 2) : 0;
        
        $highest = $allResults->max('marks') ?? 0;
        $lowest = $allResults->min('marks') ?? 0;
        $average = round($allResults->avg('marks') ?? 0, 1);
        
        return view('student_portal.results', compact(
            'student', 'results', 'cgpa', 'highest', 'lowest', 'average'
        ));
    }
    
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
        
        return view('student_portal.courses', compact('student', 'courses', 'totalCredits'));
    }
    
    public function fees()
    {
        $student = $this->getStudent();
        
        $fees = FeeInvoice::with('payments')
                          ->where('student_id', $student->id)
                          ->latest()
                          ->paginate(10);
        
        $totalAmount = FeeInvoice::where('student_id', $student->id)->sum('amount');
        $totalPaid = FeeInvoice::where('student_id', $student->id)->sum('paid_amount');
        $totalDue = FeeInvoice::where('student_id', $student->id)->sum('due_amount');
        $paidCount = FeeInvoice::where('student_id', $student->id)->where('status', 'paid')->count();
        $unpaidCount = FeeInvoice::where('student_id', $student->id)->where('status', '!=', 'paid')->count();
        $paidRate = $totalAmount > 0 ? round(($totalPaid / $totalAmount) * 100) : 0;
        
        return view('student_portal.fees', compact(
            'student', 'fees', 'totalAmount', 'totalPaid', 'totalDue',
            'paidCount', 'unpaidCount', 'paidRate'
        ));
    }
    
    public function transcript()
    {
        $student = $this->getStudent();
        
        $results = Result::with('course')
                         ->where('student_id', $student->id)
                         ->orderBy('created_at')
                         ->get()
                         ->groupBy(function($r) {
                             return $r->semester ? 'Semester ' . $r->semester : 'General';
                         });
        
        $allResults = Result::where('student_id', $student->id)->get();
        
        $totalPoints = 0;
        $totalCredits = 0;
        foreach($allResults as $result) {
            $creditHours = $result->course->credit_hours ?? 3;
            $totalPoints += ($result->gpa ?? 0) * $creditHours;
            $totalCredits += $creditHours;
        }
        $cgpa = $totalCredits > 0 ? round($totalPoints / $totalCredits, 2) : 0;
        
        $totalCourses = Result::where('student_id', $student->id)->count();
        
        return view('student_portal.transcript', compact(
            'student', 'results', 'cgpa', 'totalCourses', 'totalCredits'
        ));
    }
    
    public function notices()
    {
        $notices = Notice::where('is_published', true)
                         ->whereIn('audience', ['all', 'students'])
                         ->latest()
                         ->paginate(10);
        
        return view('student_portal.notices', compact('notices'));
    }
    
    public function routine()
    {
        $student = $this->getStudent();
        
        $enrolledCourses = Enrollment::where('student_id', $student->id)
                                     ->where('status', 'enrolled')
                                     ->pluck('course_id');
        
        $routines = \App\Models\Routine::with('course')
                                       ->whereIn('course_id', $enrolledCourses)
                                       ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
                                       ->orderBy('start_time')
                                       ->get()
                                       ->groupBy('day');
        
        return view('student_portal.routine', compact('routines', 'student'));
    }
    
    public function library()
    {
        $student = $this->getStudent();
        
        $borrowedBooks = $student->bookIssues()->where('status', 'borrowed')->get();
        
        return view('student_portal.library', compact('student', 'borrowedBooks'));
    }
    
    public function assignments()
    {
        $student = $this->getStudent();
        
        $enrolledCourses = Enrollment::where('student_id', $student->id)
                                     ->where('status', 'enrolled')
                                     ->pluck('course_id');
        
        $assignments = \App\Models\Assignment::with('course')
                                             ->whereIn('course_id', $enrolledCourses)
                                             ->where('due_date', '>=', now())
                                             ->orderBy('due_date')
                                             ->get();
        
        return view('student_portal.assignments', compact('student', 'assignments'));
    }
    
    public function settings()
    {
        $student = $this->getStudent();
        
        return view('student_portal.settings', compact('student'));
    }
}