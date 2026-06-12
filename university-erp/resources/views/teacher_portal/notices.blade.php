@extends('layouts.teacher_app')

@section('title', 'Notices')

@section('content')

<style>
    .notices-wrapper {
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

    .notice-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .notice-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .notice-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 10px;
    }

    .notice-meta {
        display: flex;
        gap: 15px;
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e9ecef;
    }

    .notice-content {
        font-size: 14px;
        color: #4a5568;
        line-height: 1.6;
    }

    .audience-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .audience-all { background: #d1fae5; color: #065f46; }
    .audience-teachers { background: #dbeafe; color: #1e40af; }
    .audience-students { background: #fef3c7; color: #92400e; }
    .audience-both { background: #e0e7ff; color: #4338ca; }

    .btn-add {
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
        border: none;
        padding: 10px 25px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(245,158,11,0.4);
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

    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 3px;
        color: #f59e0b;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
        border-color: transparent;
        color: white;
    }
</style>

<div class="notices-wrapper">
    {{-- Page Header --}}
    <div class="page-header">
        <div style="position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
            <div>
                <h2 style="color: white; font-size: 28px; font-weight: 700; margin-bottom: 10px;">
                    <i class="fas fa-bullhorn me-2"></i> Notices & Announcements
                </h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin: 0;">
                    View and manage all notices
                </p>
            </div>
            <button class="btn-add text-white" data-bs-toggle="modal" data-bs-target="#addNoticeModal">
                <i class="fas fa-plus-circle me-1"></i> Post New Notice
            </button>
        </div>
    </div>

    {{-- Notices List --}}
    @if($notices->count() > 0)
        @foreach($notices as $notice)
            <div class="notice-card">
                <div class="notice-title">{{ $notice->title }}</div>
                <div class="notice-meta">
                    <span><i class="fas fa-calendar-alt"></i> {{ $notice->created_at->format('d M Y, h:i A') }}</span>
                    <span>
                        <i class="fas fa-users"></i> 
                        <span class="audience-badge audience-{{ $notice->audience }}">
                            {{ ucfirst($notice->audience) }}
                        </span>
                    </span>
                </div>
                <div class="notice-content">
                    {{ $notice->content }}
                </div>
            </div>
        @endforeach
        
        <div class="pagination-wrapper">
            {{ $notices->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-bell-slash"></i>
            <h4>No Notices Found</h4>
            <p class="text-muted">No notices have been published yet.</p>
            <button class="btn-add text-white mt-3" data-bs-toggle="modal" data-bs-target="#addNoticeModal">
                <i class="fas fa-plus-circle me-1"></i> Post Your First Notice
            </button>
        </div>
    @endif
</div>

{{-- Add Notice Modal --}}
<div class="modal fade" id="addNoticeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%); color: white; border-radius: 20px 20px 0 0;">
                <h5 class="modal-title">Post New Notice</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('teacher.notices.create') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Notice Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Audience</label>
                        <select name="audience" class="form-select" required>
                            <option value="all">All (Everyone)</option>
                            <option value="teachers">Teachers Only</option>
                            <option value="students">Students Only</option>
                            <option value="both">Both Teachers & Students</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notice Content</label>
                        <textarea name="content" class="form-control" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Publish Notice</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection