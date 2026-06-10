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
        $attendances = Attendance::with(['student','course'])
            ->latest()
            ->paginate(10);

        return view('attendance.index', compact('attendances'));
    }

    public function create()
    {
        $students = Student::where('status','active')->get();
        $courses = Course::where('status','active')->get();

        return view(
            'attendance.create',
            compact('students','courses')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'course_id'  => 'required',
            'date'       => 'required|date',
            'status'     => 'required'
        ]);

        Attendance::create([
            'student_id' => $request->student_id,
            'course_id'  => $request->course_id,
            'date'       => $request->date,
            'status'     => $request->status,
            'remarks'    => $request->remarks
        ]);

        return redirect()
            ->route('attendance.index')
            ->with('success','Attendance Added Successfully');
    }

    public function show(Attendance $attendance)
    {
        return view('attendance.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $students = Student::all();
        $courses  = Course::all();

        return view(
            'attendance.edit',
            compact('attendance','students','courses')
        );
    }

    public function update(Request $request, Attendance $attendance)
    {
        $attendance->update([
            'student_id' => $request->student_id,
            'course_id'  => $request->course_id,
            'date'       => $request->date,
            'status'     => $request->status,
            'remarks'    => $request->remarks,
        ]);

        return redirect()
            ->route('attendance.index')
            ->with('success','Attendance Updated Successfully');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()
            ->route('attendance.index')
            ->with('success','Attendance Deleted Successfully');
    }
}