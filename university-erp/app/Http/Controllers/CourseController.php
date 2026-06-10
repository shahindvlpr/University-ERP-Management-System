<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::with(['department','teacher'])
            ->when($request->search, function ($query) use ($request) {
                $query->where('name','like','%'.$request->search.'%')
                      ->orWhere('code','like','%'.$request->search.'%');
            })
            ->latest()
            ->paginate(10);

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $departments = Department::all();
        $teachers = Teacher::all();

        return view(
            'courses.create',
            compact('departments','teachers')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required',
            'teacher_id' => 'required',
            'name' => 'required',
            'code' => 'required|unique:courses',
            'credit_hours' => 'required|numeric',
            'semester' => 'required|numeric',
            'status' => 'required'
        ]);

        Course::create($request->all());

        return redirect()
            ->route('courses.index')
            ->with('success','Course Added Successfully');
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $departments = Department::all();
        $teachers = Teacher::all();

        return view(
            'courses.edit',
            compact('course','departments','teachers')
        );
    }

    public function update(Request $request, Course $course)
{
    $course->update([
        'department_id' => $request->department_id,
        'teacher_id' => $request->teacher_id,
        'name' => $request->name,
        'code' => $request->code,
        'description' => $request->description,
        'credit_hours' => $request->credit_hours,
        'semester' => $request->semester,
        'status' => $request->status,
    ]);

    return redirect()
        ->route('courses.index')
        ->with('success','Course Updated Successfully');
}

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with('success','Course Deleted Successfully');
    }
}