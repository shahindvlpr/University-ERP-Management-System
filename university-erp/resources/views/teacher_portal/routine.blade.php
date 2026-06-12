@extends('layouts.teacher_app')

@section('title', 'My Routine')

@section('content')

<style>
    .routine-wrapper {
        padding: 20px 0;
    }

    .page-header {
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
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

    .routine-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .day-header {
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
        padding: 15px 20px;
        color: white;
    }

    .day-header h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .routine-table {
        width: 100%;
        border-collapse: collapse;
    }

    .routine-table th {
        background: #f8f9fa;
        padding: 12px 15px;
        font-size: 13px;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

    .routine-table td {
        padding: 12px 15px;
        font-size: 14px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }

    .time-badge {
        background: #e0e7ff;
        color: #4338ca;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .course-code {
        font-weight: 700;
        color: #2d3748;
    }

    .course-name {
        font-size: 13px;
        color: #6c757d;
        margin-top: 3px;
    }

    .room-info {
        color: #10b981;
        font-size: 12px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .btn-add {
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
        border: none;
        padding: 10px 25px;
        border-radius: 12px;
        font-weight: 600;
        color: white;
        transition: all 0.3s;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(245,158,11,0.4);
        color: white;
    }
</style>

<div class="routine-wrapper">
    {{-- Page Header --}}
    <div class="page-header">
        <div style="position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
            <div>
                <h2 style="color: white; font-size: 28px; font-weight: 700; margin-bottom: 10px;">
                    <i class="fas fa-calendar-alt me-2"></i> Class Routine
                </h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin: 0;">
                    Your weekly teaching schedule
                </p>
            </div>
            <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addRoutineModal">
                <i class="fas fa-plus-circle me-1"></i> Add Class
            </button>
        </div>
    </div>

    @if(isset($routinesByDay) && $routinesByDay->count() > 0)
        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
            @if(isset($routinesByDay[$day]) && $routinesByDay[$day]->count() > 0)
                <div class="routine-card">
                    <div class="day-header">
                        <h4><i class="fas fa-calendar-day me-2"></i> {{ $day }}</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="routine-table">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Course</th>
                                    <th>Room</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($routinesByDay[$day] as $routine)
                                    <tr>
                                        <td>
                                            <span class="time-badge">
                                                {{ \Carbon\Carbon::parse($routine->start_time)->format('h:i A') }} - 
                                                {{ \Carbon\Carbon::parse($routine->end_time)->format('h:i A') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="course-code">{{ $routine->course->code ?? 'N/A' }}</div>
                                            <div class="course-name">{{ $routine->course->name ?? 'N/A' }}</div>
                                        </td>
                                        <td>
                                            <span class="room-info">
                                                <i class="fas fa-map-marker-alt me-1"></i> {{ $routine->room ?? 'TBD' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="empty-state">
            <i class="fas fa-calendar-times"></i>
            <h4>No Routine Found</h4>
            <p class="text-muted">You haven't added any classes to your routine yet.</p>
            <button class="btn-add mt-3" data-bs-toggle="modal" data-bs-target="#addRoutineModal">
                <i class="fas fa-plus-circle me-1"></i> Add Your First Class
            </button>
        </div>
    @endif
</div>

{{-- Add Routine Modal --}}
<div class="modal fade" id="addRoutineModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%); color: white; border-radius: 20px 20px 0 0;">
                <h5 class="modal-title">Add Class to Routine</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('teacher.routine.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Course</label>
                        <select name="course_id" class="form-select" required>
                            <option value="">Select Course</option>
                            @foreach($courses ?? [] as $course)
                                <option value="{{ $course->id }}">{{ $course->name }} ({{ $course->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Day</label>
                        <select name="day" class="form-select" required>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Start Time</label>
                                <input type="time" name="start_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">End Time</label>
                                <input type="time" name="end_time" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Room</label>
                        <input type="text" name="room" class="form-control" placeholder="e.g., Room 301, Online">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Class</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection