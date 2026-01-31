<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل كورس</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f5f7fb">

<div class="container mt-5">

    <div class="card shadow p-4">
        <h4 class="mb-4">✏️ تعديل الكورس</h4>

        <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">اسم الكورس</label>
                <input type="text" name="name"
                       value="{{ old('name', $course->name) }}"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">وصف الكورس</label>
                <textarea name="description"
                          class="form-control"
                          rows="4"
                          required>{{ old('description', $course->description) }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-success">💾 حفظ التعديلات</button>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                    رجوع
                </a>
            </div>
        </form>
    </div>

</div>

</body>
</html>
