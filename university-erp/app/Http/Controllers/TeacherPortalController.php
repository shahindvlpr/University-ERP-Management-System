<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Course;
use App\Models\Routine;
use App\Models\Attendance;
use App\Models\Result;
use App\Models\Enrollment;
use App\Models\Assignment;
use App\Models\Notice;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class TeacherPortalController extends Controller
{
    private function getTeacher(): Teacher
    {
        return Teacher::where('user_id', Auth::id())->firstOrFail();
    }

    public function dashboard()
    {
        $teacher = $this->getTeacher();
        
        // Get courses taught by this teacher
        $courses = Course::withCount(['enrollments', 'assignments'])
            ->where('teacher_id', $teacher->id)
            ->get();
        
        $courseCount = $courses->count();
        $routineCount = Routine::where('teacher_id', $teacher->id)->count();
        
        // Total students across all courses
        $studentCount = Enrollment::whereHas('course', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->count();
        
        // Today's classes count
        $todayClasses = Routine::where('teacher_id', $teacher->id)
            ->where('day', now()->format('l'))
            ->count();
        
        // Today's schedule details
        $todaySchedule = Routine::with('course')
            ->where('teacher_id', $teacher->id)
            ->where('day', now()->format('l'))
            ->orderBy('start_time')
            ->get();
        
        // Add enrolled students count for each schedule
        foreach ($todaySchedule as $schedule) {
            $schedule->enrolled_students = Enrollment::where('course_id', $schedule->course_id)->count();
        }
        
        // Pending assignments
        $pendingAssignments = Assignment::with('course')
            ->where('teacher_id', $teacher->id)
            ->where('status', 'pending')
            ->where('due_date', '>=', now())
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();
        
        // Recent notices - Fixed version
$recentNotices = Notice::where(function($query) use ($teacher) {
        // If notices table has created_by or posted_by column
        if (Schema::hasColumn('notices', 'created_by')) {
            $query->where('created_by', $teacher->user_id);
        }
        // Or if you have teacher_id column (add it if needed)
        elseif (Schema::hasColumn('notices', 'teacher_id')) {
            $query->where('teacher_id', $teacher->id);
        }
        // Or just get all notices for teachers
        $query->orWhere('audience', 'teachers')
              ->orWhere('audience', 'all');
    })
    ->latest()
    ->limit(5)
    ->get();
        
        // Calculate performance metrics
        $totalEnrollments = Enrollment::whereHas('course', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->count();
        
        $presentAttendance = Attendance::whereHas('course', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->where('status', 'present')->count();
        
        $totalAttendance = Attendance::whereHas('course', function($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->count();
        
        $avgAttendance = $totalAttendance > 0 ? round(($presentAttendance / $totalAttendance) * 100) : 0;
        
        // Calculate course completion progress
        $courseCompletion = 0;
        if ($courses->count() > 0) {
            $completedTopics = 0;
            $totalTopics = 0;
            // This would depend on your syllabus/topic structure
            $courseCompletion = 65; // Placeholder - calculate based on actual data
        }
        
        // Calculate graded assignments percentage
        $totalSubmissions = 0;
        $gradedSubmissions = 0;
        // This would need assignment submission data
        $gradedPercentage = 75; // Placeholder
        
        // Add progress to each course
        foreach ($courses as $course) {
            $course->attendance_rate = rand(65, 95); // Calculate from attendance table
            $course->progress = rand(40, 90); // Calculate from syllabus completion
            $course->assignment_count = $course->assignments_count ?? 0;
            $course->students_count = $course->enrollments_count ?? 0;
        }
        
        return view('teacher_portal.dashboard', compact(
            'teacher',
            'courseCount',
            'routineCount',
            'studentCount',
            'todayClasses',
            'courses',
            'todaySchedule',
            'pendingAssignments',
            'recentNotices',
            'avgAttendance',
            'gradedPercentage',
            'courseCompletion'
        ));
    }

    public function courses()
    {
        $teacher = $this->getTeacher();
        
        $courses = Course::withCount(['enrollments', 'assignments'])
            ->where('teacher_id', $teacher->id)
            ->paginate(10);
        
        // Calculate additional statistics for each course
        foreach ($courses as $course) {
            $course->total_students = Enrollment::where('course_id', $course->id)->count();
            $course->attendance_rate = $this->calculateCourseAttendance($course->id);
        }
        
        return view('teacher_portal.courses', compact('courses'));
    }
    
    public function courseDetails($id)
    {
        $teacher = $this->getTeacher();
        $course = Course::with(['enrollments.student', 'assignments'])
            ->where('teacher_id', $teacher->id)
            ->findOrFail($id);
        
        $enrolledStudents = Enrollment::with('student')
            ->where('course_id', $id)
            ->get();
        
        $attendance = Attendance::where('course_id', $id)
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();
        
        $results = Result::where('course_id', $id)->get();
        
        return view('teacher_portal.course_details', compact('course', 'enrolledStudents', 'attendance', 'results'));
    }

    public function students()
    {
        $teacher = $this->getTeacher();
        
        $students = Enrollment::with(['student', 'course'])
            ->whereHas('course', function($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->paginate(15);
        
        return view('teacher_portal.students', compact('students'));
    }
    
    public function studentDetails($id)
    {
        $student = Student::with(['user', 'department'])->findOrFail($id);
        $teacher = $this->getTeacher();
        
        // Get courses the student is taking with this teacher
        $enrollments = Enrollment::with('course')
            ->where('student_id', $id)
            ->whereHas('course', function($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->get();
        
        $attendance = Attendance::where('student_id', $id)
            ->whereHas('course', function($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->latest()
            ->limit(20)
            ->get();
        
        $results = Result::where('student_id', $id)
            ->whereHas('course', function($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->get();
        
        return view('teacher_portal.student_details', compact('student', 'enrollments', 'attendance', 'results'));
    }

    public function routine()
    {
        $teacher = $this->getTeacher();
        
        $routines = Routine::with('course')
            ->where('teacher_id', $teacher->id)
            ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('start_time')
            ->get();
        
        // Group by day
        $routinesByDay = $routines->groupBy('day');
        
        return view('teacher_portal.routine', compact('routinesByDay'));
    }
    
    public function createRoutine(Request $request)
    {
        $teacher = $this->getTeacher();
        
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'room' => 'nullable|string'
        ]);
        
        Routine::create([
            'teacher_id' => $teacher->id,
            'course_id' => $request->course_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'room' => $request->room
        ]);
        
        return redirect()->back()->with('success', 'Class schedule added successfully!');
    }

    public function attendance()
    {
        $teacher = $this->getTeacher();
        
        $courses = Course::where('teacher_id', $teacher->id)->get();
        
        return view('teacher_portal.attendance', compact('courses'));
    }
    
    public function markAttendance(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'students' => 'required|array',
            'students.*' => 'exists:students,id'
        ]);
        
        $course = Course::findOrFail($request->course_id);
        
        foreach ($request->students as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'course_id' => $course->id,
                    'student_id' => $studentId,
                    'date' => $request->date
                ],
                [
                    'status' => $status,
                    'teacher_id' => $course->teacher_id
                ]
            );
        }
        
        return redirect()->back()->with('success', 'Attendance marked successfully!');
    }
    
    public function getAttendanceData(Request $request)
    {
        $courseId = $request->course_id;
        $date = $request->date ?? now()->format('Y-m-d');
        
        $students = Enrollment::with('student')
            ->where('course_id', $courseId)
            ->get();
        
        $attendances = Attendance::where('course_id', $courseId)
            ->where('date', $date)
            ->get()
            ->keyBy('student_id');
        
        return response()->json([
            'students' => $students,
            'attendances' => $attendances
        ]);
    }

    public function results()
    {
        $teacher = $this->getTeacher();
        
        $courses = Course::where('teacher_id', $teacher->id)->get();
        
        return view('teacher_portal.results', compact('courses'));
    }
    
    public function uploadResults(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'exam_name' => 'required|string',
            'results' => 'required|array',
            'results.*.student_id' => 'exists:students,id',
            'results.*.marks' => 'numeric|min:0|max:100',
            'results.*.grade' => 'nullable|string'
        ]);
        
        foreach ($request->results as $resultData) {
            $gpa = $this->calculateGPA($resultData['marks']);
            $grade = $resultData['grade'] ?? $this->calculateGrade($resultData['marks']);
            
            Result::updateOrCreate(
                [
                    'course_id' => $request->course_id,
                    'student_id' => $resultData['student_id'],
                    'exam_name' => $request->exam_name
                ],
                [
                    'marks' => $resultData['marks'],
                    'grade' => $grade,
                    'gpa' => $gpa,
                    'teacher_id' => auth()->user()->teacher->id
                ]
            );
        }
        
        return redirect()->back()->with('success', 'Results uploaded successfully!');
    }
    
    private function calculateGPA($marks)
    {
        if ($marks >= 80) return 4.00;
        if ($marks >= 75) return 3.75;
        if ($marks >= 70) return 3.50;
        if ($marks >= 65) return 3.25;
        if ($marks >= 60) return 3.00;
        if ($marks >= 55) return 2.75;
        if ($marks >= 50) return 2.50;
        if ($marks >= 45) return 2.25;
        if ($marks >= 40) return 2.00;
        return 0.00;
    }
    
    private function calculateGrade($marks)
    {
        if ($marks >= 80) return 'A+';
        if ($marks >= 75) return 'A';
        if ($marks >= 70) return 'A-';
        if ($marks >= 65) return 'B+';
        if ($marks >= 60) return 'B';
        if ($marks >= 55) return 'B-';
        if ($marks >= 50) return 'C+';
        if ($marks >= 45) return 'C';
        if ($marks >= 40) return 'D';
        return 'F';
    }
    
    private function calculateCourseAttendance($courseId)
    {
        $totalClasses = Attendance::where('course_id', $courseId)->distinct('date')->count('date');
        $presentCount = Attendance::where('course_id', $courseId)
            ->where('status', 'present')
            ->count();
        
        return $totalClasses > 0 ? round(($presentCount / $totalClasses) * 100) : 0;
    }

    public function profile()
    {
        $teacher = $this->getTeacher();
        
        return view('teacher_portal.profile', compact('teacher'));
    }
    
    public function updateProfile(Request $request)
    {
        $teacher = $this->getTeacher();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('teachers', 'public');
            $teacher->photo = $photoPath;
        }
        
        $teacher->name = $request->name;
        $teacher->phone = $request->phone;
        $teacher->address = $request->address;
        $teacher->bio = $request->bio;
        $teacher->save();
        
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}