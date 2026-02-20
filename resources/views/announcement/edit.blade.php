@extends('layouts.app')

@section('title', 'تعديل الإعلان')

@section('content')

<style>

/* الخلفية العامة */
body {
    background: #f5f7fb;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* الحاوية الرئيسية */
.main-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

/* كرت الفورم */
.form-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    max-width: 750px;
    width: 100%;
    overflow: hidden;
    border: 1px solid #eef1f5;
}

/* جسم الفورم */
.form-body {
    padding: 35px;
}

/* المجموعات */
.form-group {
    margin-bottom: 28px;
}

/* الليبل */
.form-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 12px;
    font-size: 16px;
}

/* الأيقونات */
.form-label i {
    color: #6fb3c8;
    font-size: 18px;
}

.form-select {
    width: 100% !important;
    display: block;
}


/* الحقول */
.form-select,
.form-control,
textarea {
    border: 2px solid #e8ecf1;
    border-radius: 12px;
    padding: 12px 15px;
    font-size: 15px;
    transition: all 0.25s ease;
    background-color: #f9fbfd;
}

/* فوكس */
.form-select:focus,
.form-control:focus,
textarea:focus {
    border-color: #6fb3c8;
    background-color: #ffffff;
    box-shadow: 0 0 0 3px rgba(111,179,200,0.15);
}

/* الفواصل */
.section-divider {
    height: 1px;
    background: linear-gradient(to right, transparent, #e8ecf1, transparent);
    margin: 25px 0;
}

/* الأزرار */
.form-actions {
    display: flex;
    gap: 12px;
    margin-top: 32px;
}

/* زر الحفظ */
.btn-submit {
    flex: 1;
    background: linear-gradient(135deg, #6fb3c8 0%, #8fd6e1 100%);
    color: white;
    border: none;
    padding: 14px 20px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(111,179,200,0.35);
}

/* زر الرجوع */
.btn-back {
    flex: 1;
    background: #eef2f6;
    color: #555;
    border: none;
    padding: 14px 20px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
}

.btn-back:hover {
    background: #e2e8f0;
    color: #333;
    transform: translateY(-2px);
}

/* النجمة */
.required-mark {
    color: #e74c3c;
    font-weight: bold;
}

/* تنسيق المعلومات */
.alert-info {
    border-radius: 12px;
    background: #f0f7fb;
    border: 1px solid #d6eaf3;
}

/* موبايل */
@media (max-width: 600px) {

    .form-body {
        padding: 20px;
    }

    .form-actions {
        flex-direction: column;
    }

}

</style>


<div class="main-container">
    <div class="form-card">

        <div class="form-body">

            <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- الكورس -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-book"></i>
                        الكورس المطلوب
                    </label>

                    <select name="course_id" class="form-select">
                        <option value="">-- إعلان عام (لجميع الطلاب) --</option>

                        @foreach($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ $announcement->course_id == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="section-divider"></div>

                <!-- العنوان -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-type"></i>
                        عنوان الإعلان
                        <span class="required-mark">*</span>
                    </label>

                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old('title', $announcement->title) }}"
                           maxlength="255"
                           required>
                </div>

                <div class="section-divider"></div>

                <!-- المحتوى -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-text-paragraph"></i>
                        محتوى الإعلان
                        <span class="required-mark">*</span>
                    </label>

                    <textarea name="content"
                              class="form-control"
                              rows="6"
                              maxlength="5000"
                              required>{{ old('content', $announcement->content) }}</textarea>
                </div>

                <div class="section-divider"></div>

                <!-- معلومات -->
                <div class="alert alert-info mb-0">
                    <div class="row text-center text-md-start">

                        <div class="col-md-4">
                            <strong>الناشر:</strong><br>
                            {{ auth()->user()->name }}
                        </div>

                        <div class="col-md-4">
                            <strong>البريد:</strong><br>
                            {{ auth()->user()->email }}
                        </div>

                        <div class="col-md-4">
                            <strong>تاريخ الإنشاء:</strong><br>
                            {{ $announcement->created_at->format('d/m/Y - h:i A') }}
                        </div>

                    </div>
                </div>

                <!-- Buttons -->
                <div class="form-actions">

                    <a href="{{ route('admin.announcements.index') }}" class="btn-back">
                        <i class="bi bi-x-circle"></i>
                        إلغاء
                    </a>

                    <button type="submit" class="btn-submit">
                        <i class="bi bi-save"></i>
                        تحديث الإعلان
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

@endsection
