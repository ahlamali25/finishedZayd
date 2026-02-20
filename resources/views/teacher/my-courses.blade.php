<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لوحة المعلم</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        body{background:#f5f7fb;}
        .sidebar{
            width:230px;
            min-height:100vh;
            background:#1b4332;
            color:#fff;
        }
        .sidebar a{
            color:#d8f3dc;
            text-decoration:none;
            display:block;
            padding:10px 15px;
            border-radius:12px;
            margin-bottom:6px;
            font-size:14px;
        }
        .sidebar a.active,
        .sidebar a:hover{
            background:#2d6a4f;
            color:#fff;
        }
        .card-box{
            border-radius:18px;
            box-shadow:0 10px 25px rgba(0,0,0,.05);
        }
        .banner{
            background:#2d6a4f;
            color:#fff;
            border-radius:18px;
        }
    </style>
</head>

<body>
<div class="d-flex">

<!-- Sidebar -->
<div class="sidebar p-3">
    <h5 class="mb-4">
        <i class="bi bi-person-badge"></i> لوحة المعلم
    </h5>

    <!-- Dashboard -->
    <a href="{{ route('teacher.dashboard') }}" class="active">
        <i class="bi bi-speedometer2 me-2"></i>
        لوحة التحكم
    </a>

   <!-- My Courses -->
<a href="{{ route('teacher.my-courses') }}">
    <i class="bi bi-book me-2"></i>
    كورساتي
</a>

 

    <!-- Home -->
    <a href="{{ route('home') }}">
        <i class="bi bi-house-door me-2"></i>
        الصفحة الرئيسية
    </a>

    <!-- Logout -->
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-right me-2"></i>
        تسجيل الخروج
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>


    <!-- Content -->
    <div class="flex-grow-1 p-4">

        <!-- Banner -->
        <div class="banner p-4 mb-4 d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-1">التاريخ: {{ now()->format('Y-m-d') }}</p>
                <h4>مرحباً بك، {{"آ." . auth()->user()->name }} 👨‍🏫</h4>
                <small>
                    عدد الكورسات: {{ $courses->count() }} 
                  
                </small>
            </div>

            <img src="{{ asset('img/studentD.jpeg') }}" width="90"
                 class="rounded-circle bg-white p-2">
        </div>

        <!-- Courses -->
        <div class="d-flex justify-content-between mb-2">
            <h5>الكورسات التي أدرّسها</h5>
        </div>

        <div class="row g-3">
            @forelse($courses as $course)
                <div class="col-md-6">
                    <div class="card card-box p-3">
                        <h6>{{ $course->name }}</h6>
                        <p class="text-muted small mb-2">
                            {{ $course->description }}
                        </p>
                        <a href="{{ route('lessons.learn', $course->id) }}"
                           class="btn btn-success btn-sm">
                            إدارة الكورس
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-muted">لا توجد كورسات.</p>
            @endforelse
        </div>

    


    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>