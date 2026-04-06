<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تعديل تعيين كورسات الحلقة</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 100%;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #4da1b4 0%, #64dada 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .form-header h2 {
            font-weight: bold;
            font-size: 26px;
        }

        .form-body {
            padding: 35px;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .form-select {
            border-radius: 10px;
            padding: 10px;
        }

        .courses-section {
            background: #f8fafb;
            border-radius: 15px;
            padding: 20px;
            border: 2px dashed #e0e8f0;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .course-checkbox input {
            display: none;
        }

        .course-checkbox label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px;
            background: white;
            border: 2px solid #e8ecf1;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .course-checkbox input:checked + label {
            background: linear-gradient(135deg, #4da1b4 0%, #64dada 100%);
            color: white;
            border-color: #4da1b4;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-submit {
            flex: 1;
            background: linear-gradient(135deg, #4da1b4 0%, #64dada 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
        }

        .btn-back {
            flex: 1;
            background: #e8ecf1;
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>

<body>

<div class="main-container">
    <div class="form-card">

        <!-- Header -->
        <div class="form-header">
            <i class="bi bi-pencil-square" style="font-size:28px;"></i>
            <h2>تعديل تعيين كورسات الحلقة</h2>
            <p>{{ $classType->name }}</p>
        </div>

        <!-- Body -->
        <div class="form-body">

            <form method="POST"
                  action="{{ route('admin.class-groups.update', $classType->id) }}">
                @csrf
                @method('PUT')

                <!-- اختيار المشرفة -->
                <div class="mb-4">
                    <label class="form-label">المعلمة المشرفة</label>
                    <select name="teacher_id" class="form-select" required>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}"
                                {{ $classGroup && $classGroup->teacher_id == $teacher->id ? 'selected' : '' }}>
                                👩‍🏫 {{ $teacher->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- الكورسات -->
                <div class="mb-4">
                    <label class="form-label">كورسات الحلقة</label>

                    <div class="courses-section">
                        <div class="courses-grid">
                            @foreach($courses as $course)
                                <div class="course-checkbox">
                                    <input type="checkbox"
                                           name="courses[]"
                                           value="{{ $course->id }}"
                                           id="course{{ $course->id }}"
                                           {{ $classGroup && $classGroup->courses->contains($course->id) ? 'checked' : '' }}>
                                    <label for="course{{ $course->id }}">
                                        {{ $course->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle"></i>
                        حفظ التعديلات
                    </button>

                    <a href="{{ route('admin.dashboard') }}" class="btn-back">
                        رجوع
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>