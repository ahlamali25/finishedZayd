<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تعديل كورس</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            margin-bottom: 8px;
            font-size: 28px;
        }

        .form-header p {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }

        .form-header i {
            font-size: 32px;
            margin-bottom: 10px;
            display: block;
        }

        .form-body {
            padding: 35px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .form-label i {
            color: #4da1b4;
            font-size: 18px;
        }

        .form-select,
        .form-control,
        textarea {
            border: 2px solid #e8ecf1;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            background-color: #f9fafb;
        }

        .form-select:focus,
        .form-control:focus,
        textarea:focus {
            border-color: #4da1b4;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(77, 161, 180, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-submit {
            flex: 1;
            background: linear-gradient(135deg, #4da1b4 0%, #64dada 100%);
            color: white;
            border: none;
            padding: 14px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-back {
            flex: 1;
            background: #e8ecf1;
            color: #555;
            border: none;
            padding: 14px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            .form-body {
                padding: 20px;
            }

            .form-header {
                padding: 20px;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<div class="main-container">
    <div class="form-card">

        <!-- Header -->
        <div class="form-header">
            <i class="bi bi-pencil-square"></i>
            <h2>تعديل الكورس</h2>
            <p>يمكنك تعديل بيانات الكورس والمعلم وعدد الحصص</p>
        </div>

        <!-- Form -->
        <div class="form-body">
            <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- اسم الكورس -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-book"></i>
                        اسم الكورس
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $course->name) }}"
                           class="form-control"
                           required>
                </div>

                <!-- الوصف -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-card-text"></i>
                        وصف الكورس
                    </label>
                    <textarea name="description"
                              class="form-control"
                              rows="4"
                              required>{{ old('description', $course->description) }}</textarea>
                </div>

                <!-- عدد الحصص -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-clock"></i>
                        عدد الحصص
                    </label>
                    <input type="number"
                           name="total_sessions"
                           value="{{ old('total_sessions', $course->total_sessions) }}"
                           class="form-control"
                           required>
                </div>

                <!-- المعلم -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-person-badge"></i>
                        المعلم
                    </label>
                    <select name="teacher_id" class="form-select" required>

                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}"
                                {{ $course->teacher_id == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->user->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- Buttons -->
                <div class="form-actions">

                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle"></i>
                        حفظ التعديلات
                    </button>

                    <a href="{{ route('admin.dashboard') }}" class="btn-back">
                        <i class="bi bi-arrow-right-circle"></i>
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
