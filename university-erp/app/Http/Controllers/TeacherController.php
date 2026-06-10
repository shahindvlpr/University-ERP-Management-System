<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $teachers = Teacher::with('department')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('teacher_id', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('teachers.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required',
            'teacher_id'    => 'required|unique:teachers',
            'name'          => 'required',
            'email'         => 'required|email|unique:teachers',
            'phone'         => 'nullable',
            'designation'   => 'required',
            'specialization'=> 'nullable',
            'joining_date'  => 'nullable|date',
            'salary'        => 'required|numeric',
            'photo'         => 'nullable|image',
            'status'        => 'required'
        ]);

        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')
                ->store('teachers', 'public');
        }

        Teacher::create([
            'user_id'        => Auth::id(),
            'department_id'  => $request->department_id,
            'teacher_id'     => $request->teacher_id,
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'designation'    => $request->designation,
            'specialization' => $request->specialization,
            'joining_date'   => $request->joining_date,
            'salary'         => $request->salary,
            'photo'          => $photo,
            'status'         => $request->status,
        ]);

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Teacher Added Successfully');
    }
    public function show(Teacher $teacher)
{
    return view('teachers.show', compact('teacher'));
}

public function edit(Teacher $teacher)
{
    $departments = Department::all();

    return view(
        'teachers.edit',
        compact('teacher','departments')
    );
}

public function update(Request $request, Teacher $teacher)
{
    $teacher->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'designation' => $request->designation,
        'salary' => $request->salary,
        'status' => $request->status,
    ]);

    return redirect()
        ->route('teachers.index')
        ->with('success','Teacher Updated Successfully');
}

public function destroy(Teacher $teacher)
{
    $teacher->delete();

    return redirect()
        ->route('teachers.index')
        ->with('success','Teacher Deleted Successfully');
}
}

