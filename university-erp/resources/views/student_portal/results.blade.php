@extends('layouts.student_app')

@section('title', 'My Academic Results')

@section('content')

<style>
    .results-wrapper {
        padding: 20px 0;
    }

    /* Header Section */
    .results-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .results-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    /* Summary Cards */
    .summary-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .summary-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 15px;
    }

    .summary-label {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .summary-value {
        font-size: 28px;
        font-weight: 800;
        color: #2d3748;
    }

    /* Semester Card */
    .semester-card {
        background: white;
        border-radius: 20px;
        margin-bottom: 25px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .semester-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .semester-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 15px 25px;
        color: white;
        cursor: pointer;
        transition: all 0.3s;
    }

    .semester-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .semester-gpa {
        background: rgba(255,255,255,0.2);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .grade-table {
        width: 100%;
        border-collapse: collapse;
    }

    .grade-table thead th {
        background: #f8f9fa;
        padding: 12px 15px;
        font-size: 13px;
        font-weight: 700;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

    .grade-table tbody td {
        padding: 12px 15px;
        font-size: 14px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }

    .grade-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-align: center;
        min-width: 60px;
    }

    .grade-A-plus { background: #d1fae5; color: #065f46; }
    .grade-A { background: #d1fae5; color: #065f46; }
    .grade-A-minus { background: #dbeafe; color: #1e40af; }
    .grade-B-plus { background: #dbeafe; color: #1e40af; }
    .grade-B { background: #fef3c7; color: #92400e; }
    .grade-B-minus { background: #fef3c7; color: #92400e; }
    .grade-C { background: #fee2e2; color: #991b1b; }
    .grade-D { background: #fee2e2; color: #991b1b; }
    .grade-F { background: #fecaca; color: #7f1d1d; }

    /* Performance Chart */
    .performance-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
    }

    /* Transcript Button */
    .transcript-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 30px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .transcript-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102,126,234,0.4);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 20px;
        background: white;
        border-radius: 20px;
        margin-top: 20px;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 3px;
        color: #667eea;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
        color: white;
    }

    @media (max-width: 768px) {
        .results-header {
            padding: 20px;
        }
        .summary-value {
            font-size: 22px;
        }
        .grade-table {
            font-size: 12px;
        }
        .grade-table thead th,
        .grade-table tbody td {
            padding: 8px 10px;
        }
    }
</style>

<div class="results-wrapper">
    @php
        $totalCourses = $results->count();
        $totalCredits = 0;
        $totalGradePoints = 0;
        $gradeDistribution = ['A+' => 0, 'A' => 0, 'A-' => 0, 'B+' => 0, 'B' => 0, 'B-' => 0, 'C' => 0, 'D' => 0, 'F' => 0];
        
        foreach($results as $result) {
            $creditHours = $result->course->credit_hours ?? 3;
            $totalCredits += $creditHours;
            $totalGradePoints += ($result->gpa ?? 0) * $creditHours;
            
            $grade = $result->grade ?? 'N/A';
            if(isset($gradeDistribution[$grade])) $gradeDistribution[$grade]++;
        }
        
        $cgpa = $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;
        
        // Group results by semester
        $resultsBySemester = [];
        foreach($results as $result) {
            $semester = $result->semester ?? $result->course->semester ?? 'General';
            if (!isset($resultsBySemester[$semester])) {
                $resultsBySemester[$semester] = [];
            }
            $resultsBySemester[$semester][] = $result;
        }
        
        // Calculate semester GPA
        $semesterStats = [];
        foreach($resultsBySemester as $semester => $courses) {
            $semCredits = 0;
            $semPoints = 0;
            foreach($courses as $course) {
                $credits = $course->course->credit_hours ?? 3;
                $semCredits += $credits;
                $semPoints += ($course->gpa ?? 0) * $credits;
            }
            $semesterStats[$semester] = $semCredits > 0 ? round($semPoints / $semCredits, 2) : 0;
        }
        
        $classDivision = match(true) {
            $cgpa >= 3.75 => 'Distinction (Summa Cum Laude)',
            $cgpa >= 3.50 => 'First Class Honours (Magna Cum Laude)',
            $cgpa >= 3.00 => 'First Division (Cum Laude)',
            $cgpa >= 2.50 => 'Second Division',
            $cgpa >= 2.00 => 'Third Division',
            default => 'Probationary'
        };
    @endphp

    {{-- Header Section --}}
    <div class="results-header">
        <div style="position: relative; z-index: 1;">
            <h2 style="color: white; font-size: 28px; font-weight: 700; margin-bottom: 10px;">
                <i class="fas fa-chart-line me-2"></i> Academic Results
            </h2>
            <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin: 0;">
                View your detailed academic performance across all semesters
            </p>
        </div>
    </div>

    {{-- Summary Statistics --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="summary-card">
                <div class="summary-icon" style="background: rgba(102,126,234,0.1); color: #667eea;">
                    <i class="fas fa-book"></i>
                </div>
                <div class="summary-label">Courses Completed</div>
                <div class="summary-value">{{ $totalCourses }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="summary-card">
                <div class="summary-icon" style="background: rgba(67,233,123,0.1); color: #43e97b;">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="summary-label">Total Credits</div>
                <div class="summary-value">{{ $totalCredits }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="summary-card">
                <div class="summary-icon" style="background: rgba(250,112,154,0.1); color: #fa709a;">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="summary-label">CGPA</div>
                <div class="summary-value">{{ number_format($cgpa, 2) }}</div>
                <small class="text-muted">/ 4.00</small>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="summary-card">
                <div class="summary-icon" style="background: rgba(255,193,7,0.1); color: #ffc107;">
                    <i class="fas fa-medal"></i>
                </div>
                <div class="summary-label">Class</div>
                <div class="summary-value" style="font-size: 16px;">{{ $classDivision }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Results by Semester --}}
        <div class="col-lg-8">
            @forelse($resultsBySemester as $semester => $courses)
                @php
                    $semesterGPA = $semesterStats[$semester] ?? 0;
                    $semesterClass = match(true) {
                        $semesterGPA >= 3.75 => '🏆 Excellent',
                        $semesterGPA >= 3.50 => '⭐ Very Good',
                        $semesterGPA >= 3.00 => '📘 Good',
                        $semesterGPA >= 2.50 => '📗 Satisfactory',
                        default => '⚠️ Needs Improvement'
                    };
                @endphp
                <div class="semester-card">
                    <div class="semester-header d-flex justify-content-between align-items-center" onclick="toggleSemester(this)">
                        <div>
                            <h4><i class="fas fa-graduation-cap me-2"></i> {{ $semester }}</h4>
                        </div>
                        <div class="d-flex gap-3 align-items-center">
                            <span class="semester-gpa">GPA: {{ number_format($semesterGPA, 2) }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="semester-content" style="display: block;">
                        <div class="table-responsive">
                            <table class="grade-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Course Code</th>
                                        <th>Course Title</th>
                                        <th>Credits</th>
                                        <th>Total Marks</th>
                                        <th>Grade</th>
                                        <th>GPA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $index => $result)
                                        @php
                                            $gradeClass = match($result->grade) {
                                                'A+' => 'grade-A-plus',
                                                'A' => 'grade-A',
                                                'A-' => 'grade-A-minus',
                                                'B+' => 'grade-B-plus',
                                                'B' => 'grade-B',
                                                'B-' => 'grade-B-minus',
                                                default => 'grade-C'
                                            };
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><strong>{{ $result->course->code ?? 'N/A' }}</strong></td>
                                            <td>{{ $result->course->name ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $result->course->credit_hours ?? 3 }}</td>
                                            <td class="text-center">{{ $result->total_marks ?? $result->marks ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                <span class="grade-badge {{ $gradeClass }}">
                                                    {{ $result->grade }}
                                                </span>
                                            </td>
                                            <td class="text-center"><strong>{{ number_format($result->gpa ?? 0, 2) }}</strong></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-chart-line"></i>
                    <h4>No Results Available</h4>
                    <p class="text-muted">Your results will appear here once published.</p>
                </div>
            @endforelse

            @if($results->hasPages())
                <div class="pagination-wrapper">
                    {{ $results->links() }}
                </div>
            @endif
        </div>

        {{-- Sidebar - Performance Analytics --}}
        <div class="col-lg-4">
            {{-- Grade Distribution --}}
            <div class="performance-card">
                <h5 class="section-title">
                    <i class="fas fa-chart-pie me-2"></i> Grade Distribution
                </h5>
                <canvas id="gradeChart" width="400" height="400"></canvas>
                <div class="mt-3">
                    @foreach($gradeDistribution as $grade => $count)
                        @if($count > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $grade }}</span>
                                <div class="progress flex-grow-1 mx-2" style="height: 8px;">
                                    <div class="progress-bar" style="width: {{ ($count / max($totalCourses, 1)) * 100 }}%; background: linear-gradient(90deg, #667eea, #764ba2);"></div>
                                </div>
                                <span class="small">{{ $count }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Performance Legend --}}
            <div class="performance-card">
                <h5 class="section-title">
                    <i class="fas fa-info-circle me-2"></i> Grading System
                </h5>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="grade-badge grade-A-plus">A+</span>
                            <small>80-100 (4.00)</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="grade-badge grade-A">A</span>
                            <small>75-79 (3.75)</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="grade-badge grade-A-minus">A-</span>
                            <small>70-74 (3.50)</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="grade-badge grade-B-plus">B+</span>
                            <small>65-69 (3.25)</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="grade-badge grade-B">B</span>
                            <small>60-64 (3.00)</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="grade-badge grade-B-minus">B-</span>
                            <small>55-59 (2.75)</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="grade-badge grade-C">C</span>
                            <small>50-54 (2.50)</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="grade-badge grade-D">D</span>
                            <small>40-49 (2.00)</small>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="grade-badge grade-F">F</span>
                            <small>&lt;40 (0.00)</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Transcript Download --}}
            <div class="performance-card text-center">
                <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                <h5 class="mb-2">Official Transcript</h5>
                <p class="text-muted small mb-3">Download your complete academic record</p>
                <a href="{{ route('student.transcript') }}" class="btn transcript-btn text-white w-100">
                    <i class="fas fa-download me-2"></i> Download Transcript
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Toggle semester visibility
    function toggleSemester(element) {
        const content = element.closest('.semester-card').querySelector('.semester-content');
        const icon = element.querySelector('.fa-chevron-down, .fa-chevron-up');
        
        if (content.style.display === 'none') {
            content.style.display = 'block';
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        } else {
            content.style.display = 'none';
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        }
    }

    // Grade Distribution Chart
    const ctx = document.getElementById('gradeChart')?.getContext('2d');
    if (ctx) {
        const gradeData = @json($gradeDistribution);
        const grades = Object.keys(gradeData).filter(g => gradeData[g] > 0);
        const counts = grades.map(g => gradeData[g]);
        const colors = ['#10b981', '#34d399', '#6ee7b7', '#fbbf24', '#f59e0b', '#ef4444', '#f87171', '#fca5a5', '#fecaca'];
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: grades,
                datasets: [{
                    data: counts,
                    backgroundColor: colors.slice(0, grades.length),
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { size: 11 } }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = counts.reduce((a, b) => a + b, 0);
                                const percentage = ((context.raw / total) * 100).toFixed(1);
                                return `${context.label}: ${context.raw} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Animate progress bars on load
    window.addEventListener('load', function() {
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 100);
        });
    });
</script>

@endsection