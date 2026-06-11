@extends('layouts.student_app')

@section('title', 'Academic Transcript')

@section('content')

<style>
    @media print {
        body {
            background: white;
            padding: 0;
            margin: 0;
        }
        .no-print {
            display: none !important;
        }
        .card {
            box-shadow: none !important;
            border: none !important;
        }
        .print-container {
            padding: 0 !important;
            margin: 0 !important;
        }
        .transcript-header {
            border-bottom: 2px solid #000 !important;
        }
        .signature-section {
            margin-top: 50px !important;
        }
        .grade-table th, .grade-table td {
            border: 1px solid #000 !important;
        }
        .watermark {
            opacity: 0.1 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }

    .transcript-wrapper {
        background: linear-gradient(135deg, #f5f7fa 0%, #f0f2f5 100%);
        padding: 30px;
        min-height: 100vh;
    }

    .transcript-card {
        background: white;
        border-radius: 0px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        position: relative;
    }

    .watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.03;
        font-size: 120px;
        font-weight: bold;
        white-space: nowrap;
        pointer-events: none;
        z-index: 0;
        font-family: 'Arial', sans-serif;
    }

    .transcript-header {
        background: linear-gradient(135deg, #1a3c34 0%, #0f2b25 100%);
        color: white;
        padding: 30px 35px;
        position: relative;
        z-index: 1;
    }

    .university-logo {
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,0.15);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin-right: 20px;
    }

    .transcript-title {
        text-align: center;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .transcript-title h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1a3c34;
        letter-spacing: 2px;
        margin: 0;
    }

    .transcript-title p {
        color: #64748b;
        font-size: 12px;
        margin: 5px 0 0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px 30px;
        margin-bottom: 25px;
        padding: 0 20px;
    }

    .info-item {
        border-bottom: 1px solid #e2e8f0;
        padding: 8px 0;
    }

    .info-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 3px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: #0f172a;
    }

    .cgpa-box {
        background: linear-gradient(135deg, #1a3c34 0%, #0f2b25 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        text-align: center;
        margin: 20px;
    }

    .cgpa-label {
        font-size: 12px;
        opacity: 0.9;
        letter-spacing: 1px;
    }

    .cgpa-value {
        font-size: 32px;
        font-weight: 800;
        line-height: 1;
        margin: 5px 0;
    }

    .cgpa-class {
        font-size: 13px;
        opacity: 0.95;
    }

    .semester-section {
        margin-bottom: 30px;
        page-break-inside: avoid;
    }

    .semester-header {
        background: #f8fafc;
        border-left: 4px solid #1a3c34;
        padding: 10px 15px;
        margin-bottom: 15px;
    }

    .semester-header h4 {
        font-size: 16px;
        font-weight: 700;
        color: #1a3c34;
        margin: 0;
    }

    .semester-header p {
        font-size: 12px;
        color: #64748b;
        margin: 3px 0 0;
    }

    .grade-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .grade-table th {
        background: #f1f5f9;
        padding: 12px 10px;
        text-align: left;
        font-weight: 600;
        color: #334155;
        border: 1px solid #e2e8f0;
    }

    .grade-table td {
        padding: 10px;
        border: 1px solid #e2e8f0;
        color: #475569;
    }

    .grade-table tr:hover {
        background: #faf5ff;
    }

    .grade-point {
        font-weight: 700;
        color: #1a3c34;
    }

    .summary-stats {
        background: #f8fafc;
        padding: 15px 20px;
        margin: 20px;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
    }

    .summary-item {
        text-align: center;
        flex: 1;
    }

    .summary-item .label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
    }

    .summary-item .value {
        font-size: 18px;
        font-weight: 700;
        color: #1a3c34;
    }

    .signature-section {
        margin: 30px 20px 20px;
        padding-top: 20px;
        border-top: 1px dashed #cbd5e1;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .signature-item {
        text-align: center;
        min-width: 150px;
    }

    .signature-line {
        width: 180px;
        border-top: 1px solid #334155;
        margin: 30px auto 8px;
    }

    .signature-label {
        font-size: 11px;
        color: #64748b;
    }

    .footer-note {
        background: #fef9c3;
        padding: 12px 20px;
        margin: 20px;
        border-radius: 6px;
        font-size: 11px;
        color: #854d0e;
        text-align: center;
    }

    .btn-print {
        background: linear-gradient(135deg, #1a3c34 0%, #0f2b25 100%);
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    @media (max-width: 768px) {
        .transcript-wrapper {
            padding: 15px;
        }
        .info-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        .summary-stats {
            flex-direction: column;
        }
        .grade-table {
            font-size: 11px;
        }
        .grade-table th, .grade-table td {
            padding: 6px;
        }
    }
</style>

<div class="transcript-wrapper">
    <div class="transcript-card">
        <div class="watermark">
            UNIVERSITY
        </div>

        {{-- Header Section --}}
        <div class="transcript-header">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                <div style="display: flex; align-items: center;">
                    <div class="university-logo">
                        <i class="fas fa-graduation-cap" style="font-size: 36px;"></i>
                    </div>
                    <div>
                        <h2 style="margin: 0; font-size: 24px; font-weight: 700;">UniERP</h2>
                        <p style="margin: 5px 0 0; opacity: 0.85; font-size: 12px;">University of Academic Excellence</p>
                    </div>
                </div>
                <div style="text-align: right;">
                    <p style="margin: 0; font-size: 11px; opacity: 0.85;">Est. 2024</p>
                    <p style="margin: 5px 0 0; font-size: 11px; opacity: 0.85;">ISO 9001:2024 Certified</p>
                </div>
            </div>
        </div>

        <div class="transcript-title">
            <h2><i class="fas fa-scroll me-2"></i> ACADEMIC TRANSCRIPT</h2>
            <p>Statement of Academic Record — Official Document</p>
        </div>

        {{-- Student Information --}}
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label"><i class="fas fa-user-graduate me-1"></i> Student Name</div>
                <div class="info-value">{{ $student->name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label"><i class="fas fa-id-card me-1"></i> Student ID</div>
                <div class="info-value">{{ $student->student_id }}</div>
            </div>
            <div class="info-item">
                <div class="info-label"><i class="fas fa-building me-1"></i> Department</div>
                <div class="info-value">{{ $student->department->name ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label"><i class="fas fa-calendar-alt me-1"></i> Program Duration</div>
                <div class="info-value">{{ $student->session ?? 'N/A' }} — {{ (int)($student->session ?? '2024') + 4 }}</div>
            </div>
            <div class="info-item">
                <div class="info-label"><i class="fas fa-envelope me-1"></i> Email</div>
                <div class="info-value">{{ $student->email }}</div>
            </div>
            <div class="info-item">
                <div class="info-label"><i class="fas fa-phone me-1"></i> Contact</div>
                <div class="info-value">{{ $student->phone ?? 'N/A' }}</div>
            </div>
        </div>

        {{-- CGPA Summary Box --}}
        <div class="cgpa-box">
            <div class="cgpa-label">CUMULATIVE GRADE POINT AVERAGE (CGPA)</div>
            <div class="cgpa-value">
                {{ number_format($cgpa, 2) }}
                <span style="font-size: 14px;">/ 4.00</span>
            </div>
            <div class="cgpa-class">
                @php
                    $cgpaValue = $cgpa ?? 0;
                    $class = match(true) {
                        $cgpaValue >= 3.75 => '🏆 DISTINCTION (Summa Cum Laude)',
                        $cgpaValue >= 3.50 => '⭐ FIRST CLASS HONORS (Magna Cum Laude)',
                        $cgpaValue >= 3.00 => '📘 FIRST DIVISION (Cum Laude)',
                        $cgpaValue >= 2.50 => '📗 SECOND DIVISION',
                        $cgpaValue >= 2.00 => '📙 THIRD DIVISION',
                        default => '⚠️ PROBATIONARY'
                    };
                @endphp
                {{ $class }}
            </div>
        </div>

        {{-- Semester-wise Results --}}
        @php
            $totalCredits = 0;
            $totalGradePoints = 0;
            $semesterCount = 0;
        @endphp

        @foreach($results as $semester => $semesterResults)
            @php
                $semesterCredits = 0;
                $semesterPoints = 0;
                foreach($semesterResults as $result) {
                    $creditHours = $result->course->credit_hours ?? 3;
                    $semesterCredits += $creditHours;
                    $semesterPoints += ($result->gpa ?? 0) * $creditHours;
                }
                $semesterGPA = $semesterCredits > 0 ? round($semesterPoints / $semesterCredits, 2) : 0;
                $totalCredits += $semesterCredits;
                $totalGradePoints += $semesterPoints;
                $semesterCount++;
            @endphp

            <div class="semester-section">
                <div class="semester-header">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <div>
                            <h4><i class="fas fa-book-open me-2"></i> {{ $semester }}</h4>
                            <p>Total Credits: {{ $semesterCredits }} | Semester GPA: <strong style="color: #1a3c34;">{{ $semesterGPA }}</strong> / 4.00</p>
                        </div>
                        @php
                            $gradeIcon = match(true) {
                                $semesterGPA >= 3.75 => '🏆',
                                $semesterGPA >= 3.50 => '⭐',
                                $semesterGPA >= 3.00 => '📘',
                                $semesterGPA >= 2.50 => '📗',
                                default => '📙'
                            };
                        @endphp
                        <div style="font-size: 24px;">{{ $gradeIcon }}</div>
                    </div>
                </div>

                <table class="grade-table">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="40%">Course Code & Title</th>
                            <th width="10%">Credits</th>
                            <th width="10%">Grade</th>
                            <th width="10%">Grade Point</th>
                            <th width="15%">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($semesterResults as $index => $result)
                            @php
                                $creditHours = $result->course->credit_hours ?? 3;
                                $gradeLetter = $result->grade ?? 'N/A';
                                $gradePoint = $result->gpa ?? 0;
                                $remarks = match(true) {
                                    $gradeLetter == 'A+' => 'Excellent',
                                    $gradeLetter == 'A' => 'Outstanding',
                                    $gradeLetter == 'A-' => 'Very Good',
                                    $gradeLetter == 'B+' => 'Good',
                                    $gradeLetter == 'B' => 'Satisfactory',
                                    $gradeLetter == 'C' => 'Average',
                                    default => 'Completed'
                                };
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $result->course->code ?? 'N/A' }}</strong><br>
                                    <small style="color: #64748b;">{{ $result->course->name ?? 'N/A' }}</small>
                                </td>
                                <td class="text-center">{{ $creditHours }}</td>
                                <td class="text-center">
                                    <span style="background: #e8f0fe; padding: 4px 12px; border-radius: 20px; font-weight: 600; display: inline-block;">
                                        {{ $gradeLetter }}
                                    </span>
                                </td>
                                <td class="text-center grade-point">{{ number_format($gradePoint, 2) }}</td>
                                <td><small>{{ $remarks }}</small></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach

        {{-- Overall Summary Statistics --}}
        @php
            $overallGPA = $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;
            $totalCourses = 0;
            foreach($results as $semesterResults) {
                $totalCourses += count($semesterResults);
            }
            $gradeDistribution = [
                'A+' => 0, 'A' => 0, 'A-' => 0, 'B+' => 0, 'B' => 0, 'B-' => 0, 'C+' => 0, 'C' => 0, 'D' => 0, 'F' => 0
            ];
            foreach($results as $semesterResults) {
                foreach($semesterResults as $result) {
                    $grade = $result->grade ?? 'N/A';
                    if(isset($gradeDistribution[$grade])) $gradeDistribution[$grade]++;
                }
            }
        @endphp

        <div class="summary-stats">
            <div class="summary-item">
                <div class="label">Total Semesters</div>
                <div class="value">{{ $semesterCount }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Courses Completed</div>
                <div class="value">{{ $totalCourses }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Total Credits Earned</div>
                <div class="value">{{ $totalCredits }}</div>
            </div>
            <div class="summary-item">
                <div class="label">Overall CGPA</div>
                <div class="value">{{ number_format($overallGPA, 2) }}</div>
            </div>
        </div>

        {{-- Grade Distribution --}}
        @if($totalCourses > 0)
        <div style="margin: 0 20px 20px;">
            <div style="font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 10px;">
                <i class="fas fa-chart-pie me-1"></i> Grade Distribution
            </div>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                @foreach($gradeDistribution as $grade => $count)
                    @if($count > 0)
                        <span style="background: #f1f5f9; padding: 3px 12px; border-radius: 20px; font-size: 11px;">
                            {{ $grade }}: {{ $count }} course(s)
                        </span>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- Grading Scale --}}
        <div style="margin: 0 20px 20px;">
            <details style="font-size: 11px;">
                <summary style="cursor: pointer; color: #64748b; font-weight: 500;">
                    <i class="fas fa-info-circle me-1"></i> Grading Scale Information
                </summary>
                <div style="margin-top: 10px; display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 8px; background: #f8fafc; padding: 12px; border-radius: 8px;">
                    <div><strong>A+</strong> (80-100) = 4.00</div>
                    <div><strong>A</strong> (75-79) = 3.75</div>
                    <div><strong>A-</strong> (70-74) = 3.50</div>
                    <div><strong>B+</strong> (65-69) = 3.25</div>
                    <div><strong>B</strong> (60-64) = 3.00</div>
                    <div><strong>B-</strong> (55-59) = 2.75</div>
                    <div><strong>C+</strong> (50-54) = 2.50</div>
                    <div><strong>C</strong> (45-49) = 2.25</div>
                    <div><strong>D</strong> (40-44) = 2.00</div>
                    <div><strong>F</strong> (&lt;40) = 0.00</div>
                </div>
            </details>
        </div>

        {{-- Signature Section --}}
        <div class="signature-section">
            <div class="signature-item">
                <div class="signature-line"></div>
                <div class="signature-label">Controller of Examinations</div>
                <div style="font-size: 10px; color: #64748b;">Digitally Signed</div>
            </div>
            <div class="signature-item">
                <div class="signature-line"></div>
                <div class="signature-label">Dean, Faculty of {{ $student->department->name ?? 'Academic' }}</div>
                <div style="font-size: 10px; color: #64748b;">University Seal</div>
            </div>
            <div class="signature-item">
                <div class="signature-line"></div>
                <div class="signature-label">Registrar</div>
                <div style="font-size: 10px; color: #64748b;">Authorized Signature</div>
            </div>
        </div>

        {{-- Footer Note --}}
        <div class="footer-note">
            <i class="fas fa-qrcode me-2"></i> This is a computer-generated document. No signature is required.
            <span style="display: block; font-size: 10px; margin-top: 5px;">
                Document ID: TR-{{ $student->student_id }}-{{ date('Ymd') }} | Generated on: {{ now()->format('F d, Y h:i A') }}
            </span>
        </div>
    </div>

    {{-- Print Button --}}
    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-print text-white">
            <i class="fas fa-print me-2"></i> Print / Download Transcript (PDF)
        </button>
        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary ms-2" style="padding: 12px 30px;">
            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
        </a>
    </div>
</div>

@endsection