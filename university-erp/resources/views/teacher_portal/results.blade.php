@extends('layouts.teacher_app')

@section('title', 'Results Management')

@section('content')

<style>
    .results-wrapper {
        padding: 20px 0;
    }

    .page-header {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        border-radius: 24px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .course-selector {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .exam-selector {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        display: none;
    }

    .exam-selector.active {
        display: block;
    }

    .student-list {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        display: none;
    }

    .student-list.active {
        display: block;
    }

    .student-table {
        margin-bottom: 0;
    }

    .student-table thead th {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        color: white;
        padding: 15px;
        font-size: 13px;
        font-weight: 600;
        border: none;
    }

    .student-table tbody tr {
        transition: all 0.2s ease;
    }

    .student-table tbody tr:hover {
        background: #f8f9fa;
    }

    .student-table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
    }

    .student-photo {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .marks-input {
        width: 120px;
        padding: 8px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        text-align: center;
    }

    .marks-input:focus {
        border-color: #8b5cf6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(139,92,246,0.1);
    }

    .grade-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .grade-A-plus { background: #d1fae5; color: #065f46; }
    .grade-A { background: #d1fae5; color: #065f46; }
    .grade-A-minus { background: #dbeafe; color: #1e40af; }
    .grade-B-plus { background: #dbeafe; color: #1e40af; }
    .grade-B { background: #fef3c7; color: #92400e; }
    .grade-B-minus { background: #fef3c7; color: #92400e; }
    .grade-C { background: #fed7aa; color: #9a3412; }
    .grade-D { background: #fee2e2; color: #991b1b; }
    .grade-F { background: #fecaca; color: #7f1d1d; }

    .submit-btn {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        margin: 20px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(139,92,246,0.4);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .result-summary {
        background: #f8f9fa;
        border-radius: 16px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .summary-stats {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .stat-card {
        flex: 1;
        text-align: center;
        padding: 15px;
        background: white;
        border-radius: 12px;
    }

    .stat-card .h3 {
        font-size: 28px;
        font-weight: 800;
        color: #6d28d9;
        margin-bottom: 5px;
    }

    .view-toggle {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .toggle-btn {
        padding: 8px 25px;
        border-radius: 30px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        background: #f1f5f9;
    }

    .toggle-btn.active {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        color: white;
    }

    .info-text {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }
</style>

<div class="results-wrapper">
    {{-- Page Header --}}
    <div class="page-header">
        <div style="position: relative; z-index: 1;">
            <h2 style="color: white; font-size: 28px; font-weight: 700; margin-bottom: 10px;">
                <i class="fas fa-chart-line me-2"></i> Results Management
            </h2>
            <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin: 0;">
                Manage student exam results and academic performance
            </p>
        </div>
    </div>

    {{-- Course Selector --}}
    <div class="course-selector">
        <form method="GET" action="{{ route('teacher.results') }}" id="courseForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Select Course</label>
                    <select name="course_id" class="form-select" onchange="document.getElementById('courseForm').submit()" style="border-radius: 12px;">
                        <option value="">-- Select a Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }} ({{ $course->code }}) - {{ $course->enrollments_count ?? 0 }} students
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="view-toggle">
                        <button type="button" class="toggle-btn {{ $viewMode == 'upload' ? 'active' : '' }}" onclick="setViewMode('upload')">
                            <i class="fas fa-upload me-1"></i> Upload Results
                        </button>
                        <button type="button" class="toggle-btn {{ $viewMode == 'view' ? 'active' : '' }}" onclick="setViewMode('view')">
                            <i class="fas fa-eye me-1"></i> View Results
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if($selectedCourse)
        {{-- Exam Selector for Upload Mode --}}
        <div class="exam-selector {{ $viewMode == 'upload' ? 'active' : '' }}">
            <form method="GET" action="{{ route('teacher.results') }}" id="examForm">
                <input type="hidden" name="course_id" value="{{ $selectedCourse->id }}">
                <input type="hidden" name="view_mode" value="upload">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Exam Type</label>
                        <select name="exam_type" class="form-select" onchange="this.form.submit()" style="border-radius: 12px;">
                            <option value="midterm" {{ $examType == 'midterm' ? 'selected' : '' }}>Mid Term Exam</option>
                            <option value="final" {{ $examType == 'final' ? 'selected' : '' }}>Final Exam</option>
                            <option value="assignment" {{ $examType == 'assignment' ? 'selected' : '' }}>Assignment</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Session</label>
                        <input type="text" name="session" class="form-control" value="{{ $session }}" onchange="this.form.submit()" style="border-radius: 12px;">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Semester</label>
                        <select name="semester" class="form-select" onchange="this.form.submit()" style="border-radius: 12px;">
                            @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}" {{ $semester == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Total Marks</label>
                        <input type="number" name="total_marks" class="form-control" value="{{ $totalMarks }}" onchange="this.form.submit()" style="border-radius: 12px;">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100" style="border-radius: 12px;">
                            <i class="fas fa-search me-1"></i> Load
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Upload Results Mode --}}
        <div class="student-list {{ $viewMode == 'upload' ? 'active' : '' }}">
            <form method="POST" action="{{ route('teacher.results.upload') }}" id="resultsForm">
                @csrf
                <input type="hidden" name="course_id" value="{{ $selectedCourse->id }}">
                <input type="hidden" name="exam_type" value="{{ $examType }}">
                <input type="hidden" name="session" value="{{ $session }}">
                <input type="hidden" name="semester" value="{{ $semester }}">
                <input type="hidden" name="total_marks" value="{{ $totalMarks }}">
                
                <div class="table-responsive">
                    <table class="table student-table">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th width="60">Photo</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Previous Result</th>
                                <th>Marks (out of {{ $totalMarks ?: 100 }})</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $enrollment)
                                @php
                                    $student = $enrollment->student;
                                    $existingResult = $existingResults[$student->id] ?? null;
                                    
                                    // Get previous marks and grade without using $this->
                                    if ($examType == 'midterm') {
                                        $previousMarks = $existingResult ? $existingResult->midterm_marks : '';
                                        $previousGrade = $existingResult ? $existingResult->grade : '';
                                    } elseif ($examType == 'final') {
                                        $previousMarks = $existingResult ? $existingResult->final_marks : '';
                                        $previousGrade = $existingResult ? $existingResult->grade : '';
                                    } else {
                                        $previousMarks = $existingResult ? $existingResult->assignment_marks : '';
                                        $previousGrade = $existingResult ? $existingResult->grade : '';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($student->photo)
                                            <img src="{{ asset('storage/'.$student->photo) }}" class="student-photo">
                                        @else
                                            <img src="{{ asset('images/default-user.png') }}" class="student-photo">
                                        @endif
                                    </td>
                                    <td><strong>{{ $student->student_id }}</strong></td>
                                    <td>{{ $student->name }}</td>
                                    <td>
                                        @if($previousGrade)
                                            <span class="grade-badge grade-{{ str_replace('+', '-plus', str_replace('-', 'minus', $previousGrade)) }}">
                                                {{ $previousGrade }} ({{ $previousMarks }})
                                            </span>
                                        @else
                                            <span class="text-muted">No previous result</span>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="number" 
                                               name="results[{{ $student->id }}][marks]" 
                                               class="marks-input" 
                                               value="{{ $previousMarks }}"
                                               min="0" 
                                               max="{{ $totalMarks ?: 100 }}"
                                               step="0.01"
                                               oninput="calculateGrade(this, {{ $student->id }}, {{ $totalMarks ?: 100 }})">
                                        <input type="hidden" name="results[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                                    </td>
                                    <td>
                                        <span id="grade_{{ $student->id }}" class="grade-badge">
                                            {{ $previousGrade ?: '—' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <i class="fas fa-users"></i>
                                            <h4>No Students Enrolled</h4>
                                            <p class="text-muted">No students are enrolled in this course yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($students->count() > 0)
                    <div class="text-center">
                        <button type="submit" class="btn submit-btn text-white">
                            <i class="fas fa-save me-2"></i> Save {{ ucfirst($examType) }} Results
                        </button>
                    </div>
                @endif
            </form>
        </div>

        {{-- View Results Mode --}}
        <div class="student-list {{ $viewMode == 'view' ? 'active' : '' }}">
            <div class="result-summary">
                <div class="summary-stats">
                    <div class="stat-card">
                        <div class="h3">{{ $totalStudents }}</div>
                        <div class="text-muted small">Total Students</div>
                    </div>
                    <div class="stat-card">
                        <div class="h3">{{ $resultsPublished }}</div>
                        <div class="text-muted small">Results Published</div>
                    </div>
                    <div class="stat-card">
                        <div class="h3">{{ number_format($averageMarks, 1) }}</div>
                        <div class="text-muted small">Average Marks</div>
                    </div>
                    <div class="stat-card">
                        <div class="h3">{{ $passRate }}%</div>
                        <div class="text-muted small">Pass Rate</div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table student-table">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th width="60">Photo</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Mid Term</th>
                            <th>Final</th>
                            <th>Assignment</th>
                            <th>Total</th>
                            <th>Grade</th>
                            <th>GPA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $index => $enrollment)
                            @php
                                $student = $enrollment->student;
                                $result = $existingResults[$student->id] ?? null;
                                $midterm = $result ? $result->midterm_marks : '-';
                                $final = $result ? $result->final_marks : '-';
                                $assignment = $result ? $result->assignment_marks : '-';
                                $total = $result ? $result->total_marks : '-';
                                $grade = $result ? $result->grade : '—';
                                $gpa = $result ? $result->gpa : '—';
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($student->photo)
                                        <img src="{{ asset('storage/'.$student->photo) }}" class="student-photo">
                                    @else
                                        <img src="{{ asset('images/default-user.png') }}" class="student-photo">
                                    @endif
                                </td>
                                <td><strong>{{ $student->student_id }}</strong></td>
                                <td>{{ $student->name }}</td>
                                <td class="text-center">{{ is_numeric($midterm) ? $midterm : $midterm }}</td>
                                <td class="text-center">{{ is_numeric($final) ? $final : $final }}</td>
                                <td class="text-center">{{ is_numeric($assignment) ? $assignment : $assignment }}</td>
                                <td class="text-center"><strong>{{ is_numeric($total) ? $total : $total }}</strong></td>
                                <td>
                                    @if($grade != '—')
                                        <span class="grade-badge grade-{{ str_replace('+', '-plus', str_replace('-', 'minus', $grade)) }}">
                                            {{ $grade }}
                                        </span>
                                    @else
                                        {{ $grade }}
                                    @endif
                                </td>
                                <td>{{ is_numeric($gpa) ? number_format($gpa, 2) : $gpa }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <div class="empty-state">
                                        <i class="fas fa-chart-line"></i>
                                        <h4>No Results Available</h4>
                                        <p class="text-muted">No results have been published for this course yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="empty-state" style="background: white; border-radius: 20px; padding: 60px;">
            <i class="fas fa-book-open"></i>
            <h4>Select a Course</h4>
            <p class="text-muted">Please select a course from the dropdown above to manage results.</p>
        </div>
    @endif
</div>

<script>
    function setViewMode(mode) {
        const url = new URL(window.location.href);
        url.searchParams.set('view_mode', mode);
        url.searchParams.set('course_id', '{{ $selectedCourse->id ?? '' }}');
        window.location.href = url.toString();
    }
    
    function calculateGrade(input, studentId, totalMarks) {
        const marks = parseFloat(input.value);
        const gradeSpan = document.getElementById(`grade_${studentId}`);
        
        if (isNaN(marks)) {
            gradeSpan.textContent = '—';
            gradeSpan.className = 'grade-badge';
            return;
        }
        
        let grade, gpa;
        const percentage = (marks / totalMarks) * 100;
        
        if (percentage >= 80) { grade = 'A+'; gpa = 4.00; }
        else if (percentage >= 75) { grade = 'A'; gpa = 3.75; }
        else if (percentage >= 70) { grade = 'A-'; gpa = 3.50; }
        else if (percentage >= 65) { grade = 'B+'; gpa = 3.25; }
        else if (percentage >= 60) { grade = 'B'; gpa = 3.00; }
        else if (percentage >= 55) { grade = 'B-'; gpa = 2.75; }
        else if (percentage >= 50) { grade = 'C+'; gpa = 2.50; }
        else if (percentage >= 45) { grade = 'C'; gpa = 2.25; }
        else if (percentage >= 40) { grade = 'D'; gpa = 2.00; }
        else { grade = 'F'; gpa = 0.00; }
        
        gradeSpan.textContent = grade;
        let gradeClass = grade.replace('+', '-plus').replace('-', 'minus');
        gradeSpan.className = `grade-badge grade-${gradeClass}`;
        
        // Add hidden input for GPA
        let gpaInput = document.getElementById(`gpa_${studentId}`);
        if (!gpaInput) {
            gpaInput = document.createElement('input');
            gpaInput.type = 'hidden';
            gpaInput.name = `results[${studentId}][gpa]`;
            gpaInput.id = `gpa_${studentId}`;
            input.parentElement.appendChild(gpaInput);
        }
        gpaInput.value = gpa;
        
        let gradeInput = document.getElementById(`grade_input_${studentId}`);
        if (!gradeInput) {
            gradeInput = document.createElement('input');
            gradeInput.type = 'hidden';
            gradeInput.name = `results[${studentId}][grade]`;
            gradeInput.id = `grade_input_${studentId}`;
            input.parentElement.appendChild(gradeInput);
        }
        gradeInput.value = grade;
    }
</script>

@endsection