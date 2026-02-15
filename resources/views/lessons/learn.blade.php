<!-- resources/views/lessons/learn.blade.php -->
@extends('layouts.app')

@section('title', 'تعلم الدروس - مركز زيد بن ثابت')

@section('styles')
<style>
    :root {
        --primary-color: #1a5f7a;
        --secondary-color: #2a9d8f;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
        --accent-color: #e9c46a;
    }

    .lesson-card {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .lesson-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .lesson-header {
        background: linear-gradient(135deg, #1a5f7a 0%, #2a9d8f 100%);
        color: white;
        border-radius: 10px 10px 0 0;
        padding: 15px;
    }

    .btn-zid {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .btn-zid:hover {
        background-color: var(--secondary-color);
        color: white;
    }

    .comment-section {
        border-top: 1px solid #eee;
        padding-top: 20px;
    }

    .task-item {
        border-right: 3px solid var(--secondary-color);
        padding-right: 15px;
        margin-bottom: 10px;
    }

    .date-badge {
        background-color: #e9f5fe;
        color: var(--primary-color);
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.85rem;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #666;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #ddd;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <!-- شريط العنوان والأزرار -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3" style="color: var(--primary-color);">
                <i class="fas fa-book-open me-2"></i>دروس {{ $course->title }}
            </h1>
            <p class="text-muted mb-0">
                "خيركم من تعلّم القرآن وعلّمه" - حديث نبوي شريف
            </p>
        </div>
        <div class="col-md-4 text-start">
            <!-- زر الرجوع إلى الكورسات -->
            <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary mb-2">
                <i class="fas fa-arrow-right me-2"></i>رجوع للكورسات
            </a>

            <!-- زر إضافة درس جديد للمشرف -->
            @if(auth()->check() && auth()->user()->role_id === 2)
            <a href="{{ route('lessons.create', $course->id) }}" class="btn btn-zid mb-2">
                <i class="fas fa-plus-circle me-2"></i>إضافة درس جديد
            </a>
            @endif
        </div>
    </div>

    <!-- رسائل النجاح/الخطأ -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- إحصائيات سريعة -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="mb-0">{{ $lessons->count() }}</h3>
                    <p class="text-muted mb-0">عدد الدروس</p>
                    </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="mb-0">{{ $lessons->where('video_link', '!=', null)->count() }}</h3>
                    <p class="text-muted mb-0">دروس بالفيديو</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="mb-0">{{ $lessons->where('date', '>=', now()->format('Y-m-d'))->count() }}</h3>
                    <p class="text-muted mb-0">دروس قادمة</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="mb-0">{{ $lessons->where('date', '<', now()->format('Y-m-d'))->count() }}</h3>
                    <p class="text-muted mb-0">دروس منتهية</p>
                </div>
            </div>
        </div>
    </div>

    <!-- بطاقات الدروس -->
    <div class="row">
        @forelse($lessons as $lesson)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="lesson-card h-100">
                <div class="lesson-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-bookmark me-2"></i>{{ $lesson->title }}
                    </h5>

                    <!-- أزرار التحكم للمشرف -->
                    @if(auth()->check() && auth()->user()->role_id === 2)
                    <div class="btn-group">
                        <a href="{{ route('lessons.edit', $lesson->id) }}" class="btn btn-sm btn-light">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('lessons.destroy', $lesson->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light" onclick="return confirm('هل أنت متأكد من حذف هذا الدرس؟')">
                                <i class="fas fa-trash text-danger"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <!-- تاريخ الدرس -->
                    <div class="mb-3">
                        <span class="date-badge">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ \Carbon\Carbon::parse($lesson->date)->translatedFormat('d F Y') }}
                        </span>
                        @if($lesson->date < now()->format('Y-m-d'))
                            <span class="badge bg-secondary ms-2">منتهي</span>
                        @elseif($lesson->date == now()->format('Y-m-d'))
                            <span class="badge bg-success ms-2">اليوم</span>
                        @else
                            <span class="badge bg-info ms-2">قادم</span>
                        @endif
                    </div>

                    <!-- رابط الفيديو -->
                    <div class="mb-3">
                        @if($lesson->video_link)
                        <a href="{{ $lesson->video_link }}" class="btn btn-zid w-100 mb-2" target="_blank">
                            <i class="fas fa-play-circle me-2"></i>مشاهدة الدرس
                        </a>
                        @else
                        <button class="btn btn-secondary w-100 mb-2" disabled>
                            <i class="fas fa-play-circle me-2"></i>لا يوجد فيديو
                        </button>
                        @endif
<!-- زر عرض الدرس -->
                        <a href="{{ route('lessons.learn', $lesson->id) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-eye me-2"></i>عرض التفاصيل
                        </a>
                    </div>



                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-book"></i>
                <h3 class="mt-3">لا توجد دروس</h3>
                <p class="text-muted">لم يتم إضافة أي دروس لهذا الكورس بعد</p>
                @if(auth()->check() && auth()->user()->is_admin)
                <a href="{{ route('lessons.create', $course->id) }}" class="btn btn-zid mt-3">
                    <i class="fas fa-plus-circle me-2"></i>إضافة أول درس
                </a>
                @endif
            </div>
        </div>
        @endforelse
    </div>