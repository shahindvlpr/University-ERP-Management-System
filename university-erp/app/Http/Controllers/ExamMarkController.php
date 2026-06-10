<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Student;
use App\Models\ExamMark;
use Illuminate\Http\Request;

class ExamMarkController extends Controller
{
    public function index()
    {
        $marks = ExamMark::with([
            'exam',
            'student'
        ])
        ->latest()
        ->paginate(10);

        return view(
            'exam_marks.index',
            compact('marks')
        );
    }

    public function create()
    {
        $exams = Exam::all();

        $students = Student::all();

        return view(
            'exam_marks.create',
            compact(
                'exams',
                'students'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'exam_id'    => 'required',
            'student_id' => 'required',
            'marks'      => 'required|numeric'

        ]);

        ExamMark::create([

            'exam_id'    => $request->exam_id,
            'student_id' => $request->student_id,
            'marks'      => $request->marks,
            'remarks'    => $request->remarks

        ]);

        return redirect()
            ->route('exam-marks.index')
            ->with(
                'success',
                'Marks Added Successfully'
            );
    }

    public function show(ExamMark $examMark)
    {
        return view(
            'exam_marks.show',
            compact('examMark')
        );
    }

    public function edit(ExamMark $examMark)
    {
        $exams = Exam::all();

        $students = Student::all();

        return view(
            'exam_marks.edit',
            compact(
                'examMark',
                'exams',
                'students'
            )
        );
    }

    public function update(
        Request $request,
        ExamMark $examMark
    )
    {
        $request->validate([

            'exam_id'    => 'required',
            'student_id' => 'required',
            'marks'      => 'required|numeric'

        ]);

        $examMark->update([

            'exam_id'    => $request->exam_id,
            'student_id' => $request->student_id,
            'marks'      => $request->marks,
            'remarks'    => $request->remarks

        ]);

        return redirect()
            ->route('exam-marks.index')
            ->with(
                'success',
                'Marks Updated Successfully'
            );
    }

    public function destroy(
        ExamMark $examMark
    )
    {
        $examMark->delete();

        return redirect()
            ->route('exam-marks.index')
            ->with(
                'success',
                'Marks Deleted Successfully'
            );
    }
}