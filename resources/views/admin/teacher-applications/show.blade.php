<!-- resources/views/admin/teacher-applications/show.blade.php -->
@extends('layouts.app')

@section('title', 'تفاصيل الطلب')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">تفاصيل طلب التدريس</h5>
                    <a href="{{ route('admin.teacher-applications.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-right me-1"></i>رجوع
                    </a>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-muted">معلومات المتقدم</h6>
                        <hr>
                        <p><strong>الاسم:</strong> {{ $application->user->name }}</p>
                        <p><strong>البريد الإلكتروني:</strong> {{ $application->user->email }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted">تفاصيل الطلب</h6>
                        <hr>
                        <p><strong>التخصص:</strong> {{ $application->specialization }}</p>

                        @if($application->certificate_path)
                            <p><strong>شهادة الاختصاص:</strong></p>
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $application->certificate_path) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="bi bi-download me-1"></i>عرض/تحميل الشهادة
                                </a>
                            </div>
                        @else
                            <p><strong>شهادة الاختصاص:</strong> <span class="text-muted">لم يتم رفع شهادة</span></p>
                        @endif

                        <p><strong>الخبرة:</strong></p>
                        <div class="p-3 bg-light rounded">
                            {{ $application->experience }}
                        </div>

                        <p class="mt-3"><strong>الدافع:</strong></p>
                        <div class="p-3 bg-light rounded">
                            {{ $application->motivation }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted">الحالة والمراجعة</h6>
                        <hr>
                        <p><strong>الحالة الحالية:</strong></p>
                        @if($application->status == 'pending')
                            <span class="badge bg-warning p-2">قيد المراجعة</span>
                        @elseif($application->status == 'approved')
                            <span class="badge bg-success p-2">تمت الموافقة</span>
                        @else
                            <span class="badge bg-danger p-2">مرفوض</span>
                        @endif

                        @if($application->processed_at)
                            <p class="mt-2"><strong>تم المعالجة بواسطة:</strong> {{ $application->processedBy->name ?? 'N/A' }}</p>
                            <p><strong>وقت المعالجة:</strong> {{ $application->processed_at->format('Y-m-d H:i') }}</p>
                        @endif

                        @if($application->review_notes)
                            <p class="mt-2"><strong>ملاحظات المراجعة:</strong></p>
                            <div class="p-3 bg-light rounded">
                                {{ $application->review_notes }}
                            </div>
                        @endif
                    </div>

                    @if($application->status == 'pending')
                        <div class="mt-4">
                            <h6 class="text-muted mb-3">إجراءات المراجعة</h6>
                            <hr>

                            <!-- Approve Form -->
                            <form action="{{ route('admin.teacher-applications.approve', $application->id) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">ملاحظات عند الموافقة (اختياري):</label>
                                    <textarea class="form-control" name="review_notes" rows="3" placeholder="أضف ملاحظاتك هنا..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100"
                                        onclick="return confirm('هل أنت متأكد من الموافقة على هذا الطلب؟')">
                                    <i class="bi bi-check-circle me-2"></i>الموافقة على الطلب
                                </button>
                            </form>

                            <!-- Reject Form -->
                            <form action="{{ route('admin.teacher-applications.reject', $application->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">سبب الرفض (مطلوب) *</label>
                                    <textarea class="form-control" name="review_notes" rows="3" placeholder="اشرح سبب رفض الطلب..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger w-100"
                                        onclick="return confirm('هل أنت متأكد من رفض هذا الطلب؟')">
                                    <i class="bi bi-x-circle me-2"></i>رفض الطلب
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection