@extends('layouts.app')

@section('title', 'تفاصيل الحلقة ' . $classGroup->group_number . ' - مركز زيد بن ثابت')

@section('content')
    <div class="container py-5">
        <!-- رأس الصفحة -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="text-primary mb-3">
                    <i class="fas fa-users me-2"></i>
                    تفاصيل الحلقة {{ $classGroup->group_number }}
                </h1>

                @if ($classGroup->teacher)
                    <p class="text-muted">
                        <i class="fas fa-user-tie me-2"></i>
                        المعلم المشرف: {{ $classGroup->teacher->name }}
                    </p>
                @endif
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('class_groups.courses', $classGroup) }}" class="btn btn-primary">
                    <i class="fas fa-book me-2"></i>
                    عرض الكورسات
                </a>
            </div>
        </div>

        <!-- معلومات الحلقة -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">معلومات الحلقة</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>رقم الحلقة:</strong> {{ $classGroup->group_number }}</p>
                        <p><strong>السعة:</strong> {{ $classGroup->capacity }}</p>
                        <p><strong>المسجلين حالياً:</strong> {{ $classGroup->current_count }}</p>
                        <p><strong>نوع الحلقة:</strong> {{ $classGroup->classType->name ?? 'غير محدد' }}</p>
                        <p><strong>تاريخ الإنشاء:</strong> {{ $classGroup->created_at->format('Y-m-d') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">الطلاب المسجلين</h5>
                    </div>
                    <div class="card-body">
                        @if ($classGroup->users->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach ($classGroup->users as $user)
                                    <li class="list-group-item">{{ $user->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">لا يوجد طلاب مسجلين بعد.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
