<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Course;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $exams = Exam::with('course')

            ->when($request->search, function($query) use ($request){

                $query->where('title','like','%'.$request->search.'%')

                      ->orWhere('exam_type','like','%'.$request->search.'%');

            })

            ->latest()
            ->paginate(10);

        return view('exams.index', compact('exams'));
    }

    public function create()
    {
        $courses = Course::all();

        return view(
            'exams.create',
            compact('courses')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'course_id'   => 'required',
            'title'       => 'required',
            'exam_type'   => 'required',
            'exam_date'   => 'required',
            'total_marks' => 'required|numeric',
            'session'     => 'required',
            'semester'    => 'required',

        ]);

        Exam::create([

            'course_id'   => $request->course_id,
            'title'       => $request->title,
            'exam_type'   => $request->exam_type,
            'exam_date'   => $request->exam_date,
            'total_marks' => $request->total_marks,
            'session'     => $request->session,
            'semester'    => $request->semester,
            'status'      => 'upcoming'

        ]);

        return redirect()
            ->route('exams.index')
            ->with(
                'success',
                'Exam Created Successfully'
            );
    }

    public function show(Exam $exam)
    {
        return view(
            'exams.show',
            compact('exam')
        );
    }

    public function edit(Exam $exam)
    {
        $courses = Course::all();

        return view(
            'exams.edit',
            compact(
                'exam',
                'courses'
            )
        );
    }

    public function update(Request $request,
                           Exam $exam)
    {
        $request->validate([

            'course_id'   => 'required',
            'title'       => 'required',
            'exam_type'   => 'required',
            'exam_date'   => 'required',
            'total_marks' => 'required|numeric',
            'session'     => 'required',
            'semester'    => 'required',

        ]);

        $exam->update([

            'course_id'   => $request->course_id,
            'title'       => $request->title,
            'exam_type'   => $request->exam_type,
            'exam_date'   => $request->exam_date,
            'total_marks' => $request->total_marks,
            'session'     => $request->session,
            'semester'    => $request->semester,
            'status'      => $request->status

        ]);

        return redirect()
            ->route('exams.index')
            ->with(
                'success',
                'Exam Updated Successfully'
            );
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()
            ->route('exams.index')
            ->with(
                'success',
                'Exam Deleted Successfully'
            );
    }
}