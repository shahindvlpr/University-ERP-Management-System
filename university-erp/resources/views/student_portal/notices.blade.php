@extends('layouts.student_app')

@section('title', 'Notices & Announcements')

@section('content')

<style>
    .notice-wrapper {
        padding: 20px 0;
    }

    .notice-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .notice-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .notice-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }

    .search-filter-bar {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .notice-card {
        background: white;
        border-radius: 16px;
        padding: 0;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
        overflow: hidden;
        cursor: pointer;
        position: relative;
    }

    .notice-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border-color: transparent;
    }

    .notice-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .notice-badge.exam {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .notice-badge.event {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .notice-badge.holiday {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }

    .notice-badge.general {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    .notice-badge.urgent {
        background: linear-gradient(135deg, #ff0844 0%, #ffb199 100%);
        color: white;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(255,8,68,0.4); }
        70% { box-shadow: 0 0 0 10px rgba(255,8,68,0); }
        100% { box-shadow: 0 0 0 0 rgba(255,8,68,0); }
    }

    .notice-header-content {
        background: #f8f9fa;
        padding: 18px 25px;
        border-bottom: 1px solid #e9ecef;
    }

    .notice-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
        padding-right: 100px;
    }

    .notice-meta {
        display: flex;
        gap: 15px;
        margin-top: 10px;
        font-size: 12px;
        color: #6c757d;
    }

    .notice-meta i {
        margin-right: 5px;
    }

    .notice-body {
        padding: 20px 25px;
        color: #4a5568;
        line-height: 1.6;
        font-size: 14px;
    }

    .notice-footer {
        background: #f8f9fa;
        padding: 12px 25px;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .read-more-btn {
        color: #667eea;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .read-more-btn:hover {
        color: #764ba2;
        transform: translateX(5px);
        display: inline-block;
    }

    .attachment-badge {
        background: #e9ecef;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        color: #495057;
    }

    .attachment-badge i {
        margin-right: 3px;
    }

    .category-filter {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .filter-btn {
        padding: 8px 20px;
        border-radius: 25px;
        border: 1px solid #dee2e6;
        background: white;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s;
        cursor: pointer;
    }

    .filter-btn:hover {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
    }

    .search-box {
        position: relative;
    }

    .search-box input {
        padding-left: 40px;
        border-radius: 25px;
        border: 1px solid #dee2e6;
        height: 45px;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 16px;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .pagination-wrapper {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 3px;
        color: #667eea;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
    }

    @media (max-width: 768px) {
        .notice-header {
            padding: 20px;
        }
        .notice-title {
            font-size: 16px;
            padding-right: 80px;
        }
        .notice-badge {
            top: 15px;
            right: 15px;
            font-size: 10px;
            padding: 3px 10px;
        }
        .notice-header-content {
            padding: 15px;
        }
        .notice-body {
            padding: 15px;
        }
        .notice-footer {
            padding: 10px 15px;
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<div class="notice-wrapper">
    
    {{-- Header Section --}}
    <div class="notice-header">
        <div style="position: relative; z-index: 1;">
            <h2 style="color: white; font-size: 28px; font-weight: 700; margin-bottom: 10px;">
                <i class="fas fa-bullhorn me-2"></i> Notices & Announcements
            </h2>
            <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin: 0;">
                Stay updated with the latest news, events, and academic announcements from the university
            </p>
        </div>
    </div>

    {{-- Search and Filter Bar --}}
    <div class="search-filter-bar">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search notices by title or content...">
                </div>
            </div>
            <div class="col-md-6">
                <div class="category-filter" id="categoryFilter">
                    <button class="filter-btn active" data-category="all">All Notices</button>
                    <button class="filter-btn" data-category="exam">📝 Exam</button>
                    <button class="filter-btn" data-category="event">🎉 Event</button>
                    <button class="filter-btn" data-category="holiday">🎊 Holiday</button>
                    <button class="filter-btn" data-category="general">📢 General</button>
                    <button class="filter-btn" data-category="urgent">⚠️ Urgent</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Notices List --}}
    <div id="noticesContainer">
        @if($notices->count())
            @foreach($notices as $notice)
                @php
                    $badgeClass = match($notice->category) {
                        'exam' => 'exam',
                        'event' => 'event',
                        'holiday' => 'holiday',
                        'urgent' => 'urgent',
                        default => 'general'
                    };
                    $badgeIcon = match($notice->category) {
                        'exam' => '📝',
                        'event' => '🎉',
                        'holiday' => '🎊',
                        'urgent' => '⚠️',
                        default => '📢'
                    };
                    $badgeText = match($notice->category) {
                        'exam' => 'Examination',
                        'event' => 'Event',
                        'holiday' => 'Holiday',
                        'urgent' => 'Urgent',
                        default => 'General'
                    };
                @endphp

                <div class="notice-card" data-category="{{ $notice->category }}" data-title="{{ strtolower($notice->title) }}" data-content="{{ strtolower(strip_tags($notice->description ?? $notice->content)) }}">
                    <div class="notice-badge {{ $badgeClass }}">
                        {{ $badgeIcon }} {{ $badgeText }}
                    </div>
                    
                    <div class="notice-header-content">
                        <h5 class="notice-title">{{ $notice->title }}</h5>
                        <div class="notice-meta">
                            <span><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($notice->created_at)->format('l, d F Y') }}</span>
                            <span><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($notice->created_at)->format('h:i A') }}</span>
                            <span><i class="fas fa-user"></i> {{ $notice->author ?? 'Admin' }}</span>
                        </div>
                    </div>
                    
                    <div class="notice-body">
                        <p>
                            {{ Str::limit(strip_tags($notice->description ?? $notice->content), 200) }}
                        </p>
                        @if(strlen(strip_tags($notice->description ?? $notice->content)) > 200)
                            <a href="#" class="read-more-btn" data-bs-toggle="modal" data-bs-target="#noticeModal{{ $notice->id }}">
                                Read more <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        @endif
                    </div>
                    
                    <div class="notice-footer">
                        <div>
                            @if($notice->attachment)
                                <span class="attachment-badge">
                                    <i class="fas fa-paperclip"></i> Attachment available
                                </span>
                            @endif
                        </div>
                        <div style="font-size: 12px; color: #6c757d;">
                            <i class="fas fa-eye"></i> {{ $notice->views ?? rand(50, 500) }} views
                            <span class="ms-2"><i class="fas fa-share-alt"></i> Share</span>
                        </div>
                    </div>
                </div>

                {{-- Modal for full notice --}}
                <div class="modal fade" id="noticeModal{{ $notice->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 20px;">
                            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 20px 20px 0 0;">
                                <h5 class="modal-title">{{ $notice->title }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" style="padding: 25px;">
                                <div style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #dee2e6;">
                                    <span class="badge {{ $badgeClass }}" style="background: {{ $badgeClass === 'urgent' ? '#ff0844' : '#667eea' }};">
                                        {{ $badgeIcon }} {{ $badgeText }}
                                    </span>
                                    <span class="ms-3 text-muted"><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($notice->created_at)->format('F d, Y') }}</span>
                                </div>
                                <div style="line-height: 1.8; color: #4a5568;">
                                    {!! nl2br(e($notice->description ?? $notice->content)) !!}
                                </div>
                                @if($notice->attachment)
                                    <div class="mt-4 p-3 bg-light rounded">
                                        <i class="fas fa-download me-2"></i>
                                        <a href="{{ asset($notice->attachment) }}" download style="text-decoration: none;">Download Attachment</a>
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="window.print()">
                                    <i class="fas fa-print"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Pagination --}}
            <div class="pagination-wrapper">
                {{ $notices->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-bell-slash"></i>
                <h4>No Notices Available</h4>
                <p class="text-muted">There are no announcements at the moment. Please check back later.</p>
            </div>
        @endif
    </div>
</div>

<script>
    // Search and Filter Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterBtns = document.querySelectorAll('.filter-btn');
        const noticeCards = document.querySelectorAll('.notice-card');
        let currentCategory = 'all';
        let currentSearch = '';

        function filterNotices() {
            noticeCards.forEach(card => {
                const cardCategory = card.dataset.category;
                const cardTitle = card.dataset.title || '';
                const cardContent = card.dataset.content || '';
                
                const matchesCategory = currentCategory === 'all' || cardCategory === currentCategory;
                const matchesSearch = currentSearch === '' || 
                    cardTitle.includes(currentSearch) || 
                    cardContent.includes(currentSearch);
                
                if (matchesCategory && matchesSearch) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Search functionality
        searchInput.addEventListener('input', function(e) {
            currentSearch = e.target.value.toLowerCase().trim();
            filterNotices();
        });

        // Filter functionality
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentCategory = this.dataset.category;
                filterNotices();
            });
        });
    });
</script>

@endsection