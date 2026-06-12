<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentWelcomeMail;

class TeacherController extends Controller
{
    // In TeacherController@index
public function index(Request $request)
{
    $query = Teacher::with('department');
    
    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('teacher_id', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%");
        });
    }
    
    if ($request->status) {
        $query->where('status', $request->status);
    }
    
    if ($request->department) {
        $query->where('department_id', $request->department);
    }
    
    $teachers = $query->latest()->paginate(15);
    $departments = Department::all();
    
    return view('teachers.index', compact('teachers', 'departments'));
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
        'teacher_id' => 'required|unique:teachers',
        'name' => 'required',
        'email' => 'required|email|unique:teachers|unique:users,email',
        'phone' => 'nullable',
        'designation' => 'required',
        'specialization' => 'nullable',
        'joining_date' => 'nullable|date',
        'salary' => 'required|numeric',
        'photo' => 'nullable|image',
        'status' => 'required'
    ]);

    $photo = null;

    if ($request->hasFile('photo')) {
        $photo = $request->file('photo')
            ->store('teachers', 'public');
    }

    $tempPassword = 'Temp@12345';

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $tempPassword,
    ]);

    $user->assignRole('teacher');

    Teacher::create([
        'user_id' => $user->id,
        'department_id' => $request->department_id,
        'teacher_id' => $request->teacher_id,
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'designation' => $request->designation,
        'specialization' => $request->specialization,
        'joining_date' => $request->joining_date,
        'salary' => $request->salary,
        'photo' => $photo,
        'status' => $request->status,
    ]);

    return redirect()
        ->route('teachers.index')
        ->with(
            'success',
            'Teacher Added Successfully. Login Password: Temp@12345'
        );
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

