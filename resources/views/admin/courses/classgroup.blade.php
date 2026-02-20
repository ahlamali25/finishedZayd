<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تعيين كورسات الحلقة</title>

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
            margin-bottom: 28px;
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

        .form-select {
            border: 2px solid #e8ecf1;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            background-color: #f9fafb;
        }

        .form-select:focus {
            border-color: #4da1b4;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(77, 161, 180, 0.1);
        }

        .form-select option {
            padding: 8px;
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
            margin-top: 15px;
        }

        .course-checkbox {
            position: relative;
        }

        .course-checkbox input[type="checkbox"] {
            display: none;
        }

        .course-checkbox label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            background: white;
            border: 2px solid #e8ecf1;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0;
            font-weight: 500;
            color: #555;
            font-size: 14px;
        }

        .course-checkbox label:hover {
            border-color: #4da1b4;
            background: #f0f8fa;
            transform: translateY(-2px);
        }

        .course-checkbox input[type="checkbox"]:checked+label {
            background: linear-gradient(135deg, #4da1b4 0%, #64dada 100%);
            color: white;
            border-color: #4da1b4;
            box-shadow: 0 5px 15px rgba(77, 161, 180, 0.3);
        }

        .checkbox-icon {
            width: 18px;
            height: 18px;
            border: 2px solid currentColor;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .course-checkbox input[type="checkbox"]:checked~label .checkbox-icon::after {
            content: '✓';
            color: white;
            font-weight: bold;
            font-size: 12px;
        }

        .courses-hint {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
            font-size: 13px;
            color: #7f8c8d;
        }

        .courses-hint i {
            color: #4da1b4;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 32px;
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
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(77, 161, 180, 0.3);
            color: white;
            text-decoration: none;
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
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-back:hover {
            background: #dde3eb;
            color: #333;
            transform: translateY(-2px);
        }

        .section-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e8ecf1, transparent);
            margin: 25px 0;
        }

        .required-mark {
            color: #e74c3c;
            font-weight: bold;
        }

        @media (max-width: 600px) {
            .form-body {
                padding: 20px;
            }

            .form-header {
                padding: 20px;
            }

            .courses-grid {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
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
                <i class="bi bi-diagram-3"></i>
                <h2>تعيين كورسات الحلقة</h2>
                <p>قم بربط الدورات الدراسية بمجموعات الطلاب</p>
            </div>

            <!-- Form Body -->
            <div class="form-body">
                <form method="POST" action="{{ route('admin.class-groups.assign.store') }}">
                    @csrf

                    <!-- نوع الحلقة -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-bookmark"></i>
                            نوع الحلقة
                            <span class="required-mark">*</span>
                        </label>
                        <select name="class_type_id" class="form-select" required>
                            <option value="">-- اختر نوع الحلقة --</option>
                            @foreach ($classTypes as $type)
                                <option value="{{ $type->id }}">
                                    <i class="bi bi-bookmark"></i> {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="section-divider"></div>

                    <!-- المعلمة المشرفة -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-person-fill"></i>
                            المعلمة المشرفة
                            <span class="required-mark">*</span>
                        </label>
                        <select name="teacher_id" class="form-select" required>
                            <option value="">-- اختر المعلمة --</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">
                                    👩‍🏫 {{ $teacher->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="section-divider"></div>

                    <!-- كورسات الحلقة -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-collection-fill"></i>
                            كورسات الحلقة
                            <span class="required-mark">*</span>
                        </label>

                        <div class="courses-section">
                            @if ($courses->count() > 0)
                                <div class="courses-grid">
                                    @foreach ($courses as $course)
                                        <div class="course-checkbox">
                                            <input type="checkbox" name="courses[]" value="{{ $course->id }}"
                                                id="course{{ $course->id }}">
                                            <label for="course{{ $course->id }}">
                                                <span class="checkbox-icon"></span>
                                                {{ $course->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="courses-hint">
                                    <i class="bi bi-info-circle"></i>
                                    <span>اختر دورة واحدة أو أكثر للحلقة</span>
                                </div>
                            @else
                                <div class="alert alert-info mb-0" role="alert">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    لا توجد دورات متاحة حالياً
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-check-circle"></i>
                            حفظ التعيين
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
