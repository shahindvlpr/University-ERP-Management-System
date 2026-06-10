<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $enrollments = Enrollment::with(['student','course'])

            ->when($request->search,function($query) use($request){

                $query->whereHas('student',function($q) use($request){

                    $q->where('name','like','%'.$request->search.'%')
                      ->orWhere('student_id','like','%'.$request->search.'%');

                });

            })

            ->latest()
            ->paginate(10);

        return view(
            'enrollments.index',
            compact('enrollments')
        );
    }

    public function create()
    {
        $students = Student::all();
        $courses = Course::all();

        return view(
            'enrollments.create',
            compact('students','courses')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'=>'required',
            'course_id'=>'required',
            'session'=>'required',
            'semester'=>'required',
        ]);

        Enrollment::create([
            'student_id'=>$request->student_id,
            'course_id'=>$request->course_id,
            'session'=>$request->session,
            'semester'=>$request->semester,
            'status'=>'enrolled',
        ]);

        return redirect()
            ->route('enrollments.index')
            ->with('success','Enrollment Added Successfully');
    }

    public function show(Enrollment $enrollment)
    {
        return view(
            'enrollments.show',
            compact('enrollment')
        );
    }

    public function edit(Enrollment $enrollment)
    {
        $students = Student::all();
        $courses = Course::all();

        return view(
            'enrollments.edit',
            compact(
                'enrollment',
                'students',
                'courses'
            )
        );
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'student_id'=>'required',
            'course_id'=>'required',
            'session'=>'required',
            'semester'=>'required',
            'status'=>'required'
        ]);

        $enrollment->update([
            'student_id'=>$request->student_id,
            'course_id'=>$request->course_id,
            'session'=>$request->session,
            'semester'=>$request->semester,
            'status'=>$request->status
        ]);

        return redirect()
            ->route('enrollments.index')
            ->with('success','Enrollment Updated Successfully');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()
            ->route('enrollments.index')
            ->with('success','Enrollment Deleted Successfully');
    }
}