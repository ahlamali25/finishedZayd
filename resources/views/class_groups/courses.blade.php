@extends('layouts.app')

@section('title', 'كورسات الحلقة ' . $classGroup->group_number . ' - مركز زيد بن ثابت')

@section('content')
<div class="container py-5">
    <!-- رأس الصفحة -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="text-primary mb-3">
                <i class="fas fa-book me-2"></i>
                كورسات الحلقة {{ $classGroup->group_number }}
            </h1>

            @if($classGroup->teacher)
            <p class="text-muted">
                <i class="fas fa-user-tie me-2"></i>
                المعلم المشرف: {{ $classGroup->teacher->name }}
            </p>
            @endif
        </div>
    </div>

    <!-- معلومات الحلقة -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <h6 class="text-muted">رقم الحلقة</h6>
                                <h4 class="text-primary">{{ $classGroup->group_number }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <h6 class="text-muted">السعة</h6>
                                <h4>{{ $classGroup->capacity }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <h6 class="text-muted">المسجلين</h6>
                                <h4>{{ $classGroup->current_count }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <h6 class="text-muted">الكورسات</h6>
                                <h4>{{ $classGroup->classType->courses->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- قائمة الكورسات -->
    <div class="row">
        @forelse($classGroup->classType->courses as $course)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $course->name }}</h5>

                    @if($course->description)
                    <p class="card-text text-muted mb-3">
                        {{ Str::limit($course->description, 100) }}
                    </p>
                    @endif

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">
                                <i class="fas fa-play-circle me-1"></i>
                                {{ $course->lessons_count }} درس
                            </span>
                            <span class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                {{ $course->total_sessions ?? 0 }} جلسة
                            </span>
                        </div>
                    </div>

                    <!-- زر عرض الدروس (يفتح صفحة جديدة مع التركيز على هذا الكورس) -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @if($course->teacher)
                            <small class="text-muted">
                                <i class="fas fa-chalkboard-teacher me-1"></i>
                                {{ $course->teacher->name }}
                            </small>
                            @endif
                        </div>
                        <a href="{{ route('lessons.learn', $course->id) }}"
                           class="btn btn-primary btn-sm"
                           data-bs-toggle="collapse"
                           data-bs-target="#lessons-{{ $course->id }}">
                            <i class="fas fa-eye me-1"></i> عرض الدروس
                        </a>
                    </div>
                </div>

                <!-- قائمة الدروس المنبثقة -->
                <div class="collapse" id="lessons-{{ $course->id }}">
                    <div class="card-footer bg-light">
                        <h6 class="mb-3">دروس الكورس:</h6>
                        @forelse($course->lessons as $lesson)
                        <div class="mb-2 border-bottom pb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $lesson->title }}</h6>
                                    @if($lesson->date)
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($lesson->date)->translatedFormat('d/m/Y') }}
                                    </small>
                                    @endif
                                </div>
                                @if($lesson->video_link)
                                <a href="{{ $lesson->video_link }}"
                                   class="btn btn-sm btn-outline-primary"
                                   target="_blank">
                                    <i class="fas fa-play me-1"></i> مشاهدة
                                </a>
                                @else
                                <span class="badge bg-secondary">قريباً</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center mb-0">لا توجد دروس حالياً</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-book fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">لا توجد كورسات لهذه الحلقة حالياً</h4>
        </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
.card {
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
</style>
@endpush
@endsection