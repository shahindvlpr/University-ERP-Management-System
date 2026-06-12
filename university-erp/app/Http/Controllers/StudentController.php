<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentWelcomeMail;

class StudentController extends Controller
{
    // In your StudentController@index method
public function index(Request $request)
{
    $query = Student::with('department');
    
    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('student_id', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%");
        });
    }
    
    if ($request->status) {
        $query->where('status', $request->status);
    }
    
    if ($request->department) {
        $query->where('department_id', $request->department);
    }
    
    $students = $query->latest()->paginate(15);
    $departments = Department::all();
    
    return view('students.index', compact('students', 'departments'));
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
        'email' => 'required|email|unique:students|unique:users,email',
        'department_id' => 'required',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $photo = null;

    if ($request->hasFile('photo')) {
        $photo = $request->file('photo')
            ->store('students', 'public');
    }

    $tempPassword = 'Temp@12345';

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $tempPassword,
    ]);

    $user->assignRole('student');

    Student::create([
        'user_id' => $user->id,
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
    Mail::to($request->email)
    ->send(
        new StudentWelcomeMail(
            $request->name,
            $request->email,
            $tempPassword
        )
    );

    return redirect()
        ->route('students.index')
        ->with(
            'success',
            'Student Added Successfully. Login Password: Temp@12345'
        );
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