<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
{
    $students = Student::with('department')
        ->when($request->search,function($query) use($request){

            $query->where('name','like',
                '%'.$request->search.'%')

                ->orWhere('student_id','like',
                '%'.$request->search.'%');

        })
        ->paginate(10);

    return view('students.index',
        compact('students'));
}

    public function create()
    {
        $departments = Department::all();

        return view('students.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|unique:students',
            'name' => 'required|min:3',
            'email' => 'required|email|unique:students',
            'department_id' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')
                ->store('students', 'public');
        }

        Student::create([
        'user_id' => Auth::id(),

        'department_id' => $request->department_id,
        'student_id' => $request->student_id,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'session' => $request->session,
        'semester' => $request->semester,
        'photo' => $photo,
        'status' => 'active'
    ]);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student Added Successfully');
    }

    public function edit(Student $student)
    {
        $departments = Department::all();

        return view('students.edit',
            compact('student', 'departments'));
    }

    public function update(Request $request, Student $student)
    {
        $photo = $student->photo;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')
                ->store('students', 'public');
        }

        $student->update([
            'department_id' => $request->department_id,
            'student_id' => $request->student_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'session' => $request->session,
            'semester' => $request->semester,
            'photo' => $photo
        ]);

        return redirect()->route('students.index');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index');
    }
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }
}