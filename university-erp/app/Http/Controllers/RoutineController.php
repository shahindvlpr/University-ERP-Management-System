<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
    public function index(Request $request)
    {
        $routines = Routine::with(['course','teacher'])

            ->when($request->search, function ($query) use ($request) {

                $query->whereHas('course', function ($q) use ($request) {

                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('code', 'like', '%' . $request->search . '%');

                });

            })

            ->latest()
            ->paginate(10);

        return view(
            'routines.index',
            compact('routines')
        );
    }

    public function create()
    {
        $courses = Course::where('status','active')->get();

        $teachers = Teacher::where('status','active')->get();

        return view(
            'routines.create',
            compact(
                'courses',
                'teachers'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'course_id'  => 'required',
            'teacher_id' => 'required',
            'day'        => 'required',
            'start_time' => 'required',
            'end_time'   => 'required',
            'room_no'    => 'required',

        ]);

        Routine::create([

            'course_id'  => $request->course_id,
            'teacher_id' => $request->teacher_id,
            'day'        => $request->day,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'room_no'    => $request->room_no,
            'status'     => $request->status ?? 'active',

        ]);

        return redirect()
            ->route('routines.index')
            ->with(
                'success',
                'Routine Added Successfully'
            );
    }

    public function show(Routine $routine)
    {
        return view(
            'routines.show',
            compact('routine')
        );
    }

    public function edit(Routine $routine)
    {
        $courses = Course::all();

        $teachers = Teacher::all();

        return view(
            'routines.edit',
            compact(
                'routine',
                'courses',
                'teachers'
            )
        );
    }

    public function update(
        Request $request,
        Routine $routine
    )
    {
        $request->validate([

            'course_id'  => 'required',
            'teacher_id' => 'required',
            'day'        => 'required',
            'start_time' => 'required',
            'end_time'   => 'required',
            'room_no'    => 'required',

        ]);

        $routine->update([

            'course_id'  => $request->course_id,
            'teacher_id' => $request->teacher_id,
            'day'        => $request->day,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'room_no'    => $request->room_no,
            'status'     => $request->status,

        ]);

        return redirect()
            ->route('routines.index')
            ->with(
                'success',
                'Routine Updated Successfully'
            );
    }

    public function destroy(Routine $routine)
    {
        $routine->delete();

        return redirect()
            ->route('routines.index')
            ->with(
                'success',
                'Routine Deleted Successfully'
            );
    }
}