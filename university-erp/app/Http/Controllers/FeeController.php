<?php

namespace App\Http\Controllers;

use App\Models\FeeInvoice;
use App\Models\Student;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        $fees = FeeInvoice::with('student')

            ->when($request->search, function ($query) use ($request) {

                $query->whereHas('student', function ($q) use ($request) {

                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('student_id', 'like', '%' . $request->search . '%');

                });

            })

            ->latest()
            ->paginate(10);

        return view('fees.index', compact('fees'));
    }

    public function create()
    {
        $students = Student::where('status', 'active')->get();

        return view('fees.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'due_date' => 'required|date',
            'fee_type' => 'required',
            'session' => 'required',
            'semester' => 'required',
        ]);

        $due_amount = $request->amount - $request->paid_amount;

        $status = 'unpaid';

        if ($due_amount <= 0) {
            $status = 'paid';
        } elseif ($request->paid_amount > 0) {
            $status = 'partial';
        }

        FeeInvoice::create([
            'student_id' => $request->student_id,
            'invoice_no' => 'INV-' . time(),
            'amount' => $request->amount,
            'paid_amount' => $request->paid_amount,
            'due_amount' => $due_amount,
            'due_date' => $request->due_date,
            'status' => $status,
            'fee_type' => $request->fee_type,
            'session' => $request->session,
            'semester' => $request->semester,
            'remarks' => $request->remarks,
        ]);

        return redirect()
            ->route('fees.index')
            ->with('success', 'Fee Invoice Created Successfully');
    }

    public function show(FeeInvoice $fee)
    {
        return view('fees.show', compact('fee'));
    }

    public function edit(FeeInvoice $fee)
    {
        $students = Student::where('status', 'active')->get();

        return view('fees.edit', compact('fee', 'students'));
    }

    public function update(Request $request, FeeInvoice $fee)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'due_date' => 'required|date',
            'fee_type' => 'required',
            'session' => 'required',
            'semester' => 'required',
        ]);

        $due_amount = $request->amount - $request->paid_amount;

        $status = 'unpaid';

        if ($due_amount <= 0) {
            $status = 'paid';
        } elseif ($request->paid_amount > 0) {
            $status = 'partial';
        }

        $fee->update([
            'student_id' => $request->student_id,
            'amount' => $request->amount,
            'paid_amount' => $request->paid_amount,
            'due_amount' => $due_amount,
            'due_date' => $request->due_date,
            'status' => $status,
            'fee_type' => $request->fee_type,
            'session' => $request->session,
            'semester' => $request->semester,
            'remarks' => $request->remarks,
        ]);

        return redirect()
            ->route('fees.index')
            ->with('success', 'Fee Invoice Updated Successfully');
    }

    public function destroy(FeeInvoice $fee)
    {
        $fee->delete();

        return redirect()
            ->route('fees.index')
            ->with('success', 'Fee Invoice Deleted Successfully');
    }
}