<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $results = Result::with(['student','course'])

            ->when($request->search, function ($query) use ($request) {

                $query->whereHas('student', function ($q) use ($request) {

                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('student_id', 'like', '%' . $request->search . '%');

                });

            })

            ->latest()
            ->paginate(10);

        return view('results.index', compact('results'));
    }

    public function create()
    {
        $students = Student::where('status','active')->get();
        $courses = Course::where('status','active')->get();

        return view(
            'results.create',
            compact('students','courses')
        );
    }

    private function calculateGrade($marks)
    {
        if ($marks >= 80) return ['A+', 4.00];
        if ($marks >= 75) return ['A', 3.75];
        if ($marks >= 70) return ['A-', 3.50];
        if ($marks >= 65) return ['B+', 3.25];
        if ($marks >= 60) return ['B', 3.00];
        if ($marks >= 55) return ['B-', 2.75];
        if ($marks >= 50) return ['C+', 2.50];
        if ($marks >= 45) return ['C', 2.25];
        if ($marks >= 40) return ['D', 2.00];

        return ['F', 0.00];
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'course_id' => 'required',
            'midterm_marks' => 'required|numeric',
            'final_marks' => 'required|numeric',
            'assignment_marks' => 'required|numeric',
            'session' => 'required',
            'semester' => 'required'
        ]);

        $total =
            $request->midterm_marks +
            $request->final_marks +
            $request->assignment_marks;

        [$grade, $gpa] = $this->calculateGrade($total);

        Result::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'midterm_marks' => $request->midterm_marks,
            'final_marks' => $request->final_marks,
            'assignment_marks' => $request->assignment_marks,
            'total_marks' => $total,
            'grade' => $grade,
            'gpa' => $gpa,
            'session' => $request->session,
            'semester' => $request->semester,
        ]);

        return redirect()
            ->route('results.index')
            ->with('success','Result Added Successfully');
    }

    public function show(Result $result)
    {
        return view('results.show', compact('result'));
    }

    public function edit(Result $result)
    {
        $students = Student::all();
        $courses = Course::all();

        return view(
            'results.edit',
            compact(
                'result',
                'students',
                'courses'
            )
        );
    }

    public function update(Request $request, Result $result)
        {
        $request->validate([
        'student_id' => 'required|exists:students,id',
        'course_id' => 'required|exists:courses,id',
        'midterm_marks' => 'required|numeric|min:0|max:30',
        'final_marks' => 'required|numeric|min:0|max:50',
        'assignment_marks' => 'required|numeric|min:0|max:20',
        'session' => 'required',
        'semester' => 'required'
        ]);


        $total =
            $request->midterm_marks +
            $request->final_marks +
            $request->assignment_marks;

        [$grade, $gpa] = $this->calculateGrade($total);

        $result->update([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'midterm_marks' => $request->midterm_marks,
            'final_marks' => $request->final_marks,
            'assignment_marks' => $request->assignment_marks,
            'total_marks' => $total,
            'grade' => $grade,
            'gpa' => $gpa,
            'session' => $request->session,
            'semester' => $request->semester,
        ]);

        return redirect()
            ->route('results.index')
            ->with('success', 'Result Updated Successfully');


        }

    public function destroy(Result $result)
    {
        $result->delete();

        return redirect()
            ->route('results.index')
            ->with('success','Result Deleted Successfully');
    }
}