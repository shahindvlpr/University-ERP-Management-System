<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with(
            'student'
        )
        ->latest()
        ->paginate(10);

        return view(
            'certificates.index',
            compact('certificates')
        );
    }

    public function create()
    {
        $students = Student::all();

        return view(
            'certificates.create',
            compact('students')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'student_id'       => 'required',
            'certificate_type' => 'required',
            'issue_date'       => 'required'

        ]);

        Certificate::create([

            'student_id'       => $request->student_id,

            'certificate_no'   =>
                'CERT-'.time(),

            'certificate_type' =>
                $request->certificate_type,

            'issue_date'       =>
                $request->issue_date,

            'remarks'          =>
                $request->remarks

        ]);

        return redirect()
            ->route('certificates.index')
            ->with(
                'success',
                'Certificate Generated Successfully'
            );
    }

    public function show(
        Certificate $certificate
    )
    {
        return view(
            'certificates.show',
            compact('certificate')
        );
    }

    public function destroy(
        Certificate $certificate
    )
    {
        $certificate->delete();

        return redirect()
            ->route('certificates.index')
            ->with(
                'success',
                'Certificate Deleted Successfully'
            );
    }
}