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
                    {{-- معلومات المتقدم --}}
                    <div class="mb-4">
                        <h6 class="text-muted">معلومات المتقدم</h6>
                        <hr>
                        <p><strong>الاسم:</strong> {{ $application->user->name }}</p>
                        <p><strong>البريد الإلكتروني:</strong> {{ $application->user->email }}</p>
                    </div>

                    {{-- تفاصيل الطلب --}}
                    <div class="mb-4">
                        <h6 class="text-muted">تفاصيل الطلب</h6>
                        <hr>

                        <p><strong>التخصص:</strong> {{ $application->specialization }}</p>

                        {{-- قسم الشهادة --}}
                        <div class="mb-3">
                            <p><strong>شهادة الاختصاص:</strong></p>

                            @if($application->certificate_path)
                                @php
                                    $filePath = storage_path('app/public/' . $application->certificate_path);
                                    $fileExists = file_exists($filePath);
                                @endphp

                                @if($fileExists)
                                    <div class="mb-2">
                                        <a href="{{ Storage::url($application->certificate_path) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           target="_blank">
                                            <i class="bi bi-download me-1"></i>
                                            عرض/تحميل الشهادة
                                        </a>

                                    </div>
                                @else
                                    <div class="alert alert-warning p-2">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        ملف الشهادة غير موجود على الخادم (تم رفعه مسبقاً لكن الملف مفقود)
                                    </div>
                                @endif
                            @else
                                <p class="text-muted">
                                    <i class="bi bi-file-earmark-x me-1"></i>
                                    لم يتم رفع شهادة لهذا الطلب
                                </p>
                            @endif
                        </div>

                        {{-- الخبرة --}}
                        <div class="mb-3">
                            <p><strong>الخبرة:</strong></p>
                            <div class="p-3 bg-light rounded">
                                {{ $application->experience ?: 'لا توجد خبرة مذكورة' }}
                            </div>
                        </div>

                        {{-- الدافع --}}
                        <div class="mb-3">
                            <p><strong>الدافع:</strong></p>
                            <div class="p-3 bg-light rounded">
                                {{ $application->motivation ?: 'لا يوجد دافع مذكور' }}
                            </div>
                        </div>
                    </div>

                    {{-- الحالة والمراجعة --}}
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

                        {{-- معلومات المعالجة --}}
                        @if($application->processed_at)
                            <div class="mt-3">
                                <p><strong>تم المعالجة بواسطة:</strong>
                                    @if($application->processed_by)
                                        @php
                                            $processor = App\Models\User::find($application->processed_by);
                                        @endphp
                                        {{ $processor->name ?? 'مستخدم غير معروف' }}
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </p>
                                <p><strong>وقت المعالجة:</strong> {{ \Carbon\Carbon::parse($application->processed_at)->format('Y-m-d H:i') }}</p>
                            </div>
                        @endif

                        {{-- ملاحظات المراجعة --}}
                        @if($application->review_notes)
                            <div class="mt-3">
                                <p><strong>ملاحظات المراجعة:</strong></p>
                                <div class="p-3 bg-light rounded">
                                    {{ $application->review_notes }}
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- إجراءات المراجعة (للمعلمين فقط) --}}
                    @if($application->status == 'pending')
                        <div class="mt-4">
                            <h6 class="text-muted mb-3">إجراءات المراجعة</h6>
                            <hr>

                            {{-- نموذج الموافقة --}}
                            <form action="{{ route('admin.teacher-applications.approve', $application->id) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">ملاحظات عند الموافقة (اختياري):</label>
                                    <textarea class="form-control" name="review_notes" rows="3" placeholder="أضف ملاحظاتك هنا..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100"
                                        onclick="return confirm('هل أنت متأكد من الموافقة على هذا الطلب؟')">
                                    <i class="bi bi-check-circle me-2"></i>
                                    الموافقة على الطلب
                                </button>
                            </form>

                            {{-- نموذج الرفض --}}
                            <form action="{{ route('admin.teacher-applications.reject', $application->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">سبب الرفض <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="review_notes" rows="3"
                                              placeholder="اشرح سبب رفض الطلب..."
                                              required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger w-100"
                                        onclick="return confirm('هل أنت متأكد من رفض هذا الطلب؟')">
                                    <i class="bi bi-x-circle me-2"></i>
                                    رفض الطلب
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