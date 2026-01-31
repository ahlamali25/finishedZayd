<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة كورس</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f5f7fb">

<div class="container mt-5">

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">➕ إضافة كورس جديد</h5>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.courses.store') }}">
                @csrf

                <!-- اسم الكورس -->
                <div class="mb-3">
                    <label class="form-label">اسم الكورس</label>
                    <input type="text" name="name"
                           class="form-control"
                           required>
                </div>

                <!-- وصف الكورس -->
                <div class="mb-3">
                    <label class="form-label">وصف الكورس</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3"
                              required></textarea>
                </div>

                <!-- عدد الحصص -->
                <div class="mb-3">
                    <label class="form-label">عدد الحصص</label>
                    <input type="number"
                           name="total_sessions"
                           class="form-control"
                           required>
                </div>

                <!-- المعلم -->
                <div class="mb-3">
                    <label class="form-label">المعلم</label>
                    <select name="teacher_id" class="form-select" required>
                        <option value="">-- اختر المعلم --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">
                                {{ $teacher->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- نوع الحلقة -->
                <div class="mb-4">
                    <label class="form-label">نوع الحلقة</label>
                    <select name="class_type_id" class="form-select">
                        <option value="">-- اختر النوع --</option>
                        @foreach($classTypes as $type)
                            <option value="{{ $type->id }}">
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- أزرار -->
                <div class="d-flex gap-2">
                    <button class="btn btn-success">
                        حفظ
                    </button>

                    <a href="{{ route('admin.dashboard') }}"
                       class="btn btn-secondary">
                        رجوع
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>
