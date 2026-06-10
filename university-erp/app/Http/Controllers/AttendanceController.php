<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $attendances = Attendance::with(['student', 'course'])

            ->when($request->search, function ($query) use ($request) {

                $query->whereHas('student', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('student_id', 'like', '%' . $request->search . '%');
                });

            })

            ->latest()
            ->paginate(10);

        return view('attendance.index', compact('attendances'));
    }

    public function create()
    {
        $students = Student::where('status', 'active')
            ->orderBy('name')
            ->get();

        $courses = Course::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view(
            'attendance.create',
            compact('students', 'courses')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id',
            'date'       => 'required|date',
            'status'     => 'required|in:present,absent,late',
            'remarks'    => 'nullable|string|max:500',
        ]);

        $exists = Attendance::where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->where('date', $request->date)
            ->exists();

        if ($exists) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Attendance already exists for this student on this date.');

        }

        Attendance::create([
            'student_id' => $request->student_id,
            'course_id'  => $request->course_id,
            'date'       => $request->date,
            'status'     => $request->status,
            'remarks'    => $request->remarks,
        ]);

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance Added Successfully');
    }

    public function show(Attendance $attendance)
    {
        $attendance->load(['student', 'course']);

        return view(
            'attendance.show',
            compact('attendance')
        );
    }

    public function edit(Attendance $attendance)
    {
        $students = Student::orderBy('name')->get();

        $courses = Course::orderBy('name')->get();

        return view(
            'attendance.edit',
            compact(
                'attendance',
                'students',
                'courses'
            )
        );
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id',
            'date'       => 'required|date',
            'status'     => 'required|in:present,absent,late',
            'remarks'    => 'nullable|string|max:500',
        ]);

        $exists = Attendance::where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->where('date', $request->date)
            ->where('id', '!=', $attendance->id)
            ->exists();

        if ($exists) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Duplicate attendance record found.');

        }

        $attendance->update([
            'student_id' => $request->student_id,
            'course_id'  => $request->course_id,
            'date'       => $request->date,
            'status'     => $request->status,
            'remarks'    => $request->remarks,
        ]);

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance Updated Successfully');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance Deleted Successfully');
    }
}
