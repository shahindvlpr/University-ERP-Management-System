<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Result;

class TranscriptController extends Controller
{
    public function index()
    {
        $students = Student::all();

        return view(
            'transcripts.index',
            compact('students')
        );
    }

    public function show(Student $student)
    {
        $results = Result::with('course')
                    ->where(
                        'student_id',
                        $student->id
                    )
                    ->get();

        $totalCredits = 0;

        $totalPoints = 0;

        foreach($results as $result)
        {
            $credit =
                $result->course->credit_hours;

            $totalCredits += $credit;

            $totalPoints +=
                ($credit * $result->gpa);
        }

        $cgpa = 0;

        if($totalCredits > 0)
        {
            $cgpa =
                round(
                    $totalPoints /
                    $totalCredits,
                    2
                );
        }

        return view(
            'transcripts.show',
            compact(
                'student',
                'results',
                'cgpa',
                'totalCredits'
            )
        );
    }
}