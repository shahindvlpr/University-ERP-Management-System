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

public function notices()
{
    $teacher = $this->getTeacher();
    
    // Use user_id instead of teacher_id
    $notices = Notice::where(function($query) use ($teacher) {
            $query->where('user_id', $teacher->user_id)  // Changed from teacher_id to user_id
                  ->orWhere('audience', 'teachers')
                  ->orWhere('audience', 'all');
        })
        ->latest()
        ->paginate(10);
    
    return view('teacher_portal.notices', compact('notices', 'teacher'));
}

public function createNotice(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'audience' => 'required|in:all,students,teachers',
        'category' => 'nullable|string|in:general,exam,event,holiday',
        'expire_date' => 'nullable|date'
    ]);
    
    $teacher = $this->getTeacher();
    
    Notice::create([
        'user_id' => $teacher->user_id,  // Use user_id
        'title' => $request->title,
        'content' => $request->content,
        'audience' => $request->audience,
        'category' => $request->category ?? 'general',
        'is_published' => true,
        'publish_date' => now(),
        'expire_date' => $request->expire_date
    ]);
    
    return redirect()->back()->with('success', 'Notice published successfully!');
}





public function courses()
{
    $teacher = $this->getTeacher();
    
    $courses = Course::withCount(['enrollments', 'assignments'])
        ->where('teacher_id', $teacher->id)
        ->paginate(12);
    
    // Calculate additional stats for each course
    foreach ($courses as $course) {
        // Calculate attendance rate
        $totalClasses = Attendance::where('course_id', $course->id)->distinct('date')->count('date');
        $presentCount = Attendance::where('course_id', $course->id)->where('status', 'present')->count();
        $totalStudents = Enrollment::where('course_id', $course->id)->count();
        
        $course->attendance_rate = ($totalClasses > 0 && $totalStudents > 0) 
            ? round(($presentCount / ($totalClasses * $totalStudents)) * 100) 
            : 0;
        
        $course->progress = rand(40, 90); // You can calculate this based on syllabus completion
        $course->total_students = $course->enrollments_count ?? 0;
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
    
    // Group routines by day
    $routinesByDay = $routines->groupBy('day');
    
    // Get courses for the add form
    $courses = Course::where('teacher_id', $teacher->id)->get();
    
    return view('teacher_portal.routine', compact('routinesByDay', 'courses'));
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
        'room_no' => $request->room ?? 'TBD',
        'room' => $request->room ?? 'TBD' 
    ]);
    
    return redirect()->back()->with('success', 'Class schedule added successfully!');
}

public function attendance(Request $request)
{
    $teacher = $this->getTeacher();
    
    // Get all courses taught by this teacher
    $courses = Course::withCount('enrollments')
        ->where('teacher_id', $teacher->id)
        ->get();
    
    $selectedCourse = null;
    $students = collect();
    $attendances = collect();
    $selectedDate = $request->date ?? date('Y-m-d');
    $viewMode = $request->view_mode ?? 'mark';
    
    // Initialize variables with default values
    $totalClasses = 0;
    $totalStudents = 0;
    $overallAttendanceRate = 0;
    
    if ($request->course_id) {
        $selectedCourse = Course::find($request->course_id);
        
        if ($selectedCourse) {
            // Get all students enrolled in this course
            $students = Enrollment::with('student')
                ->where('course_id', $request->course_id)
                ->where('status', 'enrolled')
                ->get();
            
            $totalStudents = $students->count();
            
            // Get existing attendance for this date
            $attendances = Attendance::where('course_id', $request->course_id)
                ->where('date', $selectedDate)
                ->get()
                ->keyBy('student_id');
            
            // Calculate statistics for view mode
            $totalClasses = Attendance::where('course_id', $request->course_id)
                ->distinct('date')
                ->count('date');
            
            $totalPresent = Attendance::where('course_id', $request->course_id)
                ->where('status', 'present')
                ->count();
            
            $totalAttendanceRecords = Attendance::where('course_id', $request->course_id)->count();
            $overallAttendanceRate = $totalAttendanceRecords > 0 
                ? round(($totalPresent / $totalAttendanceRecords) * 100) 
                : 0;
        }
    }
    
    return view('teacher_portal.attendance', compact(
        'courses', 
        'selectedCourse', 
        'students', 
        'attendances', 
        'selectedDate',
        'viewMode',
        'totalClasses',
        'totalStudents',
        'overallAttendanceRate'
    ));
}
public function markAttendance(Request $request)
{
    $request->validate([
        'course_id' => 'required|exists:courses,id',
        'date' => 'required|date',
        'attendance' => 'required|array'
    ]);
    
    $teacher = $this->getTeacher();
    
    foreach ($request->attendance as $studentId => $status) {
        if ($status && $status != '') {
            Attendance::updateOrCreate(
                [
                    'course_id' => $request->course_id,
                    'student_id' => $studentId,
                    'date' => $request->date
                ],
                [
                    'status' => $status,
                    'teacher_id' => $teacher->id
                ]
            );
        }
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

public function results(Request $request)
{
    $teacher = $this->getTeacher();
    
    // Get all courses taught by this teacher
    $courses = Course::withCount('enrollments')
        ->where('teacher_id', $teacher->id)
        ->get();
    
    $selectedCourse = null;
    $students = collect();
    $existingResults = collect();
    $viewMode = $request->view_mode ?? 'upload';
    $examType = $request->exam_type ?? 'midterm';
    $session = $request->session ?? date('Y');
    $semester = $request->semester ?? 1;
    $totalMarks = $request->total_marks ?? 100;
    
    // Initialize variables
    $resultsPublished = 0;
    $averageMarks = 0;
    $passRate = 0;
    $totalStudents = 0;
    
    if ($request->course_id) {
        $selectedCourse = Course::find($request->course_id);
        
        if ($selectedCourse) {
            // Get all students enrolled in this course
            $students = Enrollment::with('student')
                ->where('course_id', $request->course_id)
                ->where('status', 'enrolled')
                ->get();
            
            $totalStudents = $students->count();
            
            // Get existing results for this course, session, semester
            $existingResults = Result::where('course_id', $request->course_id)
                ->where('session', $session)
                ->where('semester', $semester)
                ->get()
                ->keyBy('student_id');
            
            // Calculate statistics for view mode
            if ($viewMode == 'view') {
                $resultsPublished = $existingResults->count();
                
                // Calculate average based on exam type
                if ($examType == 'midterm') {
                    $averageMarks = $existingResults->avg('midterm_marks') ?? 0;
                    $passedCount = $existingResults->filter(function($result) {
                        return $result->midterm_marks >= 40;
                    })->count();
                } elseif ($examType == 'final') {
                    $averageMarks = $existingResults->avg('final_marks') ?? 0;
                    $passedCount = $existingResults->filter(function($result) {
                        return $result->final_marks >= 40;
                    })->count();
                } else {
                    $averageMarks = $existingResults->avg('assignment_marks') ?? 0;
                    $passedCount = $existingResults->filter(function($result) {
                        return $result->assignment_marks >= 40;
                    })->count();
                }
                
                $passRate = $resultsPublished > 0 ? round(($passedCount / $resultsPublished) * 100) : 0;
            }
        }
    }
    
    return view('teacher_portal.results', compact(
        'courses',
        'selectedCourse',
        'students',
        'existingResults',
        'viewMode',
        'examType',
        'session',
        'semester',
        'totalMarks',
        'resultsPublished',
        'averageMarks',
        'passRate',
        'totalStudents'
    ));
}

public function uploadResults(Request $request)
{
    $request->validate([
        'course_id' => 'required|exists:courses,id',
        'exam_type' => 'required|in:midterm,final,assignment',
        'session' => 'required|digits:4',
        'semester' => 'required|integer|min:1|max:8',
        'total_marks' => 'required|integer|min:1',
        'results' => 'required|array'
    ]);
    
    $teacher = $this->getTeacher();
    
    foreach ($request->results as $studentId => $data) {
        if (isset($data['marks']) && $data['marks'] !== '') {
            $marks = floatval($data['marks']);
            $gpa = $data['gpa'] ?? $this->calculateGPA($marks, $request->total_marks);
            $grade = $data['grade'] ?? $this->calculateGrade($marks, $request->total_marks);
            
            // Check if result exists with all conditions
            $result = Result::where('student_id', $studentId)
                ->where('course_id', $request->course_id)
                ->where('session', $request->session)
                ->where('semester', $request->semester)
                ->first();
            
            // If not exists, create new instance
            if (!$result) {
                $result = new Result();
                $result->student_id = $studentId;
                $result->course_id = $request->course_id;
                $result->session = $request->session;
                $result->semester = $request->semester;
            }
            
            // Update the appropriate marks column based on exam type
            if ($request->exam_type == 'midterm') {
                $result->midterm_marks = $marks;
            } elseif ($request->exam_type == 'final') {
                $result->final_marks = $marks;
            } else {
                $result->assignment_marks = $marks;
            }
            
            // Calculate total marks (sum of all three)
            $midterm = $result->midterm_marks ?? 0;
            $final = $result->final_marks ?? 0;
            $assignment = $result->assignment_marks ?? 0;
            $result->total_marks = $midterm + $final + $assignment;
            
            // Calculate overall grade and GPA based on total marks
            // Total possible marks = total_marks from request (per exam type)
            // But for overall, we need to consider all three exams
            $totalPossibleMarks = $request->total_marks * 3; // 3 exams
            $result->grade = $this->calculateGrade($result->total_marks, $totalPossibleMarks);
            $result->gpa = $this->calculateGPA($result->total_marks, $totalPossibleMarks);
            
            $result->save();
        }
    }
    
    return redirect()->back()->with('success', ucfirst($request->exam_type) . ' marks uploaded successfully!');
}

private function calculateGPA($marks, $totalMarks)
{
    if ($totalMarks <= 0) return 0.00;
    
    $percentage = ($marks / $totalMarks) * 100;
    
    if ($percentage >= 80) return 4.00;
    if ($percentage >= 75) return 3.75;
    if ($percentage >= 70) return 3.50;
    if ($percentage >= 65) return 3.25;
    if ($percentage >= 60) return 3.00;
    if ($percentage >= 55) return 2.75;
    if ($percentage >= 50) return 2.50;
    if ($percentage >= 45) return 2.25;
    if ($percentage >= 40) return 2.00;
    return 0.00;
}

private function calculateGrade($marks, $totalMarks)
{
    if ($totalMarks <= 0) return 'F';
    
    $percentage = ($marks / $totalMarks) * 100;
    
    if ($percentage >= 80) return 'A+';
    if ($percentage >= 75) return 'A';
    if ($percentage >= 70) return 'A-';
    if ($percentage >= 65) return 'B+';
    if ($percentage >= 60) return 'B';
    if ($percentage >= 55) return 'B-';
    if ($percentage >= 50) return 'C+';
    if ($percentage >= 45) return 'C';
    if ($percentage >= 40) return 'D';
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
    
    // Get statistics
    $totalCourses = Course::where('teacher_id', $teacher->id)->count();
    $totalStudents = Enrollment::whereHas('course', function($q) use ($teacher) {
        $q->where('teacher_id', $teacher->id);
    })->count();
    $totalClasses = Routine::where('teacher_id', $teacher->id)->count();
    $todayClasses = Routine::where('teacher_id', $teacher->id)
        ->where('day', now()->format('l'))
        ->count();
    
    return view('teacher_portal.profile', compact(
        'teacher', 'totalCourses', 'totalStudents', 'totalClasses', 'todayClasses'
    ));
}

public function updateProfile(Request $request)
{
    $teacher = $this->getTeacher();
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:teachers,email,' . $teacher->id,
        'phone' => 'nullable|string|max:20',
        'designation' => 'nullable|string|max:255',
        'dob' => 'nullable|date',
        'gender' => 'nullable|in:male,female,other',
        'qualification' => 'nullable|string',
        'address' => 'nullable|string',
        'bio' => 'nullable|string',
        'blood_group' => 'nullable|string|max:5',
        'emergency_contact' => 'nullable|string|max:20',
        'national_id' => 'nullable|string|max:50',
        'website' => 'nullable|url',
        'linkedin' => 'nullable|url',
        'facebook' => 'nullable|url',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);
    
    if ($request->hasFile('photo')) {
        if ($teacher->photo && file_exists(storage_path('app/public/' . $teacher->photo))) {
            unlink(storage_path('app/public/' . $teacher->photo));
        }
        $photoPath = $request->file('photo')->store('teachers', 'public');
        $teacher->photo = $photoPath;
    }
    
    $teacher->name = $request->name;
    $teacher->email = $request->email;
    $teacher->phone = $request->phone;
    $teacher->designation = $request->designation;
    $teacher->dob = $request->dob;
    $teacher->gender = $request->gender;
    $teacher->qualification = $request->qualification;
    $teacher->address = $request->address;
    $teacher->bio = $request->bio;
    $teacher->blood_group = $request->blood_group;
    $teacher->emergency_contact = $request->emergency_contact;
    $teacher->national_id = $request->national_id;
    $teacher->website = $request->website;
    $teacher->linkedin = $request->linkedin;
    $teacher->facebook = $request->facebook;
    
    $teacher->save();
    
    return redirect()->route('teacher.profile')->with('success', 'Profile updated successfully!');
}
}