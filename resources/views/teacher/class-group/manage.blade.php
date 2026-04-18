<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>إدارة الحلقة</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        body {
            background: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            width: 230px;
            min-height: 100vh;
            background: #1b4332;
            color: #fff;
            position: fixed;
            top: 0;
            right: 0;
        }

        .sidebar a {
            color: #d8f3dc;
            display: block;
            padding: 10px 15px;
            border-radius: 12px;
            margin-bottom: 6px;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2d6a4f;
            color: #fff;
        }

        /* ===== Banner FULL WIDTH ===== */
.banner-full {
    margin-right: 250px;   /* بدل 230 → لنعطي فراغ عن السايدبار */
    margin-left: 20px;     /* مسافة من اليسار */
    margin-top: 20px;      /* مسافة من الأعلى */
    width: calc(100% - 270px); /* تعويض المسافات */
    
    background: #2d6a4f;
    color: #fff;
    padding: 1.5rem 2rem;
    border-radius: 18px; /* صار كامل الحواف */
    
    display: flex;
    justify-content: space-between;
    align-items: center;
}

        .main-content {
            margin-right: 230px;
            padding: 1.5rem;
        }

        .stat-card {
            background: white;
            border-radius: 18px;
            padding: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
            text-align: center;
            border-top: 5px solid #2d6a4f;
            height: 100%;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #1b4332;
        }

        .section-title {
            font-weight: bold;
            margin: 2rem 0 1rem;
            border-bottom: 2px solid #2d6a4f;
            padding-bottom: 5px;
        }

        .table-wrapper {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
        }

        .table thead {
            background: #2d6a4f;
            color: white;
        }
    </style>
</head>

<body>

<div class="d-flex">

    <!-- Sidebar -->
    <div class="sidebar p-3">
        <h5>لوحة المعلم</h5>

        <a href="{{ route('teacher.dashboard') }}">لوحة التحكم</a>
        <a href="{{ route('teacher.my-courses') }}">كورساتي</a>
        <a href="{{ route('teacher.my-classes') }}" class="active">حلقاتي</a>
        <a href="{{ route('home') }}">الرئيسية</a>

        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            تسجيل الخروج
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
    </div>

</div>

<!-- ===== Banner FULL WIDTH ===== -->
<div class="banner-full">
    <div>
        <h4>{{ $classGroup->classType->name }}</h4>
        <p>الحلقة {{ $classGroup->group_number }}</p>
    </div>

    <a href="{{ route('teacher.my-classes') }}" class="btn btn-light">
        رجوع
    </a>
</div>

<!-- Main Content -->
<div class="main-content">

    <!-- Stats -->
    <div class="row g-3">

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-number">{{ $totalStudents }}</div>
                <div>عدد الطلاب</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-number">{{ $totalCourses }}</div>
                <div>عدد الكورسات</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-number">{{ $classGroup->capacity ?? 30 }}</div>
                <div>السعة</div>
            </div>
        </div>

    </div>

    <!-- Students -->
    <h5 class="section-title mt-4">الطلاب</h5>

    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الإيميل</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $i => $student)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Courses -->
    <h5 class="section-title">الكورسات</h5>

    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الكورس</th>
                    <th>الدروس</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $i => $course)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->lessons->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

</body>
</html>