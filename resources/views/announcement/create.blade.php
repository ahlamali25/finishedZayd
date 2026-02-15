@extends('layouts.app')

@section('title', 'إضافة إعلان جديد')
@section('page-title', 'إضافة إعلان جديد')
@section('icon', 'bi-plus-circle')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle me-2"></i> إعلان جديد
                    </h4>
                    {{-- <a href="{{ route('admin.announcements.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-right me-1"></i> رجوع
                    </a> --}}
                </div>
            </div>

            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger">
                    <h6><i class="bi bi-exclamation-triangle me-2"></i> يوجد أخطاء في المدخلات:</h6>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('admin.announcements.store') }}" method="POST" id="announcementForm">
                    @csrf

                    <!-- معلومات أساسية -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="border-start border-3 border-primary ps-3">
                                <h5 class="text-primary mb-2">
                                    <i class="bi bi-info-circle me-2"></i> معلومات أساسية
                                </h5>
                                <p class="text-muted mb-0">املأ معلومات الإعلان الأساسية</p>
                            </div>
                        </div>
                    </div>

                    <!-- اختيار الكورس -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="course_id" class="form-label fw-bold">
                                <i class="bi bi-book me-1"></i> الكورس المعلن عنه
                                <span class="text-muted fs-6">(اختياري)</span>
                            </label>
                            <select name="course_id" id="course_id" class="form-select select2" style="width: 100%">
                                <option value="">-- إعلان عام (لجميع الكورسات) --</option>
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }}
                                    @if($course->level)
                                    - <span class="text-muted">({{ $course->level }})</span>
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                اختر كورساً محدداً إذا كان الإعلان خاصاً به، أو اتركه فارغاً للإعلان العام
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="bi bi-lightbulb me-1"></i> نصيحة
                                    </h6>
                                    <i class="bi bi-eye me-2"></i> معاينة الإعلان
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <h5 id="previewTitle" class="text-primary"></h5>
                                    <div id="previewContent" class="text-muted"></div>
                                    <hr>
                                    <div class="small text-muted">
                                        <i class="bi bi-person me-1"></i> الناشر: {{ Auth::user()->name }} |
                                        <i class="bi bi-calendar me-1"></i> التاريخ: {{ now()->format('Y/m/d') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- معلومات الناشر -->
                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle fs-4 me-3"></i>
                            <div>
                                <strong class="d-block">معلومات الناشر</strong>
                                <div class="small">
                                    <span class="me-3">
                                        <i class="bi bi-person me-1"></i> {{ Auth::user()->name }}
                                    </span>
                                    <span class="me-3">
                                        <i class="bi bi-envelope me-1"></i> {{ Auth::user()->email }}
                                    </span>
                                    <span>
                                        <i class="bi bi-clock me-1"></i> {{ now()->format('d/m/Y - h:i A') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- أزرار التحكم -->
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between border-top pt-4">
                                <div>
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-x-circle me-1"></i> إلغاء
                                    </a>

                                    {{-- <button type="button" class="btn btn-outline-info ms-2" id="previewBtn">
                                        <i class="bi bi-eye me-1"></i> معاينة
                                    </button> --}}
                                </div>

                                <div class="btn-group">
                                    <button type="reset" class="btn btn-outline-warning">
                                        <i class="bi bi-arrow-clockwise me-1"></i> إعادة تعيين
                                    </button>

                                    <button type="submit" class="btn btn-success px-4" id="submitBtn">
                                        <i class="bi bi-check-circle me-2"></i> حفظ الإعلان
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-label {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-control-lg {
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 1.1rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
    }

    .card-header.bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    #content {
        resize: vertical;
        min-height: 250px;
        line-height: 1.6;
    }

    #previewSection {
        transition: all 0.3s ease;
    }

    #previewTitle {
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // عناصر DOM
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    const titleCounter = document.getElementById('titleCounter');
    const contentCounter = document.getElementById('contentCounter');
    const previewBtn = document.getElementById('previewBtn');
    const previewSection = document.getElementById('previewSection');
    const previewTitle = document.getElementById('previewTitle');
    const previewContent = document.getElementById('previewContent');
    const courseSelect = document.getElementById('course_id');
    const submitBtn = document.getElementById('submitBtn');

    const maxTitleLength = 255;
    const maxContentLength = 5000;

    // تحديث عداد العنوان
    titleInput.addEventListener('input', function() {
        const length = this.value.length;
        titleCounter.textContent = length;

        if (length > maxTitleLength * 0.9) {
            titleCounter.style.color = '#ffc107';
        } else if (length >= maxTitleLength) {
            this.value = this.value.substring(0, maxTitleLength);
            titleCounter.textContent = maxTitleLength;
            titleCounter.style.color = '#dc3545';
        } else {
            titleCounter.style.color = '#28a745';
        }
    });

    // تحديث عداد المحتوى
    contentInput.addEventListener('input', function() {
        const length = this.value.length;
        contentCounter.textContent = length;

        if (length > maxContentLength * 0.9) {
            contentCounter.style.color = '#ffc107';
        } else if (length >= maxContentLength) {
            this.value = this.value.substring(0, maxContentLength);
            contentCounter.textContent = maxContentLength;
            contentCounter.style.color = '#dc3545';
        } else {
            contentCounter.style.color = '#28a745';
        }

        // تعديل الارتفاع التلقائي
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // تهيئة القيم الأولية
    titleCounter.textContent = titleInput.value.length;
    contentCounter.textContent = contentInput.value.length;

    // معاينة الإعلان
    previewBtn.addEventListener('click', function() {
        const title = titleInput.value.trim() || 'عنوان الإعلان';
        const content = contentInput.value.trim() || 'محتوى الإعلان سوف يظهر هنا...';

        previewTitle.textContent = title;
        previewContent.textContent = content;

        previewSection.style.display = 'block';

        // التمرير للمعاينة
        previewSection.scrollIntoView({ behavior: 'smooth' });

        // تغيير نص الزر
        this.innerHTML = '<i class="bi bi-eye-slash me-1"></i> إخفاء المعاينة';
        this.setAttribute('onclick', "document.getElementById('previewSection').style.display='none'; this.innerHTML='<i class=\'bi bi-eye me-1\'></i> معاينة';");
    });

    // التحقق قبل الإرسال
    document.getElementById('announcementForm').addEventListener('submit', function(e) {
        const title = titleInput.value.trim();
        const content = contentInput.value.trim();

        // التحقق من العنوان
        if (title.length < 3) {
            e.preventDefault();
            showAlert('warning', 'عنوان قصير جداً', 'عنوان الإعلان يجب أن يكون على الأقل 3 أحرف');
            titleInput.focus();
            return false;
        }
        // التحقق من المحتوى
        if (content.length < 10) {
            e.preventDefault();
            showAlert('warning', 'محتوى قصير جداً', 'محتوى الإعلان يجب أن يكون على الأقل 10 أحرف');
            contentInput.focus();
            return false;
        }

        // تعطيل الزر أثناء الإرسال
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> جاري الحفظ...';
    });

    // دالة لعرض التنبيهات
    function showAlert(type, title, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3;
        alertDiv.style.zIndex = '9999';
        alertDiv.style.minWidth = '400px';
        alertDiv.innerHTML = 
            <strong>${title}</strong><br>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        ;

        document.body.appendChild(alertDiv);

        // إزالة التنبيه تلقائياً بعد 5 ثواني
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }

    // إضافة تأثير للزر عند التمرير
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            submitBtn.classList.add('shadow-lg');
        } else {
            submitBtn.classList.remove('shadow-lg');
        }
    });

    // تحسين تجربة المستخدم مع select2 (اختياري)
    if (typeof $ !== 'undefined') {
        $(document).ready(function() {
            $('#course_id').select2({
                placeholder: "اختر كورس (اختياري)",
                allowClear: true,
                language: {
                    noResults: function() {
                        return "لا توجد نتائج";
                    }
                }
            });
        });
    }
});
</script>
@endpush