<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة الإدارة</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #4da1b4;
            color: #fff;
            box-sizing: border-box;
        }

        .sidebar h5 {
            font-weight: bold;
        }

        .sidebar-link,
        .sidebar-logout {
            color: #edf2f4;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border-radius: 12px;
            margin-bottom: 6px;
            font-size: 14px;
            white-space: nowrap;
            background: none;
            border: none;
            width: 100%;
            text-align: start;
            cursor: pointer;
        }

        .sidebar-link:hover,
        .sidebar-logout:hover,
        .sidebar-link.active {
            background: #64dada;
            color: #000;
        }

        .sidebar form {
            margin: 0;
        }

        /* ===== Cards ===== */
        .card-box {
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0,0,0,.05);
        }

        .banner {
            background: #64dada;
            color: #000;
            border-radius: 18px;
        }
    </style>
</head>

<body>

<div class="d-flex">

    <!-- Sidebar -->
    <aside class="sidebar p-3">
        <h5 class="mb-4">
            <i class="bi bi-shield-lock"></i> لوحة الإدارة
        </h5>

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            لوحة التحكم
        </a>

        

        <!-- Groups -->
        <a href="{{ route('admin.class-groups.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.class_groups.*') ? 'active' : '' }}">
            <i class="bi bi-diagram-3"></i>
            الحلقات
        </a>

        <!-- Users -->
        <a href="{{ route('admin.users.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            المستخدمون
        </a>

           <!-- home -->
          <a href="{{ route('home') }}"
           class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            الرئيسية
        </a>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="sidebar-logout">
                <i class="bi bi-box-arrow-right"></i>
                تسجيل الخروج
            </button>
        </form>
    </aside>

    <!-- Content -->
    <main class="flex-grow-1 p-4">

        <!-- Banner -->
        <div class="banner p-4 mb-4 d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-1">التاريخ: {{ now()->format('Y-m-d') }}</p>
                <h4>مرحباً {{ auth()->user()->name }} 👑</h4>
                <small>لوحة تحكم الإدارة العامة</small>
            </div>

            <img src="{{ asset('img/studentD.jpeg') }}"
                 width="90"
                 class="rounded-circle bg-white p-2">
        </div>

        <!-- Statistics -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-box p-3 text-center">
                    <i class="bi bi-people fs-3"></i>
                    <h6 class="mt-2">عدد الطلاب</h6>
                    <h3>{{ $studentsCount }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-box p-3 text-center">
                    <i class="bi bi-person-badge fs-3"></i>
                    <h6 class="mt-2">عدد المعلمين</h6>
                    <h3>{{ $teachersCount }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-box p-3 text-center">
                    <i class="bi bi-book fs-3"></i>
                    <h6 class="mt-2">عدد الكورسات</h6>
                    <h3>{{ $coursesCount }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-box p-3 text-center">
                    <i class="bi bi-diagram-3 fs-3"></i>
                    <h6 class="mt-2">عدد الحلقات</h6>
                    <h3>{{ $classGroupsCount }}</h3>
                </div>
            </div>
        </div>

        <!-- Courses -->
<div class="d-flex justify-content-between align-items-center mb-3">

    <h5 class="mb-0">أحدث الكورسات</h5>

    <div class="d-flex gap-2">

        <!-- إضافة كورس -->
        <a href="{{ route('admin.courses.create') }}"
           class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i>
            إضافة كورس
        </a>

        <!-- اختيار كورسات الحلقة -->
        <a href="{{ route('admin.courses.classgroup') }}"
           class="btn btn-primary btn-sm">
            <i class="bi bi-diagram-3"></i>
            تعيين كورسات الحلقة
        </a>

        <!-- إضافة إعلان -->
        <a href="{{ route('admin.announcements.create') }}"
           class="btn btn-warning btn-sm">
            <i class="bi bi-megaphone"></i>
            إضافة إعلان
        </a>

    </div>

</div>



        <div class="row g-3">
            @forelse($courses as $course)
                <div class="col-md-6">
                    <div class="card card-box p-3">
                        <h6>{{ $course->name }}</h6>
                        <p class="text-muted small">{{ $course->description }}</p>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.courses.edit', $course->id) }}"
                               class="btn btn-outline-secondary btn-sm">
                                تعديل
                            </a>

                   <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST"
                                onsubmit="return confirmDelete()">
                              @csrf @method('DELETE')
                              <button type="submit" class="btn btn-danger">حذف</button>
                          </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">لا توجد كورسات</p>
            @endforelse
        </div>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function confirmDelete() {
        return confirm('هل أنت متأكد من حذف هذا الكورس؟');
    }
    </script>
</body>
</html>
