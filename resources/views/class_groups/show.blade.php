@extends('layouts.app')

@section('title', 'إدارة الحلقات')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #4da1b4 0%, #64dada 100%);
        color: white;
        border-radius: 18px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    /* === الحل السحري: Flexbox جنباً إلى جنب === */
    .cards-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        margin-top: 20px;
    }

    .class-card {
        flex: 0 1 300px; /* كل كارد عرض ثابت 300px */
        background: white;
        border-radius: 16px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .class-header {
        background: linear-gradient(135deg, #4da1b4 0%, #64dada 100%);
        color: white;
        padding: 1rem;
        text-align: center;
    }

    .class-header h5 {
        margin: 0;
        font-size: 1.2rem;
    }

    .class-body {
        padding: 1.2rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .info-item i {
        color: #4da1b4;
        width: 20px;
    }

    .groups-title {
        color: #4da1b4;
        font-size: 1rem;
        margin: 1rem 0 0.5rem 0;
        border-bottom: 1px dashed #dee2e6;
        padding-bottom: 0.3rem;
    }

    .group-item {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 0.5rem;
        margin-bottom: 0.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .group-name {
        font-weight: 600;
        color: #4da1b4;
    }

    .teacher-name {
        font-size: 0.8rem;
        color: #e67e22;
    }

    .student-count {
        background: #e9ecef;
        padding: 0.2rem 0.5rem;
        border-radius: 12px;
        font-size: 0.8rem;
    }

    .stats-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
        margin-bottom: 30px;
    }

    .stat-card {
        flex: 0 1 200px;
        background: linear-gradient(135deg, #4da1b4 0%, #64dada 100%);
        color: white;
        border-radius: 16px;
        padding: 1rem;
        text-align: center;
    }

    .stat-card.purple { background: linear-gradient(135deg, #9b6b9b 0%, #c47ac4 100%); }
    .stat-card.green { background: linear-gradient(135deg, #2d6a4f 0%, #40916c 100%); }
    .stat-card.orange { background: linear-gradient(135deg, #e67e22 0%, #f39c12 100%); }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
    }
</style>

<div class="container py-4">
  

    <!-- Stats Cards -->
    <div class="stats-row m-5 p-5">
        <div class="stat-card ">
            <i class="bi bi-diagram-3"></i>
            <div class="stat-number">{{ $classTypes->count() ?? 0 }}</div>
            <div>إجمالي الحلقات</div>
        </div>
        <div class="stat-card purple">
            <i class="bi bi-people"></i>
            <div class="stat-number">{{ $totalStudents ?? 0 }}</div>
            <div>إجمالي الطلاب</div>
        </div>
        <div class="stat-card green">
            <i class="bi bi-person-badge"></i>
            <div class="stat-number">{{ $totalTeachers ?? 0 }}</div>
            <div>عدد المعلمين</div>
        </div>

    </div>

    <!-- ===== الكاردات جنباً إلى جنب ===== -->
    <div class="cards-row">
        @forelse($classTypes as $classType)
            <div class="class-card">
                <div class="class-header">
                    <h5>{{ $classType->name }}</h5>
                </div>

                <div class="class-body">
                    <!-- معلومات الحلقة -->
                    <div class="info-item">
                        <i class="bi bi-calendar"></i>
                        <span>العمر: {{ $classType->age_from }} - {{ $classType->age_to ?? 'فما فوق' }} سنة</span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-clock"></i>
                        <span>الوقت: {{ \Carbon\Carbon::parse($classType->start_time)->format('H:i') }}</span>
                    </div>


                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 3rem; width: 100%;">
                <i class="bi bi-diagram-3 fs-1 text-muted"></i>
                <h5 class="mt-3 text-muted">لا توجد حلقات</h5>
            </div>
        @endforelse
    </div>
</div>
@endsection